<?php

namespace AlbumDm;

return array(
	'controllers' => array(
        'invokables' => array(
            'AlbumDm\Controller\AlbumDm' => 'AlbumDm\Controller\AlbumDmController',
		),
	),
    'router' => array(
        'routes' => array(
			'album_dm' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/album-dm',
					'defaults' => array(
						'__NAMESPACE__' => 'AlbumDm\Controller',
						'controller'    => 'AlbumDm',
						'action'        => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'default' => array(
						'type'    => 'Segment',
						'options' => array(
							'route'    => '/[:controller[/:action[/:id]]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id'     	 => '[0-9]*',
							),
							'defaults' => array(
							),
						),
					),
				),
			),			
		),
	),
    'view_manager' => array(
//        'template_map' => array(
//            'layout/Auth'           => __DIR__ . '/../view/layout/Auth.phtml',
//        ),
        'template_path_stack' => array(
            __NAMESPACE__ => __DIR__ . '/../view'
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    __DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
                ),
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                )
            )
        )
    ),	
);