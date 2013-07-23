<?php

namespace CsnUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;

use CsnUser\Form\UserForm;
use CsnUser\Form\UserFilter;

use Zend\Db\ResultSet\ResultSet;
use CsnUser\Model\User;
use CsnUser\Model\UsersTable;

class UserResultSetBindController extends AbstractActionController
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
		$user = new User();
//-		If yo don't have a method(s) for extraction	arrayCopy()
//-		Error message: Zend\Stdlib\Hydrator\ArraySerializable::extract expects the provided object to implement getArrayCopy()

		$form->bind($user);

		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
			 		
				//somebody must save the object $user now
//-				echo '<pre>';
//-				print_r($user);
//-				echo '</pre>';

				$this->getUsersTable()->insert($user);
				
				// 1) The question remains open: How to save the user object to the DB. We Need a data mapper.
				// We need an object that can extract and hydrate our object
				// or
				// 2) The object should extend or composit RowDataGateway and use the save and delete methods. 
				// The object should know how to save itself
				
				// ToDo replace this with Data mapper or RowDataGateway (Active Record)
				// takes care of saving data
//-				$data = $form->getData();
//-				unset($data['submit']);
//-				if (empty($data['usr_registration_date'])) $data['usr_registration_date'] = '2013-07-19 12:00:00';				
//-				$this->getUsersTable()->insert($data);

				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-result-set-bind', 'action' => 'index'));										
			}
		}		
		
		return new ViewModel(array('form' => $form));
	}
	
	// U -Update
	public function updateAction()
	{
		$id = $this->params()->fromRoute('id');
		if (!$id) return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-result-set-bind', 'action' => 'index'));
		$form = new UserForm();
		// $user = $this->getUsersTable()->select(array('usr_id' => $id))->current();
		$user = $this->getUsersTable()->getUser($id);
//-		Error message: Zend\Stdlib\Hydrator\ArraySerializable::extract expects the provided object to implement getArrayCopy()		
		$form->bind($user);
		
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
			 
				$this->getUsersTable()->update($user);
			 
				// 1) The question remains open: How to save the user object to the DB. We Need a data mapper.
				// We need an object that can extract and hidrate our object
				// DataMapper will be better coze I can use it as a Repository for SQL statements also
				// or
				// 2) The object should extend or composit RowDataGateway and use the save and delete methods. 
				// The object should know how to save iyself
			 
				// ToDo replce with code that uses the users object datamapper or RowDatagateway
				// takes care of saving the data
//-				$data = $form->getData();
//-				unset($data['submit']);
//-				if (empty($data['usr_registration_date'])) $data['usr_registration_date'] = '2013-07-19 12:00:00';
//-				$this->getUsersTable()->update($data, array('usr_id' => $id));

				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-result-set-bind', 'action' => 'index'));													
			}			 
		}
		// we don't need to populate the form anymore it is done with bind
		
		return new ViewModel(array('form' => $form, 'id' => $id));		
	}
	
	// D -Delete
	public function deleteAction()
	{
		$id = $this->params()->fromRoute('id');
		if ($id) {
			// get the object			
			$user = $this->getUser($id);
			$this->getUsersTable()->delete($user);
			
//-			$user = $this->getUsersTable()->select(array('usr_id' => $id))->current();
			//somebody must delete the object $user now
			// 1) Datamapper
			// 2) Row DataGateway
			
			// ToDo replace with 
//-			$this->getUsersTable()->delete(array('usr_id' => $id));
		}
		
		return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-result-set-bind', 'action' => 'index'));										
	}
	
	public function getUsersTable()
	{
		if (!$this->usersTable) {
		// You can use the SM to composite the object
			$resultSetPrototype = new ResultSet(); // works only with ArrayObject http://php.net/manual/en/class.arrayobject.php
			$resultSetPrototype->setArrayObjectPrototype(new User()); // the User must implement ArrayObject or at leas		
			$tableGateway = new TableGateway(
				'users', 
				$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),
				null, // new \Zend\Db\TableGateway\Feature\RowGatewayFeature('usr_id') // Zend\Db\RowGateway\RowGateway Object it is an ArrayObject
				$resultSetPrototype
			);
			
			// !!! we use our own class which can be augmented with more methods
			$this->usersTable = new UsersTable($tableGateway);
		}
		return $this->usersTable;
	}
}