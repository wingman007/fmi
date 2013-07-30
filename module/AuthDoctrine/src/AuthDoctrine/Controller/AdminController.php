<?php
namespace Auth\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;

use Auth\Form\UserForm;
use Auth\Form\UserFilter;

class AdminController extends AbstractActionController
{
	protected $usersTable = null;

	// R - retrieve = Index
    public function indexAction()
    { 
		return new ViewModel(array('rowset' => $this->getUsersTable()->select()));
	}
	
	// C - Create
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
				return $this->redirect()->toRoute('auth/default', array('controller' => 'admin', 'action' => 'index'));													
			}			
		}
		return new ViewModel(array('form' => $form));
	}
	
	// U - Update
    public function updateAction()
    {
		$id = $this->params()->fromRoute('id');
		if (!$id) return $this->redirect()->toRoute('auth/default', array('controller' => 'admin', 'action' => 'index'));
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
				return $this->redirect()->toRoute('auth/default', array('controller' => 'admin', 'action' => 'index'));													
			}			 
		}
		else {
			$form->setData($this->getUsersTable()->select(array('usr_id' => $id))->current());			
		}
		
		return new ViewModel(array('form' => $form, 'id' => $id));
	}
	
	// D - delete
    public function deleteAction()
    {
		$id = $this->params()->fromRoute('id');
		if ($id) {
			$this->getUsersTable()->delete(array('usr_id' => $id));
		}
		
		return $this->redirect()->toRoute('auth/default', array('controller' => 'admin', 'action' => 'index'));											
	}
	
	public function getUsersTable()
	{
		// I have a Table data Gateway ready to go right out of the box
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