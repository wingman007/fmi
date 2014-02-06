<?php
// http://stackoverflow.com/questions/12781623/zend-framework-2-navigation
namespace CsnNavigation\Navigation\Service;

use Zend\Navigation\Service\DefaultNavigationFactory;

class SecondaryNavigationFactory extends DefaultNavigationFactory
{
    protected function getName()
    {
        return 'secondary'; // The name of the key in config. See I put the name secondary here, which is the same as your navigation key.
    }
}