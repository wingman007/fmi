<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'ZhelyanGuglev\Controller\Index' => 'ZhelyanGuglev\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'zhelyan_guglev' => array( // NOT 'album'! Give a different name for the route
                'type' => 'segment',
                'options' => array(
                    'route' => '/zhelyan-guglev[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'ZhelyanGuglev\Controller\Index',
                        'action' => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_map' => array(
          // 'layout/layout' => __DIR__ . '/../view/layout/layout.phtml', // the entire app is using it
          'layout/ZhelyanGuglev' => __DIR__ . '/../view/layout/ZhelyanGuglev.phtml',
          'layout/zheponymous' =>  __DIR__ . '/../view/layout/eponymous/eponymous.phtml',
          // 'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
          // 'application/stoyan/index' => __DIR__ . '/../view/application/stoyan/index.phtml', // <-- Added by me
          // 'error/404' => __DIR__ . '/../view/error/404.phtml',
          // 'error/index' => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'zhelyan_guglev' => __DIR__ . '/../view',
        ),
    ),
);