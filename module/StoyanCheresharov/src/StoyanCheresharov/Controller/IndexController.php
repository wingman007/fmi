<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace StoyanCheresharov\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
  
    public function changeAction()
    {
        $id = $this->getRequest()->getParam('id');
      // do somethig intersting.(e.g. take the article from the DB)
        $this->layout('layout/StoyanCheresharov');
        return new ViewModel();
    }
}