<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'MargaritaKrushkova\Controller\Index' => 'MargaritaKrushkova\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'margarita_krushkova' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/margarita-krushkova[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'MargaritaKrushkova\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_map' => array(
          'layout/margaritatempl'           => __DIR__ . '/../view/layout/margaritatempl.phtml',
        ),
        'template_path_stack' => array(
            'margarita_krushkova' => __DIR__ . '/../view',
        ),
    ),
);