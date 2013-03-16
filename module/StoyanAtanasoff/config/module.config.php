<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'StoyanAtanasoff\Controller\Index' => 'StoyanAtanasoff\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'stoyan_atanasoff' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/stoyan-atanasoff[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'StoyanAtanasoff\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_map' => array(
            'layout/StoyanAtanasov' => __DIR__.'/../view/layout/StoyanAtanasoff.phtml',
        ),
        'template_path_stack' => array(
            'stoyan_atanasoff' => __DIR__ . '/../view',
        ),
    ),
);