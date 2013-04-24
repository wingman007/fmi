<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'FmiStudent\Controller\Index' => 'FmiStudent\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'fmi_student' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/fmi-student[/:action][/:id]',
//                    'route'    => '/fmi-student[/:controller][/:action]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'FmiStudent\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_map' => array(
            'layout/FmiStudent'           => __DIR__ . '/../view/layout/FmiStudent.phtml',
        ),
        'template_path_stack' => array(
            'fmi_student' => __DIR__ . '/../view',
        ),
    ),
);