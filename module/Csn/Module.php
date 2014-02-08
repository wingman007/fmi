<?php
/**
 * This file is placed here for compatibility with ZendFramework 2's ModuleManager.
 * It allows usage of this module even without composer.
 * The original Module.php is in 'src/CsnUser' in order to respect PSR-0
 */
require_once __DIR__ . '/src/Csn/Module.php';

/* This is how the Module.php file should look like without respecting composer
namespace Csn;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}
*/