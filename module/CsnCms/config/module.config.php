<?php

namespace CsnCms;

return array(
	'controllers' => array(
        'invokables' => array(
            'CsnCms\Controller\Index' => 'CsnCms\Controller\IndexController',
            'CsnCms\Controller\Translation' => 'CsnCms\Controller\TranslationController',
            'CsnCms\Controller\Comment' => 'CsnCms\Controller\CommentController',			
        ),
    ),	
    'router' => array(
        'routes' => array(
			'csn-cms' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/csn-cms',
					'defaults' => array(
						'__NAMESPACE__' => 'CsnCms\Controller',
						'controller'    => 'Index',
						'action'        => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'default' => array(
						'type'    => 'Segment',
						'options' => array(
							// 'route'    => '/[:controller[/:action[/:id]]]',
							'route'    => '/[:controller[/:action[/:id[/:id2]]]]',
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
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
        'template_path_stack' => array(
            'csn-cms' => __DIR__ . '/../view'
        ),
		
		'display_exceptions' => true,
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