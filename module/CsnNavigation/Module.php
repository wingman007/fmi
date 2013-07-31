<?php

namespace CsnNavigation;

use Zend\View\HelperPluginManager;
use Zend\Permissions\Acl\Acl;
use Zend\Permissions\Acl\Role\GenericRole;
use Zend\Permissions\Acl\Resource\GenericResource;

class Module
{
	protected $sm; // 
	
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
	
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

	public function init(\Zend\ModuleManager\ModuleManager $mm)
	{
		// var_dump($mm);
	}
	
	public function onBootstrap(\Zend\EventManager\EventInterface $e) // use it to attach event listeners
	{
		$application = $e->getApplication();
		$this->sm = $application->getServiceManager();
		// var_dump($this->sm);
	}
	
    public function getViewHelperConfig()
    {
//		$auth = $this->sm->get('Zend\Authentication\AuthenticationService');
//		$config = $this->sm->get('Config');
//		$acl = new Acl($config);
		
        return array(
            'factories' => array(
                // This will overwrite the native navigation helper
                'navigation' => function(HelperPluginManager $pm) {
					$sm = $pm->getServiceLocator();
					$config = $sm->get('Config');
					
					// Setup ACL:
					// We have our own class.
					// ToDo think for better place for it maybe in CsnBase. I have it in CsnAuthorize and here \CsnNavigation\Acl\Acl
					$acl = new \CsnNavigation\Acl\Acl($config);
					
//					$acl = new Acl($config);
//					$acl->addRole(new GenericRole('member'));
//					$acl->addRole(new GenericRole('admin'));
//					$acl->addResource(new GenericResource('mvc:admin'));
//					$acl->addResource(new GenericResource('mvc:community.account'));
//					$acl->allow('member', 'mvc:community.account');
//					$acl->allow('admin', null);
					
//					$acl->addResource(new GenericResource('AuthDoctrine\Controller\Index'));
//					$acl->allow('member', 'AuthDoctrine\Controller\Index');

					// Get the AuthenticationService
					$auth = $sm->get('Zend\Authentication\AuthenticationService');
					$role = \CsnNavigation\Acl\Acl::DEFAULT_ROLE; // The default role is guest $acl
/* Without Doctrine
					if ($auth->hasIdentity()) {
						$usr = $auth->getIdentity();
						$usrl_id = $usr->usrl_id; // Use a view to get the name of the role
						// TODO we don't need that if the names of the roles are comming from the DB
						switch ($usrl_id) {
							case 1 :
								$role = \CsnNavigation\Acl\Acl::DEFAULT_ROLE; // guest
								break;
							case 2 :
								$role = 'member';
								break;
							case 3 :
								$role = 'admin';
								break;
							default :
								$role = \CsnNavigation\Acl\Acl::DEFAULT_ROLE; // guest
								break;
						}
					}
*/
					// With Doctrine
					if ($auth->hasIdentity()) {
						$user = $auth->getIdentity();
						$usrlId = $user->getUsrlId(); // Use a view to get the name of the role
						// TODO we don't need that if the names of the roles are comming from the DB
						switch ($usrlId) {
							case 1 :
								$role = \CsnNavigation\Acl\Acl::DEFAULT_ROLE; // guest
								break;
							case 2 :
								$role = 'member';
								break;
							case 3 :
								$role = 'admin';
								break;
							default :
								$role = \CsnNavigation\Acl\Acl::DEFAULT_ROLE; // guest
								break;
						}
					}					
					
                    // Get an instance of the proxy helper
                    $navigation = $pm->get('Zend\View\Helper\Navigation');
					
                    // Store ACL and role in the proxy helper:
                    $navigation->setAcl($acl)
                               ->setRole($role); // 'member'

                    // Return the new navigation helper instance
                    return $navigation;
                }
            )
        );
    }
	
}