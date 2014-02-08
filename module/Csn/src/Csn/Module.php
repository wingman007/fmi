<?php

namespace Csn;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    // __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__, // Make the difference. This line if it is in the root of the project
                    __NAMESPACE__ => __DIR__ . '/../../src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}