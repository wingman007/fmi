<?php

namespace CsnUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;

use CsnUser\Form\UserForm;
use CsnUser\Form\UserFilter;

// ZF2 Hydrators
use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\Stdlib\Hydrator\ArraySerializable; // default hydrator for the form
use Zend\Stdlib\Hydrator\ClassMethods;


// The objects are RowGateway
use Zend\Db\RowGateway\RowGateway;

class UserRowGatewayFeatureBindController extends AbstractActionController
{
	private $usersTable;
	
	// R -retrieve 	CRUD
	public function indexAction()
	{
		return new ViewModel(array('rowset' => $this->getUsersTable()->select()));
	}
	
	// C -Create
	public function createAction()
	{
		$form = new UserForm();
		$form->setHydrator(new ObjectProperty()); 

		$user = new RowGateway('usr_id', 'users', $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
		$form->bind($user);
		
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			$form->remove('submit');
			 if ($form->isValid()) {
				$user->save(); // The user is already hydrated by the form
				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-row-gateway-feature-bind', 'action' => 'index'));										
			}
			$form->add(array( // bring back the button in case of validation errors
				'name' => 'submit',
				'attributes' => array(
					'type'  => 'submit',
					'value' => 'Go',
					'id' => 'submitbutton',
				),
			));
		}		
		
		return new ViewModel(array('form' => $form));
	}
	
	// U -Update
	public function updateAction()
	{
		$id = $this->params()->fromRoute('id');
		if (!$id) return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-row-gateway-feature-bind', 'action' => 'index'));
		$form = new UserForm();
		$form->setHydrator(new ObjectProperty());
		
		$user = $this->getUsersTable()->select(array('usr_id' => $id))->current();
		$form->bind($user);
		
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			$form->remove('submit');
			if ($form->isValid()) {
				$user->save();
				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-row-gateway-feature-bind', 'action' => 'index'));													
			}
			$form->add(array( // bring back the button in case of validation errors
				'name' => 'submit',
				'attributes' => array(
					'type'  => 'submit',
					'value' => 'Go',
					'id' => 'submitbutton',
				),
			));			
		}
		else {
			// ToDo find why the form doesn't get populated from the object directly and remove this line 
			$form->setData($this->getUsersTable()->select(array('usr_id' => $id))->current()->toArray());			
		}

		return new ViewModel(array('form' => $form, 'id' => $id));		
	}
	
	// D -Delete
	public function deleteAction()
	{
		$id = $this->params()->fromRoute('id');
		if ($id) {
//-			$this->getUsersTable()->delete(array('usr_id' => $id));

			$user = $this->getUsersTable()->select(array('usr_id' => $id))->current();
			$user->delete();
		}
		
		return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-row-gateway-feature-bind', 'action' => 'index'));										
	}
	
	public function getUsersTable()
	{
		if (!$this->usersTable) {
			$this->usersTable = new TableGateway(
				'users', 
				$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),
				new \Zend\Db\TableGateway\Feature\RowGatewayFeature('usr_id') // Zend\Db\RowGateway\RowGateway Object
//				ResultSetPrototype
			);
		}
		return $this->usersTable;
	}
}