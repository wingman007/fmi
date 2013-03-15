<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'NikolaiBaldjiev\Controller\Index' => 'NikolaiBaldjiev\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'nikolai_baldjiev' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/nikolai-baldjiev[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'NikolaiBaldjiev\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_map' => array(
            'layout/NikolaiBaldjiev'           => __DIR__ . '/../view/layout/NikolaiBaldjiev.phtml',
        ),
        'template_path_stack' => array(
            'nikolai_baldjiev' => __DIR__ . '/../view',
        ),
    ),
);