<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'GyunerZeki\Controller\Index' => 'GyunerZeki\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'gyuner_zeki' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/gyuner-zeki[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'GyunerZeki\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_map' => array(
          'layout/gyuner'           => __DIR__ . '/../view/layout/gyuner.phtml', // the entire app is using it
          'layout/eponymous'           => __DIR__ . '/../view/layout/eponymous.phtml',
        ),
        'template_path_stack' => array(
            'gyuner-zeki' => __DIR__ . '/../view',
        ),
    ),
);