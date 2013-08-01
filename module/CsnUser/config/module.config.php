<?php
return array(
	'controllers' => array(
        'invokables' => array(
            'CsnUser\Controller\User' => 'CsnUser\Controller\UserController',
            'CsnUser\Controller\UserPaginator' => 'CsnUser\Controller\UserPaginatorController',
			
            'CsnUser\Controller\UserRowGatewayFeature' => 'CsnUser\Controller\UserRowGatewayFeatureController',	
            'CsnUser\Controller\UserRowGatewayFeatureBind' => 'CsnUser\Controller\UserRowGatewayFeatureBindController',	
			
            'CsnUser\Controller\UserResultSet' => 'CsnUser\Controller\UserResultSetController',
            'CsnUser\Controller\UserResultSetBind' => 'CsnUser\Controller\UserResultSetBindController',		
			
            'CsnUser\Controller\UserHydratingResultSet' => 'CsnUser\Controller\UserHydratingResultSetController',	
            'CsnUser\Controller\UserHydratingResultSetBind' => 'CsnUser\Controller\UserHydratingResultSetBindController',

			'CsnUser\Controller\UserDoctrineDbal' => 'CsnUser\Controller\UserDoctrineDbalController',
			'CsnUser\Controller\UserDoctrineSeparatedForm' => 'CsnUser\Controller\UserDoctrineSeparatedFormController',		
            'CsnUser\Controller\UserDoctrine' => 'CsnUser\Controller\UserDoctrineController', // the final form	
            'CsnUser\Controller\UserDoctrinePaginator' => 'CsnUser\Controller\UserDoctrinePaginatorController', // the final form	

			// Authorization
            'CsnUser\Controller\UserDoctrineSimpleAuthorization' => 'CsnUser\Controller\UserDoctrineSimpleAuthorizationController',		
            'CsnUser\Controller\UserDoctrineSimpleAuthorizationAcl' => 'CsnUser\Controller\UserDoctrineSimpleAuthorizationAclController',
			'CsnUser\Controller\UserDoctrinePureAcl' => 'CsnUser\Controller\UserDoctrinePureAclController',		
		),
	),
    'router' => array(
        'routes' => array(
			'csn_user' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/csn-user',
					'defaults' => array(
						'__NAMESPACE__' => 'CsnUser\Controller',
						'controller'    => 'User',
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
					'paginator' => array(
						'type'    => 'Segment',
						'options' => array(
							'route'    => '/:controller/[page/:page]',
							'constraints' => array(
								'page' => '[0-9]*',
							),
							'defaults' => array(
								'__NAMESPACE__' => 'CsnUser\Controller',
								'controller'    => 'UserPaginator',
								'action'        => 'index',
							),
						),
					),
					'paginator-doctrine' => array(
						'type'    => 'Segment',
						'options' => array(
							'route'    => '/[page/:page]',
							'constraints' => array(
								'page' => '[0-9]*',
							),
							'defaults' => array(
								'__NAMESPACE__' => 'CsnUser\Controller',
								'controller'    => 'UserDoctrinePaginator',
								'action'        => 'index',
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
            'csn_user' => __DIR__ . '/../view'
        ),
    ),	
);