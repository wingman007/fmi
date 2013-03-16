<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'ElitsaNedyalkova\Controller\Index' => 'ElitsaNedyalkova\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'elitsa_nedyalkova' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/elitsa-nedyalkova[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ElitsaNedyalkova\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
      'template_map' => array(
        'layout/ElitsaNedyalkova'           => __DIR__ . '/../view/layout/ElitsaNedyalkova.phtml',
        ),
        'template_path_stack' => array(
            'elitsa_nedyalkova' => __DIR__ . '/../view',
        ),
    ),
);