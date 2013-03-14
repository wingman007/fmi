<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'AntonTonev\Controller\Index' => 'AntonTonev\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'anton_tonev' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/anton-tonev[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'AntonTonev\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_map' => array(
        'layout/AntonTonev'           => __DIR__ . '/../view/layout/AntonTonev.phtml',
        ),
        'template_path_stack' => array(
            'anton_tonev' => __DIR__ . '/../view',
        ),
    ),
);