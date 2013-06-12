<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Fmi\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Form\Annotation\AnnotationBuilder;

use Zend\Form\Element;

// hydration tests
use Zend\Stdlib\Hydrator;

// for Doctrine annotation
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;
use DoctrineORMModule\Stdlib\Hydrator\DoctrineEntity;
use DoctrineORMModule\Form\Annotation\AnnotationBuilder as DoctrineAnnotationBuilder;

use Fmi\Entity\User;

class NikolaVasilevController extends AbstractActionController
{

    // INDEX ACTION
    public function indexAction()
    {
  		$entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');		
  		// $dql = "SELECT b, e, r FROM Bug b JOIN b.engineer e JOIN b.reporter r ORDER BY b.created DESC";
  		$dql = "SELECT u FROM Fmi\Entity\User u";
  		
  		$query = $entityManager->createQuery($dql);
  		$query->setMaxResults(30);
  		$users = $query->getResult();
  		
$this->layout('layout/NikolaVasilev');
  		return new ViewModel(array('users' => $users));
    }


    // ADD ACTION
    
    public function addAction()
    {
		// 1) Crete the form
        // $form = new AlbumForm();
        // $form->get('submit')->setValue('Add');
		// 1.2) with annotations

		$entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$user = new User;
		$builder = new DoctrineAnnotationBuilder($entityManager);
		$form = $builder->createForm( $user );
		$form->setHydrator(new DoctrineHydrator($entityManager,'Fmi\Entity\User'));
		// it works both ways. With the above line. and the line bellow
		//- $form->setHydrator(new DoctrineEntity($entityManager, 'Fmi\Entity\User'));
		$send = new Element('send');
		$send->setValue('Add'); // submit
		$send->setAttributes(array(
			'type'  => 'submit'
		));
		$form->add($send);

		// 2) bind the entity
		$form->bind($user);	

		// do the logic
        $request = $this->getRequest();
        if ($request->isPost()) {
            // $album = new Album();
            // $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) { // if it is valid hets populated
				        // $album->exchangeArray($form->getData());
                // $this->getAlbumTable()->saveAlbum($album);

                // NOW I will need the em

              $entityManager->persist($user);
      				$entityManager->flush();

              // Redirect to list of albums
              return $this->redirect()->toRoute('fmi/default', array('controller' => 'nikola-vasilev', 'action' => 'index'));
            }
        }
         $this->layout('layout/NikolaVasilev');
        return array('form' => $form);		
    }


    // EDIT ACTION
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('fmi', array(
                'action' => 'add'
            ));
        }

        // Get the Album with the specified id.  An exception is thrown
        // if it cannot be found, in which case go to the index page.
		$entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        try {
            // $album = $this->getAlbumTable()->getAlbum($id);
			$repository = $entityManager->getRepository('Fmi\Entity\User');
			// $id = (int)$this->params()->fromQuery('id', 1);
			$user = $repository->find($id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('fmi', array(
                'action' => 'index'
            ));
        }

		// Create the form
		// 2.2)
        // $form  = new AlbumForm();
        // $form->get('submit')->setAttribute('value', 'Edit');
		// 2.2)
		$builder = new DoctrineAnnotationBuilder($entityManager);
		$form = $builder->createForm( $user );
		$form->setHydrator(new DoctrineHydrator($entityManager,'Fmi\Entity\User'));
		// it works both ways. With the above line. and the line bellow
		//- $form->setHydrator(new DoctrineEntity($entityManager, 'Fmi\Entity\User'));
		$send = new Element('send');
		$send->setValue('Edit'); // submit
		$send->setAttributes(array(
			'type'  => 'submit'
		));
		$form->add($send);

		// 3) bind
		$form->bind($user);

        $request = $this->getRequest();
        if ($request->isPost()) {
            // $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                // $this->getAlbumTable()->saveAlbum($form->getData());

        				$entityManager->persist($user);
        				$entityManager->flush();				

                // Redirect to list of albums
                return  $this->redirect()->toRoute('fmi/default', array('controller' => 'nikola-vasilev', 'action' => 'index'));
            }
        }
        $this->layout('layout/NikolaVasilev');
        return array(
            'id' => $id,
            'form' => $form,
        );		
    }


    // DELETE ACTION
    
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('fmi');
        }

		$entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
        try {
            // $album = $this->getAlbumTable()->getAlbum($id);
			$repository = $entityManager->getRepository('Fmi\Entity\User');
			// $product = $entityManager->getRepository('Product')->findOneBy(array('name' => $productName));
			// $id = (int)$this->params()->fromQuery('id', 1);
			$user = $repository->find($id);
			// or $user = $entityManager->find("Fmi\Entity\User", (int)$id);
        }
        catch (\Exception $ex) {
            return $this->redirect()->toRoute('fmi', array(
                'action' => 'index'
            ));
        }		

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                // $this->getAlbumTable()->deleteAlbum($id);
				$user = $repository->find($id);
				$entityManager->remove($user);
				$entityManager->flush();
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('fmi/default', array('controller' => 'nikola-vasilev', 'action' => 'index'));

        }
        $this->layout('layout/NikolaVasilev');
        return array(
            'id'    => $id,
            'user' => $user, // $this->getAlbumTable()->getAlbum($id)
        );	
	}
 }