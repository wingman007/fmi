<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'NikoletaPoibrenska\Controller\Index' => 'NikoletaPoibrenska\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'nikoleta_poibrenska' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/nikoleta-poibrenska[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'NikoletaPoibrenska\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_map' => array(
          // 'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml', // the entire app is using it
            'layout/NikoletaPoibrenska'           => __DIR__ . '/../view/layout/NikoletaPoibrenska.phtml',
          //  'layout/eponymous'           => __DIR__ . '/../view/layout/eponymous.phtml',
          //  'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
          //  'application/stoyan/index' => __DIR__ . '/../view/application/stoyan/index.phtml', // <-- Added by me
          //  'error/404'               => __DIR__ . '/../view/error/404.phtml',
          //  'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'nikoleta_poibrenska' => __DIR__ . '/../view',
        ),
    ),
);