<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'IvelinaVelcheva\Controller\Index' => 'IvelinaVelcheva\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'ivelina_velcheva' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/ivelina-velcheva[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'IvelinaVelcheva\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
          'template_map' => array(
          'layout/IvelinaVelcheva'           => __DIR__ . '/../view/layout/IvelinaVelcheva.phtml',
             ),
            'template_path_stack' => array(
                'ivelina_velcheva' => __DIR__ . '/../view',
            ),
    ),
);