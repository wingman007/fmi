<?php
namespace MartinManov\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
  
	// http://domain.com/martin-manov/mm-layout
    public function mmLayoutAction()
    {
        $viewModel = new ViewModel();
        $this->layout('layout/mm_layout');
        return new ViewModel();
    }
}