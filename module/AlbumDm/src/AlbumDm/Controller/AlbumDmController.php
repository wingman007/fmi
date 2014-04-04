<?php

namespace AlbumDm\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use AlbumDm\Entity\Album;

use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;

// for the form
use Zend\Form\Element;

class AlbumDmController extends AbstractActionController
{
	// Retrieve - R
	public function indexAction()
	{
		$entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		// $entity = new Album();
		$albums = $entityManager->getRepository('AlbumDm\Entity\Album')->findAll();
		return new ViewModel(array('rowset' => $albums));
	}
	
	// Create - C
	public function createAction()
	{	
		$entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$album = new Album;
		$builder = new DoctrineAnnotationBuilder($entityManager);
		$form = $builder->createForm( $album );
		$form->setHydrator(new DoctrineHydrator($entityManager,'AlbumDm\Entity\Album'));

		$send = new Element('submit');
		$send->setValue('Go'); // submit
		$send->setAttributes(array(
			'type'  => 'submit'
		));
		$form->add($send);

		$form->bind($album);

		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$entityManager->persist($album);
				$entityManager->flush();

				return $this->redirect()->toRoute('album_dm/default', array('controller' => 'album-dm', 'action' => 'index'));										
			}
		}			
		
		return new ViewModel(array('form' => $form));
	}
	
	// Update - U
	public function updateAction()
	{
		$id = $this->params()->fromRoute('id');
		if (!$id) return $this->redirect()->toRoute('album_dm/default', array('controller' => 'album-dm', 'action' => 'index'));

		$entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        try {
			$repository = $entityManager->getRepository('AlbumDm\Entity\Album');
			$album = $repository->find($id);

        }
        catch (\Exception $ex) {
			echo $ex->getMessage(); // this never will be seen if you don't comment the redirect
			return $this->redirect()->toRoute('album_dm/default', array('controller' => 'album-dm', 'action' => 'index'));	
        }

		$builder = new DoctrineAnnotationBuilder($entityManager);
		$form = $builder->createForm( $album );
		$form->setHydrator(new DoctrineHydrator($entityManager,'AlbumDm\Entity\Album'));

		$send = new Element('submit');
		$send->setValue('Go'); // submit
		$send->setAttributes(array(
			'type'  => 'submit'
		));
		$form->add($send);

		$form->bind($album);

		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$entityManager->persist($album);
				$entityManager->flush();

				return $this->redirect()->toRoute('album_dm/default', array('controller' => 'album-dm', 'action' => 'index'));										
			}
		}			
		
		return new ViewModel(array('form' => $form, 'id' => $id));	
	}
	
	// Delete - D
	public function deleteAction()
	{
		$id = $this->params()->fromRoute('id');
		if (!$id) return $this->redirect()->toRoute('album_dm/default', array('controller' => 'album-dm', 'action' => 'index'));
		
		$entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');

        try {
			$repository = $entityManager->getRepository('AlbumDm\Entity\Album');
			$album = $repository->find($id);
			$entityManager->remove($album);
			$entityManager->flush();
        }
        catch (\Exception $ex) {
			// ... maybe do something more
			return $this->redirect()->toRoute('album_dm/default', array('controller' => 'album-dm', 'action' => 'index'));	
        }

		return $this->redirect()->toRoute('album_dm/default', array('controller' => 'album-dm', 'action' => 'index'));									
	}	
}