<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'RallNic\Controller\Index' => 'RallNic\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'RallNic' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/RallNic[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'RallNic\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_path_stack' => array(
            'RallNic' => __DIR__ . '/../view',
        ),
    ),
);