<?php

namespace CsnUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;

use CsnUser\Form\UserForm;
use CsnUser\Form\UserFilter;

use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;
use CsnUser\Entity\UserEntity;

class UserHydratingResultSetBindController extends AbstractActionController
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
		$form->setHydrator(new ReflectionHydrator());
		
		$user = new UserEntity();
		
		$form->bind($user);
		
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
			 
				// ToDo replace this code with code that uses the $user object. The user has to save himself or use datamapper 
				$data = $form->getData();
				$hydrator = new ReflectionHydrator();
				$data  = $hydrator->extract($data); // turn the object to array
				unset($data['submit']); // Cannot use object of type CsnUser\Entity\UserEntity as array
				if (empty($data['usr_registration_date'])) $data['usr_registration_date'] = '2013-07-19 12:00:00';				
				$this->getUsersTable()->insert($data);
				
				
				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-hydrating-result-set-bind', 'action' => 'index'));										
			}
		}		
		
		return new ViewModel(array('form' => $form));
	}
	
	// U -Update
	public function updateAction()
	{
		$id = $this->params()->fromRoute('id');
		if (!$id) return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-hydrating-result-set-bind', 'action' => 'index'));
		
		$form = new UserForm();
		$form->setHydrator(new ReflectionHydrator());
		
		$user = $this->getUsersTable()->select(array('usr_id' => $id))->current();
		
		$form->bind($user);
		
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				
				// ToDo raplace the code with something that uses user object
				$data = $form->getData();
				$hydrator = new ReflectionHydrator();
				$data  = $hydrator->extract($data); // turn the object to array
				unset($data['submit']);
				if (empty($data['usr_registration_date'])) $data['usr_registration_date'] = '2013-07-19 12:00:00';
				$this->getUsersTable()->update($data, array('usr_id' => $id));
				
				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-hydrating-result-set-bind', 'action' => 'index'));
			}			 
		}

		return new ViewModel(array('form' => $form, 'id' => $id));		
	}
	
	// D -Delete
	public function deleteAction()
	{
		$id = $this->params()->fromRoute('id');
		if ($id) {
			$user = $this->getUsersTable()->select(array('usr_id' => $id))->current();
		
			// ToDo Replace with something that uses the object
			$this->getUsersTable()->delete(array('usr_id' => $id));
		}
		
		return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-hydrating-result-set-bind', 'action' => 'index'));										
	}
	
	public function getUsersTable()
	{
		if (!$this->usersTable) {
		// You can use the SM to composite the object
			$resultSetPrototype = new HydratingResultSet(new ReflectionHydrator(), new UserEntity());
//			$resultSetPrototype->setObjectPrototype(new UserEntity());	
//			$resultSetPrototype->setHydrator(new ReflectionHydrator());			
			$this->usersTable = new TableGateway(
				'users', 
				$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),
				null, // new \Zend\Db\TableGateway\Feature\RowGatewayFeature('usr_id') // Zend\Db\RowGateway\RowGateway Object
				$resultSetPrototype
			);
		}
		return $this->usersTable;
	}
}