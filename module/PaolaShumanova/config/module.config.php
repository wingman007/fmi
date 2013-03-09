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
          // 'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml', // the entire app is using it
     'layout/paola'           => __DIR__ . '/../view/layout/templatemo_278_cafe_bakery.phtml', // the entire app is using it
          //            'layout/layout'           => __DIR__ . '/../view/layout/student.phtml',
          //  'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
          //  'application/stoyan/index' => __DIR__ . '/../view/application/stoyan/index.phtml', // <-- Added by me
          //  'error/404'               => __DIR__ . '/../view/error/404.phtml',
          //  'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),

    'view_manager' => array(
        'template_path_stack' => array(
            'paola-shumanova' => __DIR__ . '/../view',
        ),
    ),
);