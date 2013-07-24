<?php
// http://stackoverflow.com/questions/13007477/doctrine-2-and-zf2-integration
namespace Fmi; // SUPER important for Doctrine othervise can not find the Entities

return array(
	'controllers' => array(
        'invokables' => array(
            'Fmi\Controller\Index' => 'Fmi\Controller\IndexController',	
            'Fmi\Controller\IvanQnachkov' => 'Fmi\Controller\IvanQnachkovController',	
            'Fmi\Controller\BoyanProdanov' => 'Fmi\Controller\BoyanProdanovController',			
            'Fmi\Controller\DenisGeorgiev' => 'Fmi\Controller\DenisGeorgievController',	
            'Fmi\Controller\CvetomirStoqnov' => 'Fmi\Controller\CvetomirStoqnovController',			
            'Fmi\Controller\CankoGrozev' => 'Fmi\Controller\CankoGrozevController',
            'Fmi\Controller\StoyanRevov' => 'Fmi\Controller\StoyanRevovController',	
            'Fmi\Controller\VladislavAntov' => 'Fmi\Controller\VladislavAntovController',	
            'Fmi\Controller\IliaShterev' => 'Fmi\Controller\IliaShterevController',
            'Fmi\Controller\NikolaVasilev' => 'Fmi\Controller\NikolaVasilevController',	
            'Fmi\Controller\ZdravkoZdravchev' => 'Fmi\Controller\ZdravkoZdravchevController',
            'Fmi\Controller\EleonoraDimova' => 'Fmi\Controller\EleonoraDimovaController',
            'Fmi\Controller\VasilBrakalov' => 'Fmi\Controller\VasilBrakalovController',
            'Fmi\Controller\BorislavKirilov' => 'Fmi\Controller\BorislavKirilovController',
            'Fmi\Controller\DmitroMelnik' => 'Fmi\Controller\DmitroMelnikController',
            'Fmi\Controller\LindaMassarwe' => 'Fmi\Controller\LindaMassarweController',
            'Fmi\Controller\ZlatinaBogomilova' => 'Fmi\Controller\ZlatinaBogomilovaController',
            'Fmi\Controller\StoyanAtanasoff' => 'Fmi\Controller\StoyanAtanasoffController',
            'Fmi\Controller\TeodorChilov' => 'Fmi\Controller\TeodorChilovController',
            'Fmi\Controller\KirilTunev' => 'Fmi\Controller\KirilTunevController',
            'Fmi\Controller\VentsislavBoiadzhiev' => 'Fmi\Controller\VentsislavBoiadzhievController',
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
						'controller'    => 'Index',
						'action'        => 'index',
					),
				),
				'may_terminate' => true,
				'child_routes' => array(
					'default' => array(
						'type'    => 'Segment',
						'options' => array(
							'route'    => '/[:controller[/:action[/:id]]]', // !!! SUPER important use grace-drops/default  grace-drops/<segment>in url helper
							'constraints' => array(
								'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
								'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
								'id' => '[0-9]*'
							),
							'defaults' => array(
								// STOYAn was adding this. You can avoid using it
								'__NAMESPACE__' => 'Fmi\Controller',
								'controller'    => 'Index',
								'action'        => 'index',
							),
						),
					),
				),
			),
		),
	),
    'view_manager' => array(
        'template_map' => array(
//            'layout/rage'           => __DIR__ . '/../view/layout/rage.phtml', // layout/layout
//            'layout/waterdrop'           => __DIR__ . '/../view/layout/waterdrop.phtml',
              'layout/NikolaVasilev'           => __DIR__ . '/../view/layout/NikolaVasilev.phtml',			
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
//					'C:\Documents and Settings\user\fmi\module\CsnUser\src\CsnUser\Entity' // this doesn't realy mathers for loading the Entities
                ),
            ),
			
            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
					// register `my_annotation_driver` for any entity under namespace `My\Namespace`
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
//					'CsnUser\Entity'	=> __NAMESPACE__ . '_driver', // add another namespace to make it work even from another module
                )
            )
        )
    )		
);
