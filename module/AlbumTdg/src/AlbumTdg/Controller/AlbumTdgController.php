<?php

namespace AlbumTdg\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;

// use AlbumTdg\Model\Table\Album;

use AlbumTdg\Form\AlbumForm;
use AlbumTdg\Form\AlbumFilter;

class AlbumTdgController extends AbstractActionController
{
	private $albumTable = null;
	
	// Retrieve - R
	public function indexAction()
	{
		// 1) Identity
		// $user = $this->identity();
		// \Doctrine\Common\Util\Debug::dump($user);
		// 2) SQL trough adapter
		// $adapter = $this->getAlbumTable()->getAdapter();
		// $result = $adapter->query('SELECT * FROM `album` WHERE `id` = ?', array(2));
		// print_r($result);
		return new ViewModel(array('rowset' => $this->getAlbumTable()->select()));
		
	}
	
	// Create - C
	public function createAction()
	{
		$form = new AlbumForm();
		$request = $this->getRequest();	
        if ($request->isPost()) {
			$form->setInputFilter(new AlbumFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$data = $form->getData();
				unset($data['submit']);
				$this->getAlbumTable()->insert($data);
				return $this->redirect()->toRoute('album_tdg/default', array('controller' => 'album-tdg', 'action' => 'index'));										
			}
		}		
		return new ViewModel(array('form' => $form));
	}
	
	// Update - U
	public function updateAction()
	{
		$id = $this->params()->fromRoute('id');
		if (!$id) return $this->redirect()->toRoute('album_tdg/default', array('controller' => 'album-tdg', 'action' => 'index'));
		$form = new AlbumForm();
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new AlbumFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$data = $form->getData();
				unset($data['submit']);
				$this->getAlbumTable()->update($data, array('id' => $id));
				return $this->redirect()->toRoute('album_tdg/default', array('controller' => 'album-tdg', 'action' => 'index'));													
			}			 
		}
		else {
			$form->setData($this->getAlbumTable()->select(array('id' => $id))->current());			
		}
		return new ViewModel(array('form' => $form, 'id' => $id));		
	}
	
	// Delete - D
	public function deleteAction()
	{
		$id = $this->params()->fromRoute('id');
		if ($id) {
			$this->getAlbumTable()->delete(array('id' => $id));
		}

		return $this->redirect()->toRoute('album_tdg/default', array('controller' => 'album-tdg', 'action' => 'index'));	
	}
	
	public function getAlbumTable()
	{
		if (!$this->albumTable) {
			// $this->albumTable = new Album($this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'));
			$this->albumTable = new TableGateway( // Album( // 
				'album', 
				$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter')
//				new \Zend\Db\TableGateway\Feature\RowGatewayFeature('usr_id') // Zend\Db\RowGateway\RowGateway Object
//				ResultSetPrototype
			);
		}
		return $this->albumTable;
	}	
}