<?php
/**
* Zend Framework (http://framework.zend.com/)
*
* @link http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
* @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
* @license http://framework.zend.com/license/new-bsd New BSD License
*/

namespace ZhelyanGuglev\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
  
    public function zhelyanAction() 
    {
        $viewModel = new ViewModel();
        // $viewModel->setTemplate('layout/custom');
        $this->layout('layout/ZhelyanGuglev'); // change the layout. DOn't forget to add it in modeule.config.php
        return $viewModel;
    }
  
    public function eponymousAction() 
    {
        $viewModel = new ViewModel();
        $this->layout('layout/zheponymous'); // change the layout. DOn't forget to add it in modeule.config.php
        return $viewModel;
    }
}