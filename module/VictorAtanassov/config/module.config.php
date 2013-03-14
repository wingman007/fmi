<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'VictorAtanassov\Controller\Index' => 'VictorAtanassov\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'victor_atanassov' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/victor-atanassov[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'VictorAtanassov\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_map' => array(
          'layout/cardex'           => __DIR__ . '/../view/layout/cardex.phtml',
        ),
        'template_path_stack' => array(
            'victor_atanassov' => __DIR__ . '/../view',
        ),
    ),
);