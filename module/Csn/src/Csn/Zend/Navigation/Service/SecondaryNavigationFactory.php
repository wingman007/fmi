<?php
// http://stackoverflow.com/questions/12781623/zend-framework-2-navigation
// I have this defined in csnNavigation module as well
// I want to have this service here in this library (module as well)
namespace Csn\Zend\Navigation\Service;

// use Zend\Navigation\Service\DefaultNavigationFactory; // I am not going to use Zend instead my own factory

// class SecondaryNavigationFactory extends \Zend\Navigation\Service\DefaultNavigationFactory
class SecondaryNavigationFactory extends AbstractNavigationFactory
{
    protected function getName()
    {
        return 'secondary'; // The name of the key in config. See I put the name secondary here, which is the same as your navigation key.
    }
}