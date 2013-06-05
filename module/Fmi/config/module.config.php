<?php
// http://stackoverflow.com/questions/13007477/doctrine-2-and-zf2-integration
namespace Fmi; // SUPER important for Doctrine othervise can not find the Entities

return array(
	'controllers' => array(
        'invokables' => array(
            'Fmi\Controller\Index' => 'Fmi\Controller\IndexController',
            'Fmi\Controller\DenisGeorgiev' => 'Fmi\Controller\DenisGeorgievController',			
        ),
    ),
	// !!! SUPER important use fmi/default  grace-drops/<segment>in url helper
    'router' => array(
        'routes' => array(
			'fmi' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/fmi',
					'defaults' => array(
						'__NAMESPACE__' => 'Fmi\Controller',
						'controller'    => 'denisgeorgiev',
						'action'        => 'index',
					),
					
				),
				'may_terminate' => true,
                'child_routes' => array(
                    'default' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action[/:id]]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
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
        'template_map' => array(
              'layout/DenisGeorgiev'           => __DIR__ . '/../view/layout/DenisGeorgiev.phtml',
              'layout/eponymous'           => __DIR__ . '/../view/layout/eponymous.phtml',       
//            'layout/rage'           => __DIR__ . '/../view/layout/rage.phtml', // layout/layout
//            'layout/waterdrop'           => __DIR__ . '/../view/layout/waterdrop.phtml',			
        ),
        'template_path_stack' => array(
            'grace-drops' => __DIR__ . '/../view'
        ),
		
		'display_exceptions' => true,
    ),
    'doctrine' => array(
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
			__NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
					__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
                ),
            ),
			
            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
					// register `my_annotation_driver` for any entity under namespace `My\Namespace`
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                )
            )
        )
    )		
);
