<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'StoyanCheresharov\Controller\Index' => 'StoyanCheresharov\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'stoyan_cheresharov' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/stoyan-cheresharov[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'StoyanCheresharov\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
          'layout/layout'           => __DIR__ . '/../view/layout/StoyanCheresharov.phtml', // StoyanCheresharov
        ),
        'template_path_stack' => array(
            'stoyan_cheresharov' => __DIR__ . '/../view',
        ),
    ),
);