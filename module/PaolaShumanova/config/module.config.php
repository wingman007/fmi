<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'PaolaShumanova\Controller\Index' => 'PaolaShumanova\Controller\IndexController',
        ),
    ),
  
    'router' => array(
        'routes' => array(
            'paola-shumanova' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/paola-shumanova[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'PaolaShumanova\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  


    'view_manager' => array(

         'template_map' => array(
           'layout/PaolaShumanova'           => __DIR__ . '/../view/layout/PaolaShumanova.phtml', 
        ),

        'template_path_stack' => array(
            'paola-shumanova' => __DIR__ . '/../view',
        ),
    ),
);