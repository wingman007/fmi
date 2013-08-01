<?php

namespace CsnUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;

use CsnUser\Form\UserForm;
use CsnUser\Form\UserFilter;

class UserPaginatorController extends AbstractActionController
{
	private $usersTable;
	
	// R -retrieve 	CRUD
	public function indexAction()
	{
		// I) Without pagination
//		return new ViewModel(array('rowset' => $this->getUsersTable()->select()));
		
		// II) Pagination
		// 1) ArrayAdapter. You first retireve all result turn them to array and after paginate. Not a very good solution.
//		$resulySet = $this->getUsersTable()->select();
//		$paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\ArrayAdapter($resulySet->toArray()));

		// 2) Zend\Paginator\Adapter\DbTableGateway. The best.
		$paginator = new \Zend\Paginator\Paginator(new \Zend\Paginator\Adapter\DbTableGateway($this->getUsersTable()));

		$page = 1;
		if ($this->params()->fromRoute('page')) $page = $this->params()->fromRoute('page');
		$paginator->setCurrentPageNumber((int)$page);
		$paginator->setItemCountPerPage(5);
		return new ViewModel(array('paginator' => $paginator));
	}
	
	// C -Create
	public function createAction()
	{
		$form = new UserForm();
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$data = $form->getData();
				unset($data['submit']);
				if (empty($data['usr_registration_date'])) $data['usr_registration_date'] = '2013-07-19 12:00:00';				
				$this->getUsersTable()->insert($data);
				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-paginator', 'action' => 'index'));										
			}
		}		
		
		return new ViewModel(array('form' => $form));
	}
	
	// U -Update
	public function updateAction()
	{
		$id = $this->params()->fromRoute('id');
		if (!$id) return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-paginator', 'action' => 'index'));
		$form = new UserForm();
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$data = $form->getData();
				unset($data['submit']);
				if (empty($data['usr_registration_date'])) $data['usr_registration_date'] = '2013-07-19 12:00:00';
				$this->getUsersTable()->update($data, array('usr_id' => $id));
				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-paginator', 'action' => 'index'));													
			}			 
		}
		else {
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
		
		return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-paginator', 'action' => 'index'));										
	}
	
	public function getUsersTable()
	{
		if (!$this->usersTable) {
			$this->usersTable = new TableGateway(
				'users', 
				$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')
//				new \Zend\Db\TableGateway\Feature\RowGatewayFeature('usr_id') // Zend\Db\RowGateway\RowGateway Object
//				ResultSetPrototype
			);
		}
		return $this->usersTable;
	}
}