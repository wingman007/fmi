<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'MartinManov\Controller\Index' => 'MartinManov\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'martin_manov' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/martin-manov[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'MartinManov\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_map' => array(
          'layout/mm_layout'           => __DIR__ . '/../view/layout/mm_layout.phtml'),

        'template_path_stack' => array(
            'martin_manov' => __DIR__ . '/../view',
        ),
    ),
);