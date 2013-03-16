<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'MihailKopuscu\Controller\Index' => 'MihailKopuscu\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'mihail_kopuscu' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/mihail-kopuscu[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'MihailKopuscu\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
     'view_manager' => array(

         'template_map' => array(
           'layout/MihailKopuscu'           => __DIR__ . '/../view/layout/MihailKopuscu.phtml', 
        ),

        'template_path_stack' => array(
            'mihail_kopuscu' => __DIR__ . '/../view',
        ),
    ),   
);
