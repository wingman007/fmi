<?php

namespace CsnUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;

use CsnUser\Form\UserForm;
use CsnUser\Form\UserFilter;

use Zend\Db\ResultSet\ResultSet;
use CsnUser\Model\User;

class UserResultSetController extends AbstractActionController
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
//-		$user = new User();
//-		Error message: Zend\Stdlib\Hydrator\ArraySerializable::extract expects the provided object to implement getArrayCopy()
//-		If yo don't have a method(s) for extraction		
//-		$form->bind($user);

		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				//somebody must save the object $user now
//-				echo '<pre>';
//-				print_r($user);
//-				echo '</pre>';
				
				// 1) The question remains open: How to save the user object to the DB. We Need a data mapper.
				// We need an object that can extract and hidrate our object
				// or
				// 2) The object should extend or composit RowDataGateway and use the save and delete methods. 
				// The object should know how to save iyself
				
				$data = $form->getData();
				unset($data['submit']);
				if (empty($data['usr_registration_date'])) $data['usr_registration_date'] = '2013-07-19 12:00:00';				
				$this->getUsersTable()->insert($data);

				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-result-set', 'action' => 'index'));										
			}
		}		
		
		return new ViewModel(array('form' => $form));
	}
	
	// U -Update
	public function updateAction()
	{
		$id = $this->params()->fromRoute('id');
		if (!$id) return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-result-set', 'action' => 'index'));
		$form = new UserForm();
//-		$user = $this->getUsersTable()->select(array('usr_id' => $id))->current();
//-		Error message: Zend\Stdlib\Hydrator\ArraySerializable::extract expects the provided object to implement getArrayCopy()		
//-		$form->bind($user);
		
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$data = $form->getData();
				unset($data['submit']);
				if (empty($data['usr_registration_date'])) $data['usr_registration_date'] = '2013-07-19 12:00:00';
				$this->getUsersTable()->update($data, array('usr_id' => $id));
				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-result-set', 'action' => 'index'));													
			}			 
		}
		else {
		// Zend\Form\Form::setData expects an array or Traversable argument; received "CsnUser\Model\User"
			$form->setData($this->getUsersTable()->select(array('usr_id' => $id))->current());			
		}
		return new ViewModel(array('form' => $form, 'id' => $id));		
	}
	
	// D -Delete
	public function deleteAction()
	{
		$id = $this->params()->fromRoute('id');
		if ($id) {
			$this->getUsersTable()->delete(array('usr_id' => $id));
		}
		
		return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-result-set', 'action' => 'index'));										
	}
	
	public function getUsersTable()
	{
		if (!$this->usersTable) {
		// You can use the SM to composite the object
			$resultSetPrototype = new ResultSet(); // works only with ArrayObject http://php.net/manual/en/class.arrayobject.php
			$resultSetPrototype->setArrayObjectPrototype(new User()); // the User must implement ArrayObject or at leas		
			$this->usersTable = new TableGateway(
				'users', 
				$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),
				null, // new \Zend\Db\TableGateway\Feature\RowGatewayFeature('usr_id') // Zend\Db\RowGateway\RowGateway Object it is an ArrayObject
				$resultSetPrototype
			);
		}
		return $this->usersTable;
	}
}