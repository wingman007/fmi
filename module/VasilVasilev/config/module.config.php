<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'VasilVasilev\Controller\Index' => 'VasilVasilev\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'Vasil_Vasilev' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/Vasil-Vasilev[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'VasilVasilev\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
      'template_map' => array(
        'layout/VasilVasilev'           => __DIR__ . '/../view/layout/VasilVasilev.phtml',
         ),
        'template_path_stack' => array(
            'Vasil_Vasilev' => __DIR__ . '/../view',
        ),
    ),
);