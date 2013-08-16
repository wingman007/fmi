<?php

namespace CsnCms\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	// R - retriev
    public function indexAction()
	{
		return new ViewModel();
	}

	// C - create
    public function addAction()
	{
		return new ViewModel();
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