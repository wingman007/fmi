<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'MarinaGatova\Controller\Index' => 'MarinaGatova\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'marina_gatova' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/marina-gatova[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'MarinaGatova\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_map' => array(
          'layout/MarinaGatova'           => __DIR__ . '/../view/layout/MarinaGatova.phtml',
        ),
        'template_path_stack' => array(
            'marina_gatova' => __DIR__ . '/../view',
        ),
    ),
);