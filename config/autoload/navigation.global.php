<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */
// from http://framework.zend.com/manual/2.1/en/modules/zend.navigation.quick-start.html
// the array was empty before that
return array( // ToDO make it dynamic - comes from the DB
     'navigation' => array(
         'default' => array(
             array(
                 'label' => 'Home',
                 'route' => 'home',
             ),
             array(
                 'label' => 'Album', // 'Page #1',
                 'route' => 'album', // 'page-1',
				 'action'     => 'index',
				 'controller' => 'index',
				 'resource'	=> 'Album\Controller\Album',
				 'privilege'	=> 'index',
                 'pages' => array(
                     array(
                         'label' => 'Add', // 'Child #1',
                         'route' => 'album',
						 'params' => array('action' => 'add'),
						 'resource'	=> 'Album\Controller\Album',
						 'privilege'	=> 'add',
                     ),
                 ),
             ),
             array(
                 'label' => 'Login', // 'Page #2',
                 'route' => 'auth-doctrine/default', // 'page-2',
				 'controller' => 'index',
				 'action'	=> 'login',
				 'resource'   => 'AuthDoctrine\Controller\Index', // 'mvc:admin',
				 'privilege'	=> 'login'
             ),
			array(
				'label' => 'My URI page',
				'uri'   => 'http://www.example.com/',
			),
             array(
                 'label' => 'Fmi',
                 'route' => 'fmi/default',
				 'controller' => 'index',
				 'action'	=> 'index',
				 'resource'   => 'Fmi\Controller\Index',
				 'privilege'	=> 'index'
             ),
             array(
                 'label' => 'User Doctrine',
                 'route' => 'csn_user/default',
				 'controller' => 'user-doctrine',
				 'action'	=> 'index',
				 'resource'   => 'CsnUser\Controller\UserDoctrine',
				 'privilege'	=> 'index'
             ),
             array(
                 'label' => 'User Doctrine Paginator',
                 'route' => 'csn_user/paginator-doctrine',
				 'controller' => 'user-doctrine-paginator',
				 'action'	=> 'index',
//				 'resource'   => 'CsnUser\Controller\UserDoctrinePaginator',
//				 'privilege'	=> 'index'
             ),
             array(
                 'label' => 'User TDG',
                 'route' => 'csn_user/default',
				 'controller' => 'user',
				 'action'	=> 'index',
//				 'resource'   => 'CsnUser\Controller\User', // No resources always will be shown
//				 'privilege'	=> 'index'
             ),
             array(
                 'label' => 'User TDG Paginator',
                 'route' => 'csn_user/paginator',
				 'controller' => 'user-paginator',
				 'action'	=> 'index',
//				 'resource'   => 'CsnUser\Controller\UserPaginator', // No resources always will be shown
//				 'privilege'	=> 'index'
             ),
             array(
                 'label' => 'Cms View Article',
                 'route' => 'csn-cms/default',
				 'action'     => 'view',
				 'controller' => 'Index',
				 'params' => array('controller' => 'index', 'action' => 'view', 'id' => 1),
				 'resource'	=> 'CsnCms\Controller\Index',
				 'privilege'	=> 'view',
                 'pages' => array(
                     array(
                         'label' => 'Index',
                         'route' => 'csn-cms/default',
						 'params' => array('controller' => 'index', 'action' => 'index'),
						 'resource'	=> 'CsnCms\Controller\Index',
						 'privilege'	=> 'index',
                     ),
                     array(
                         'label' => 'Add',
                         'route' => 'csn-cms/default',
						 'params' => array('controller' => 'index', 'action' => 'add'),
						 'resource'	=> 'CsnCms\Controller\Index',
						 'privilege'	=> 'add',
                     ),
                     array(
                         'label' => 'Edit',
                         'route' => 'csn-cms/default',
						 'params' => array('controller' => 'index', 'action' => 'edit'),
						 'resource'	=> 'CsnCms\Controller\Index',
						 'privilege'	=> 'edit',
                     ),
                     array(
                         'label' => 'Delete', 
                         'route' => 'csn-cms/default',
						 'params' => array('controller' => 'index', 'action' => 'delete'),
						 'resource'	=> 'CsnCms\Controller\Index',
						 'privilege'	=> 'delete',
                     ),
                 ),
             ),
         ),
     ),
     'service_manager' => array(
         'factories' => array(
             'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
         ),
     ),
);

/*
action	String	NULL	Action name to use when generating href to the page.
controller	String	NULL	Controller name to use when generating href to the page.
params	Array	array()	User params to use when generating href to the page.
route	String	NULL	Route name to use when generating href to the page.
routeMatch	Zend\Mvc\Router\RouteMatch	NULL	RouteInterface matches used for routing parameters and testing validity.
router	Zend\Mvc\Router\RouteStackInterface	NULL	Router for assembling URLs
*/