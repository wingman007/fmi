<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Elena\Controller\Index' => 'Elena\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'elena' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/elena[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Elena\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_path_stack' => array(
            'elena' => __DIR__ . '/../view',
        ),
    ),
);