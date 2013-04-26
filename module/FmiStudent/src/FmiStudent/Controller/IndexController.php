<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace FmiStudent\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
  
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
  
  public function jsAjaxAction() {
    $viewModel = new ViewModel();
    $this->layout('layout/FmiStudent'); // change the layout. DOn't forget to add it in module.config.php
    return $viewModel;
  }

   public function jqueryAjaxAction() {
    $viewModel = new ViewModel();
    $this->layout('layout/FmiStudent'); // change the layout. DOn't forget to add it in module.config.php
    return $viewModel;
  } 

   public function dojoAjaxAction() {
    $viewModel = new ViewModel();
    $this->layout('layout/FmiStudent'); // change the layout. DOn't forget to add it in module.config.php
    return $viewModel;
  } 
  
  // To disable layout
  public function serviceAjaxAction()
  {
    // your code here ...
    $ViewModel = new ViewModel();
    $ViewModel->setTerminal(true);
    return $ViewModel;
  } 
    
  public function serviceJsonAction()
  {
    // your code here ...
      $ViewModel = new ViewModel(array('data' => array(
        'firstParam' => 'Value1', 
        'secondParam' => 'Value2', 
      )));
    $ViewModel->setTerminal(true);
    return $ViewModel;
  }
  
}