<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'GyunerZeki\Controller\Index' => 'GyunerZeki\Controller\IndexController',
        ),
    ),
  
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
        'template_path_stack' => array(
            'gyuner_zeki' => __DIR__ . '/../view',
        ),
    ),
);