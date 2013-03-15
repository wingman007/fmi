<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'NeslihanSuleyman\Controller\Index' => 'NeslihanSuleyman\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'neslihan_suleyman' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/neslihan-suleyman[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'NeslihanSuleyman\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_path_stack' => array(
            'neslihan_suleyman' => __DIR__ . '/../view',
        ),
    ),
);