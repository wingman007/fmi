<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'MihaelaKerkenekova\Controller\Index' => 'MihaelaKerkenekova\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'mihaela_kerkenekova' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/mihaela-kerkenekova[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'MihaelaKerkenekova\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(

         'template_map' => array(
           'layout/MihaelaKerkenekova'           => __DIR__ . '/../view/layout/MihaelaKerkenekova.phtml', 
        ),
	
        'template_path_stack' => array(
            'mihaela_kerkenekova' => __DIR__ . '/../view',
        ),
    ),
);