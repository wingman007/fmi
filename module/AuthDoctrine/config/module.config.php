<?php
// http://stackoverflow.com/questions/13007477/doctrine-2-and-zf2-integration
namespace AuthDoctrine; // SUPER important for Doctrine othervise can not find the Entities

return array(
	'controllers' => array(
        'invokables' => array(
            'AuthDoctrine\Controller\Index' => 'AuthDoctrine\Controller\IndexController',
            'AuthDoctrine\Controller\Registration' => 'AuthDoctrine\Controller\RegistrationController',
            'AuthDoctrine\Controller\Admin' => 'AuthDoctrine\Controller\AdminController',			
        ),
    ),	
    'router' => array(
        'routes' => array(
			'auth-doctrine' => array(
				'type'    => 'Literal',
				'options' => array(
					'route'    => '/auth-doctrine',
					'defaults' => array(
						'__NAMESPACE__' => 'AuthDoctrine\Controller',
						'controller'    => 'Index',
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
            'auth-doctrine' => __DIR__ . '/../view'
        ),
		
		'display_exceptions' => true,
    ),
	
	// extra for Doctrine Put the namespace on top!!!!!!!
	// http://stackoverflow.com/questions/13007477/doctrine-2-and-zf2-integration 
	// put namespace User; in the first line of your module.config.php. a namespace should be defined as you use the __NAMESPACE__ constant...
	// from DoctrineModule
    'doctrine' => array(
		// 1) for Aithentication
        'authentication' => array( // this part is for the Auth adapter from DoctrineModule/Authentication
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
				// object_repository can be used instead of the object_manager key
                'identity_class' => 'AuthDoctrine\Entity\User', //'Application\Entity\User',
                'identity_property' => 'usrName', // 'username', // 'email',
                'credential_property' => 'usrPassword', // 'password',
                'credential_callable' => function(Entity\User $user, $passwordGiven) { // not only User
                    // return my_awesome_check_test($user->getPassword(), $passwordGiven);
					// echo '<h1>callback user->getPassword = ' .$user->getPassword() . ' passwordGiven = ' . $passwordGiven . '</h1>';
					//- if ($user->getPassword() == md5($passwordGiven)) { // original
					// ToDo find a way to access the Service Manager and get the static salt from config array
					if ($user->getUsrPassword() == md5('aFGQ475SDsdfsaf2342' . $passwordGiven . $user->getUsrPasswordSalt()) &&
						$user->getUsrActive() == 1) {
						return true;
					}
					else {
						return false;
					}
                },
            ),
        ),

		// 2) standard configuration for the ORM from https://github.com/doctrine/DoctrineORMModule
		// http://www.jasongrimes.org/2012/01/using-doctrine-2-in-zend-framework-2/
		// ONLY THIS IS REQUIRED IF YOU USE Doctrine in the module
        'driver' => array(
            // defines an annotation driver with two paths, and names it `my_annotation_driver`
//            'my_annotation_driver' => array(
			__NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(
                    // __DIR__ . '/../module/AuthDoctrine/src/AuthDoctrine/Entity' // 'path/to/my/entities',
					__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity',
					// 'H:\PortableApps\PortableGit\projects\btk\module\Auth\src\Auth\Entity' // Stoyan added to use doctrine in Auth module
//-					__DIR__ . '/../../Auth/src/Auth/Entity', // Stoyan added to use doctrine in Auth module
                    // 'another/path'
                ),
            ),

            // default metadata driver, aggregates all other drivers into a single one.
            // Override `orm_default` only if you know what you're doing
            'orm_default' => array(
                'drivers' => array(
                    // register `my_annotation_driver` for any entity under namespace `My\Namespace`
                    // 'My\Namespace' => 'my_annotation_driver'
					// 'AuthDoctrine' => 'my_annotation_driver'
					__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
//-					'Auth\Entity' => __NAMESPACE__ . '_driver' // Stoyan added to allow the module Auth also to use Doctrine
                )
            )
        )
    ),
);