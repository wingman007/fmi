<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'PetyaStavarova\Controller\Index' => 'PetyaStavarova\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'petya_stavarova' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/petya-stavarova[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'PetyaStavarova\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
       'template_map' => array(
    'layout/PetyaStavarova'           => __DIR__ . '/../view/layout/PetyaStavarova.phtml',
         ),
        'template_path_stack' => array(
            'petya_stavarova' => __DIR__ . '/../view',
        ),
    ),
);