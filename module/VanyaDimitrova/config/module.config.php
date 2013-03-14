<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'VanyaDimitrova\Controller\Index' => 'VanyaDimitrova\Controller\IndexController',
        ),
    ),
  
   // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'vanya_dimitrova' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/vanya-dimitrova[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'VanyaDimitrova\Controller\Index',
                        'action'     => 'index','change',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_map' => array(
          'layout/VanyaDimitrova' => __DIR__ . '/../view/layout/VanyaDimitrova.phtml',
          ),
        'template_path_stack' => array(
            'vanya_dimitrova' => __DIR__ . '/../view',
        ),
    ),
);