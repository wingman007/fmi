<?php

namespace CsnCms\Controller;

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

//- use Doctrine\Common\Persistence\ObjectManager;

use CsnCms\Entity\Article;

class IndexController extends AbstractActionController
{
	// R - retriev
    public function indexAction()
	{
		$entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$dql = "SELECT a, u, l, c FROM CsnCms\Entity\Article a LEFT JOIN a.author u LEFT JOIN a.language l LEFT JOIN a.categories c WHERE a.parent IS NULL"; 
		$query = $entityManager->createQuery($dql);
		$query->setMaxResults(30);
		$articles = $query->getResult();
		
		return new ViewModel(array('articles' => $articles));
	}

	// C - create
    public function addAction()
	{
		$entityManager = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		$article = new Article;
		$builder = new DoctrineAnnotationBuilder($entityManager);
		$form = $builder->createForm( $article );
		
		//!!!!!! Start !!!!! Added to make the association tables work with select
		foreach ($form->getElements() as $element){
			if(method_exists($element, 'getProxy')){                
				$proxy = $element->getProxy();
				if(method_exists($proxy, 'setObjectManager')){  
					$proxy->setObjectManager($entityManager);
				}
			}           
		}
		
		 $form->add(array(
			 'type' => 'Zend\Form\Element\Date',
			 'name' => 'artcCreatedDate',
			 'options' => array(
					 'label' => 'Created Date'
			 ),
			 'attributes' => array(
					 'min' => '2012-01-01',
					 'max' => '2020-01-01',
					 'step' => '1', // days; default step interval is 1 day
			 )
		 ));

		 $form->add(array(
			 'type' => 'Zend\Form\Element\Time',
			 'name' => 'artcCreatedTime',
			 'options'=> array(
					 'label' => 'Created Time'
			 ),
			 'attributes' => array(
					 'min' => '00:00:00',
					 'max' => '23:59:59',
					 'step' => '60', // seconds; default step interval is 60 seconds
			 )
		 ));

		$form->setHydrator(new DoctrineHydrator($entityManager,'CsnCms\Entity\Article'));
		$send = new Element('send');
		$send->setValue('Add'); // submit
		$send->setAttributes(array(
			'type'  => 'submit'
		));
		$form->add($send);		
		
		$form->bind($article);
		
        $request = $this->getRequest();
        if ($request->isPost()) {
			$post = $request->getPost();
			$post->artcCreated = $post->artcCreatedDate . ' ' . $post->artcCreatedTime;
			$form->setData($post);
			 if ($form->isValid()) {
				$entityManager->persist($article);
				$entityManager->flush();
                return $this->redirect()->toRoute('csn-cms/default', array('controller' => 'index', 'action' => 'index'));				
			 }
		}
		return new ViewModel(array('form' => $form));
	}

	// U - update
    public function editAction()
	{
		return new ViewModel();
	}		
	
	// D - delete
    public function deleteAction()
	{
		return new ViewModel();
	}	
	
    public function viewAction()
	{
		return new ViewModel();
	}	
}