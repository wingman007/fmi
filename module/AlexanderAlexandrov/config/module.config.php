<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'AlexanderAlexandrov\Controller\Index' => 'AlexanderAlexandrov\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'alexander_alexandrov' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/alexander-alexandrov[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'AlexanderAlexandrov\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_map' => array(
    'layout/AlexanderAlexandrov'           => __DIR__ . '/../view/layout/AlexanderAlexandrov.phtml',
       
        ),
        'template_path_stack' => array(
            'alexander_alexandrov' => __DIR__ . '/../view',
        ),
    ),
);
