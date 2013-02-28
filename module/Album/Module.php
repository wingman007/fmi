<?php
namespace Album;

<<<<<<< HEAD
=======
// Add these import statements:
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
use Album\Model\Album;
use Album\Model\AlbumTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
<<<<<<< HEAD

=======
  
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
<<<<<<< HEAD
    
=======
  
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
    // Add this method:
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
<<<<<<< HEAD
                'Album\Model\AlbumTable' =>  function($sm) {
=======
                'Album\Model\AlbumTable' => function($sm) {
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
                    $tableGateway = $sm->get('AlbumTableGateway');
                    $table = new AlbumTable($tableGateway);
                    return $table;
                },
                'AlbumTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Album());
                    return new TableGateway('album', $dbAdapter, null, $resultSetPrototype);
                },
            ),
        );
    }
}