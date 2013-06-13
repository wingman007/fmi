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

class BorislavKirilovController extends AbstractActionController
{
    public function indexAction()
    {
		$entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');		
		// $dql = "SELECT b, e, r FROM Bug b JOIN b.engineer e JOIN b.reporter r ORDER BY b.created DESC";
		$dql = "SELECT u FROM Fmi\Entity\User u";

		$query = $entityManager->createQuery($dql);
		$query->setMaxResults(30);
		$users = $query->getResult();

		return new ViewModel(array('users' => $users));
    }

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
                return $this->redirect()->toRoute('fmi');
            }
        }
        return array('form' => $form);		
    }

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
                return $this->redirect()->toRoute('fmi');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );		
    }

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
            return $this->redirect()->toRoute('fmi');
        }

        return array(
            'id'    => $id,
            'user' => $user, // $this->getAlbumTable()->getAlbum($id)
        );	
	}

    public function getManagersAction()
    {
		// ORM
		//read https://github.com/doctrine/DoctrineORMModule
		// for example, in a controller:
		// Access the Doctrine command line as following
		//./vendor/bin/doctrine-module

		// H:\PortableApps\PortableGit\projects\grd>vendor\bin\doctrine-module.bat
		// !!! without cli_config bootsyrap etc.
		// H:\PortableApps\PortableGit\projects\grd>vendor\bin\doctrine-module.bat orm:schema-tool:create
		// ATTENTION: This operation should not be executed in a production environment.
		// Creating database schema...
		// Database schema created successfully!
		// $ vendor\bin\doctrine-module.bat orm:schema-tool:drop --force
		// $ vendor\bin\doctrine-module.bat orm:schema-tool:create
		// or
		// $ vendor\bin\doctrine-module.bat orm:schema-tool:update --force


		/*
		doctrine.connection.orm_default: a Doctrine\DBAL\Connection instance
		doctrine.configuration.orm_default: a Doctrine\ORM\Configuration instance
		doctrine.driver.orm_default: default mapping driver instance
		doctrine.entitymanager.orm_default: the Doctrine\ORM\EntityManager instance
		Doctrine\ORM\EntityManager: an alias of doctrine.entitymanager.orm_default
		doctrine.eventmanager.orm_default: the Doctrine\Common\EventManager instance
		*/

		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		// an alias
		// $em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');

		// ODM
		// Read https://github.com/doctrine/DoctrineMongoODMModule
		// Usage
		// Command Line
		// Access the Doctrine command line as following
		// ./vendor/bin/doctrine-module

		$dm = $this->getServiceLocator()->get('doctrine.documentmanager.odm_default');

        return new ViewModel();
    }

	 // http://docs.doctrine-project.org/projects/doctrine-orm/en/latest/tutorials/getting-started.html
	 // http://framework.zend.com/manual/2.1/en/modules/zend.form.quick-start.html
	 public function manageUserAction()
	 {

		$entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
/*		
		 $user = new User;
		 $user->setUsrName('Stoyan');
		 $user->setUsrPassword('Stoyan');
		 $user->setUsrEmail('Stoyan');
		 $user->setUsrActive(1);
		 $entityManager->persist($user);
		 $entityManager->flush();
		die('I had to create something');
*/		
		// 1) Update
//		$repository = $entityManager->getRepository('Fmi\Entity\User');
//		$id = (int)$this->params()->fromQuery('id', 1);
//		$user = $repository->find($id);

		// instead I will create a new object
		// For new user
		$user = new User;
		// $entityManager->persist($user);

		// $detachedEntity = unserialize($serializedEntity);
//		$detachedEntity =  new User;
//		$user = $entityManager->merge($detachedEntity);

		// here comes the magic
		$builder = new DoctrineAnnotationBuilder($entityManager);
		$form = $builder->createForm( $user );
		// var_dump($builder);
		// die('After builder');
		$form->setHydrator(new DoctrineHydrator($entityManager,'Fmi\Entity\User'));
		// it works both ways. With the above line. and the line bellow
		//- $form->setHydrator(new DoctrineEntity($entityManager, 'Fmi\Entity\User'));
		$form->bind($user);	

		$send = new Element('send');
		$send->setValue('Submit');
		$send->setAttributes(array(
			'type'  => 'submit'
		));
		$form->add($send);

		$viewModel =  new ViewModel();
		$viewModel->setVariable('form',$form);
		return	$viewModel;	
	 }

	 public function changeRageAction()
	 {
		$viewModel = new ViewModel();
		$this->layout('layout/rage'); // change the layout. DOn't forget to add it in module.config.php
		return $viewModel;		
	 }

	 public function changeWaterdropAction()
	 {
		$viewModel = new ViewModel();
		$this->layout('layout/waterdrop'); // change the layout. DOn't forget to add it in module.config.php
		return $viewModel;		
	 }
}

/*
  public function studentAction() {
    $viewModel = new ViewModel();
    // $viewModel->setTemplate('layout/custom');
    $this->layout('layout/student'); // change the layout. DOn't forget to add it in modeule.config.php
    return $viewModel;
  }
  
  public function changeAction() {
    $viewModel = new ViewModel();
    $this->layout('layout/FmiStudent'); // change the layout. DOn't forget to add it in module.config.php
    return $viewModel;
  }
*/