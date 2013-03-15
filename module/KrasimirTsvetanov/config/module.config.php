<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'KrasimirTsvetanov\Controller\Index' => 'KrasimirTsvetanov\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'krasimir_tsvetanov' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/krasimir_tsvetanov[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'KrasimirTsvetanov\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
       'template_map' => array(
         // 'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml', // the entire app is using it
         // 'layout/layout'           => __DIR__ . '/../view/layout/student.phtml',
	 // 'layout/StoyanCheresharov'           => __DIR__ . '/../view/layout/layout.phtml',
        'layout/KrasimirTsvetanov'           => __DIR__ . '/../view/layout/KrasimirTsvetanov.phtml',
	//'layout/ria'           => __DIR__ . '/../view/layout/ria.phtml',
        //  'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
        //  'application/stoyan/index' => __DIR__ . '/../view/application/stoyan/index.phtml', // <-- Added by me
        //  'error/404'               => __DIR__ . '/../view/error/404.phtml',
        //  'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'krasimir_tsvetanov' => __DIR__ . '/../view',
        ),
    ),
);