<?php
namespace AuthDoctrine\Controller;

// Authentication with Remember Me
// http://samsonasik.wordpress.com/2012/10/23/zend-framework-2-create-login-authentication-using-authenticationservice-with-rememberme/

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

// use Auth\Model\Auth;          we don't need the model here we will use Doctrine em 
use AuthDoctrine\Entity\User; // only for the filters
use AuthDoctrine\Form\LoginForm;       // <-- Add this import
use AuthDoctrine\Form\LoginFilter;

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
            //- $authFormFilters = new User(); // we use the Entity for the filters
			// TODO fix the filters
            //- $form->setInputFilter($authFormFilters->getInputFilter());

			// Filters have been fixed
			$form->setInputFilter(new LoginFilter($this->getServiceLocator()));
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
				$adapter->setIdentityValue($data['username']); //$data['usr_name']
				$adapter->setCredentialValue($data['password']); // $data['usr_password']
				$authResult = $authService->authenticate();
				// echo "<h1>I am here</h1>";
				if ($authResult->isValid()) {
					$identity = $authResult->getIdentity();
					$authService->getStorage()->write($identity);
					$time = 1209600; // 14 days 1209600/3600 = 336 hours => 336/24 = 14 days
//-					if ($data['rememberme']) $authService->getStorage()->session->getManager()->rememberMe($time); // no way to get the session
					if ($data['rememberme']) {
						$sessionManager = new \Zend\Session\SessionManager();
						$sessionManager->rememberMe($time);
					}
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
//-		$auth->getStorage()->session->getManager()->forgetMe(); // no way to get to the sessionManager from the storage
		$sessionManager = new \Zend\Session\SessionManager();
		$sessionManager->forgetMe();
		
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