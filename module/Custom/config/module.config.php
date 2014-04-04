<?php

namespace Custom;

return array(
    'router' => array(
        'routes' => array(
			'home' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/',
					'defaults' => array(
						'__NAMESPACE__' => 'CsnCms\Controller',
						'controller'    => 'Index',
						'action'        => 'index',
					),
				),
			),			
		),
	),
    'view_manager' => array(
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
        ),
        'template_path_stack' => array(
            __NAMESPACE__ => __DIR__ . '/../view'
        ),
    ),	
);