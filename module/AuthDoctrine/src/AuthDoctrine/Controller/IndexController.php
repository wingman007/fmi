<?php
namespace AuthDoctrine\Controller;

// Authentication with Remember Me
// http://samsonasik.wordpress.com/2012/10/23/zend-framework-2-create-login-authentication-using-authenticationservice-with-rememberme/

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

// use Auth\Model\Auth;          we don't need the model here we will use Doctrine em 
use AuthDoctrine\Entity\User; // only for the filters
use AuthDoctrine\Form\LoginForm;       // <-- Add this import

class IndexController extends AbstractActionController
{
    public function indexAction()
    {
		// for example, in a controller:
//-		$em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		// or
//-		$em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
		// or even better
		$em = $this->getEntityManager();
		
		// the class for the table
//-		$user = new \AuthDoctrine\Entity\User; 
		
//-		$userRepository = $em->getRepository('AuthDoctrine\Entity\User'); // '\AuthDoctrine\Entity\User'
//-		$users = $userRepository->findAll();
		// $users = $em->findAll('AuthDoctrine\Entity\User');
		
//-		$q = $em->createQuery("select u from AuthDoctrine\Entity\User"); // AuthDoctrine\
//-		$users = $q->getResult();
		
		$users = $em->getRepository('AuthDoctrine\Entity\User')->findAll();
		
		// I will extra get the records from users
//		$myUsers = $em->getRepository('AuthDoctrine\Entity\Users')->findAll();
		
		/*
		If you have an entity class (Doctrine Repository manual):

		$records = $em->getRepository("Entities\YourTargetEntity")->findAll();
		If you don't have entity class (PDO manual):

		$pdo = $em->getCurrentConnection()->getDbh();
		$result = $pdo->query("select * from table"); //plain sql query here, it's just PDO
		$records = $pdo->fetchAll();
		
		*/
		
		
		//- var_dump($user);
		
		//- $entityManager->persist($product);
		//- $entityManager->flush();
		
		// doctrine.connection.orm_default: a Doctrine\DBAL\Connection instance
		// doctrine.configuration.orm_default: a Doctrine\ORM\Configuration instance
		// doctrine.driver.orm_default: default mapping driver instance
		// doctrine.entitymanager.orm_default: the Doctrine\ORM\EntityManager instance
		// Doctrine\ORM\EntityManager: an alias of doctrine.entitymanager.orm_default
		// doctrine.eventmanager.orm_default: the Doctrine\Common\EventManager instance
		
//-		echo '<pre>';
		// print_r($em);
//-		var_dump($em);
//-		echo '</pre>';
		
		
		
        $message = $this->params()->fromQuery('message', 'foo');
        return new ViewModel(array(
			'message' => $message,
			'users'	=> $users,
//			'myUsers' => $myUsers
		));
    }
	
    public function loginAction()
    {
		$form = new LoginForm();
		$form->get('submit')->setValue('Login');
		$messages = null;

		$request = $this->getRequest();
        if ($request->isPost()) {
            $authFormFilters = new User(); // we use the Entity for the filters
			// TODO fix the filters
            //- $form->setInputFilter($authFormFilters->getInputFilter());
            $form->setData($request->getPost());
			// echo "<h1>I am here1</h1>";
            if ($form->isValid()) {
				$data = $form->getData();			
				// $data = $this->getRequest()->getPost();
				
				// If you used another name for the authentication service, change it here
				// it simply returns the Doctrine Auth. This is all it does. lets first create the connection to the DB and the Entity
				$authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');		
				// Do the same you did for the ordinar Zend AuthService	
				$adapter = $authService->getAdapter();
				$adapter->setIdentityValue($data['username']);
				$adapter->setCredentialValue($data['password']);
				$authResult = $authService->authenticate();
				// echo "<h1>I am here</h1>";
				if ($authResult->isValid()) {
					$identity = $authResult->getIdentity();
					$authService->getStorage()->write($identity);
					//- return $this->redirect()->toRoute('home');
				}
				foreach ($authResult->getMessages() as $message) {
					$messages .= "$message\n"; 
				}
		

		/*
				$identity = $authenticationResult->getIdentity();
				$authService->getStorage()->write($identity);

				$authenticationService = $this->serviceLocator()->get('Zend\Authentication\AuthenticationService');
				$loggedUser = $authenticationService->getIdentity();
		*/
			}
		}
		return new ViewModel(array(
			'error' => 'Your authentication credentials are not valid',
			'form'	=> $form,
			'messages' => $messages,
		));
    }
	
	public function logoutAction()
	{
		// in the controller
		// $auth = new AuthenticationService();
		$auth = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');

		// @todo Set up the auth adapter, $authAdapter


		if ($auth->hasIdentity()) {
			// Identity exists; get it
			$identity = $auth->getIdentity();
//-			echo '<pre>';
//-			print_r($identity);
//-			echo '</pre>';
		}
		$auth->clearIdentity();
		
        // $view = new ViewModel(array(
        //    'message' => 'Hello world',
        // ));
        // $view->setTemplate('foo/baz-bat/do-something-crazy');
        // return $view;
		
		// return $this->redirect()->toRoute('home');
		return $this->redirect()->toRoute('auth-doctrine/default', array('controller' => 'index', 'action' => 'login'));
		
	}	
	
	// the use of controller plugin
	public function authTestAction()
	{
		if ($user = $this->identity()) { // controller plugin
			// someone is logged !
		} else {
			// not logged in
		}
	}
	
	/**             
	 * @var Doctrine\ORM\EntityManager
	 */                
	protected $em;
	 
	public function getEntityManager()
	{
		if (null === $this->em) {
			$this->em = $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
		}
		return $this->em;
	}
	
}

/*
https://github.com/doctrine/DoctrineModule/blob/master/docs/index.md

View helper and controller helper

You may also need to know if there is an authenticated user within your other controllers or in views. ZF2 provides a controller plugin and a view helper you may use.

Here is how you use it in your controller :

public function testAction()
{
    if ($user = $this->identity()) {
        // someone is logged !
    } else {
        // not logged in
    }
}
And in your view :

<?php
    if ($user = $this->identity()) {
        echo 'Logged in as ' . $this->escapeHtml($user->getUsername());
    } else {
        echo 'Not logged in';
    }
?>
*/

/*
You can find more details about the features offered by DoctrineModule:

Authentication documentation: this explains how you can use the DoctrineModule authentication adapter and authentication storage adapter to provide a simple way to authenticate users using Doctrine.
Caching documentation: DoctrineModule provides simple classes to allow easier caching using Doctrine.
CLI documentation: learn how to use the Doctrine 2 command line tool, and how to add your own command.
Hydrator documentation: if you are using Zend Framework 2 Forms (and I hope you are !), DoctrineModule hydrator provides a powerful hydrator that allow you to easily deal with OneToOne, OneToMany and ManyToOne relationships when using forms.
Paginator documentation: discover how to use the DoctrineModule Paginator adapter.
Validator documentation: this chapter explains how to use ObjectExists and NoObjectExists validator, that allow you to easily validate if a given entity exists or not.
*/

/*
http://www.jasongrimes.org/2012/01/using-doctrine-2-in-zend-framework-2/
http://www.jasongrimes.org/2012/01/using-doctrine-2-in-zend-framework-2/
http://www.jasongrimes.org/2012/01/using-doctrine-2-in-zend-framework-2/
https://github.com/iwalz/zf2-doctrine2-getting-started

=========================
https://github.com/doctrine
https://github.com/doctrine/DoctrineModule
https://github.com/doctrine/DoctrineModule/blob/master/docs/index.md
http://docs.doctrine-project.org/en/latest/tutorials/getting-started.html
http://framework.zend.com/manual/1.12/en/zend.db.table.html
https://github.com/doctrine/DoctrineORMModule
http://framework.zend.com/manual/2.1/en/modules/zend.authentication.adapter.dbtable.html
http://mind42.com/mindmap/61b9f3eb-0c96-42ce-a119-01f05fe6675f
http://framework.zend.com/manual/2.1/en/modules/zend.module-manager.intro.html
http://framework.zend.com/manual/2.1/en/modules/zend.service-manager.quick-start.html#zend-service-manager-quick-start-config
https://github.com/ZF-Commons/ZfcUserDoctrineORM/tree/master/src/ZfcUserDoctrineORM
https://github.com/iwalz/zf2-doctrine2-getting-started
http://www.jasongrimes.org/2012/01/using-doctrine-2-in-zend-framework-2/
http://wildlyinaccurate.com/useful-doctrine-2-console-commands
http://stackoverflow.com/questions/14968924/doctrine-2-with-codeigniter-2-no-metadata-classes-to-process
http://stackoverflow.com/users/347063/ocramius
https://github.com/wildlyinaccurate/CodeIgniter-2-with-Doctrine-2/blob/master/application/models/Entity/User.php

http://stackoverflow.com/questions/13007477/doctrine-2-and-zf2-integration

http://phphints.wordpress.com/2010/10/28/cli-config-php-for-doctrine-2-command-line-tool/
http://phphints.wordpress.com/2010/10/28/cli-config-php-for-doctrine-2-command-line-tool/
*/