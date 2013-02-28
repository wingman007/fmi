<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Album' => 'Album\Controller\AlbumController',
        ),
    ),
<<<<<<< HEAD
=======
  
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'album' => array(
<<<<<<< HEAD
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/album[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Album',
                        'action'     => 'index',
=======
                'type' => 'segment',
                'options' => array(
                    'route' => '/album[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Album',
                        'action' => 'index',
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
                    ),
                ),
            ),
        ),
    ),
<<<<<<< HEAD
=======
  
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
);