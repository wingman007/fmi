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
                    'route'    => '/rall-nic[/:action][/:id]',
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

        'template_map' => array(
        'layout/RallNic'           => __DIR__ . '/../view/layout/RallNic.phtml',
        ),
        'template_path_stack' => array(
            'RallNic' => __DIR__ . '/../view',
        ),
    ),
);
