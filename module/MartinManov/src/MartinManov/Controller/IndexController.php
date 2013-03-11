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
  
      public function mm_layoutAction()
    {
        $viewModel = new ViewModel();
        $this->layout('layout/martin');
        return new ViewModel();
    }
}