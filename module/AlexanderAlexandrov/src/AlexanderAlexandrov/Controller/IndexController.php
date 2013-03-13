<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace AlexanderAlexandrov\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
   public function ChangeAction()
    {
        $id = $this->getRequest()->getParam('id');
      //do something interesting. Take the article form the database. Dynamicali changing.
        $this->layout('layout/AlexanderAlexandrov');      
        return new ViewModel();
    }
}