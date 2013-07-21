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
		// The default hydrator for the form is ArraySerializable
		// $form->setHydrator(new ReflectionHydrator()); // Not working "values() expects an array of values"
		$form->setHydrator(new ObjectProperty()); // WORKING "Statement could not be executed" Column not found: 1054 Unknown column 'submit' in 'field list'
		// $form->setHydrator(new ClassMethods()); // Not working "values() expects an array of values"
		
//- 	The error: Zend\Stdlib\Hydrator\ArraySerializable::extract expects the provided object to implement getArrayCopy()
		$user = new RowGateway('usr_id', 'users', $this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')); // missing arguments
		$form->bind($user); // It is not working like that if the hydrator is not properly set
		
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			$form->remove('submit');
			 if ($form->isValid()) {
				$user->save(); // The user is already hydrated by the form
				
				// the not bind way
//-				$data = $form->getData();
//-				unset($data['submit']);
//-				if (empty($data['usr_registration_date'])) $data['usr_registration_date'] = '2013-07-19 12:00:00';				
//-				$this->getUsersTable()->insert($data);

				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-row-gateway-feature-bind', 'action' => 'index'));										
			}
			$form->add(array( // bring back the button
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
		
//- 	The error: Zend\Stdlib\Hydrator\ArraySerializable::extract expects the provided object to implement getArrayCopy()		
		$user = $this->getUsersTable()->select(array('usr_id' => $id))->current();
		$form->bind($user);
		
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$user->save();
				
//-				$data = $form->getData();
//-				unset($data['submit']);
//-				if (empty($data['usr_registration_date'])) $data['usr_registration_date'] = '2013-07-19 12:00:00';
//-				$this->getUsersTable()->update($data, array('usr_id' => $id));

				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-row-gateway-feature-bind', 'action' => 'index'));													
			}			 
		}

		else {
			// notice toArray() at the end we have RowGateway Object here 
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