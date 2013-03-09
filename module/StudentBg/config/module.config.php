<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'StudentBg\Controller\Index' => 'StudentBg\Controller\IndexController',
        ),
    ),
  
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'student_bg' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/student-bg[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'StudentBg\Controller\Index',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
  
    'view_manager' => array(
        'template_path_stack' => array(
            'student_bg' => __DIR__ . '/../view',
        ),
    ),
);