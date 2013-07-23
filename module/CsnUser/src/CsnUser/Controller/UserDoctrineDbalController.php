<?php

namespace CsnUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Zend\Db\TableGateway\TableGateway;

use CsnUser\Form\UserForm;
use CsnUser\Form\UserFilter;

use Zend\Db\Adapter\Driver\ResultInterface;
use Zend\Db\ResultSet\HydratingResultSet;
use Zend\Stdlib\Hydrator\Reflection as ReflectionHydrator;
use CsnUser\Entity\UserEntity;

// We may prepare the Doctrine Class Loader if we didn't have Composer Autoloader and Zend Standard Autoloader
use Doctrine\Common\ClassLoader;

class UserDoctrineDbalController extends AbstractActionController
{
	private $usersTable;
	// for Doctrine
	private $conn; // part of dbal;
	private $entityManager; // ORM
	
 	public function __construct()
	{
		// self::__construct();
		$this->registerDocrineClassLoader();		
	}
	
	// R -retrieve 	CRUD
	public function indexAction()
	{
		$conn = $this->getDoctrineConn();
		$sql = "SELECT * FROM users";
		$stmt = $conn->query($sql);
		
		// We can use with Doctrine driver placeholders
//-		$sql = "SELECT * FROM users WHERE usr_id = ?";
//-		$stmt = $conn->prepare($sql);
//-		$stmt->bindValue(1, 1);
//-		$stmt->execute();

//-		$sql = "SELECT * FROM users WHERE usr_id = ? AND usr_active = ?";
//-		$stmt = $conn->prepare($sql);
//-		$stmt->bindValue(1, 1);
//-		$stmt->bindValue(2, 1);
		
//-		$sql = "SELECT * FROM users WHERE usr_id = :usr_id OR usr_active = :usr_active";
//-		$stmt = $conn->prepare($sql);
//-		$stmt->bindValue("usr_id", 1);
//-		$stmt->execute();
		
		// using cache	
//-		$cache = new \Doctrine\Common\Cache\FilesystemCache(realpath(dirname(__FILE__).'/../../../../../data/cache'));
//-		$cacheProfile = new QueryCacheProfile(0, "user_doctrine_dbal", $cache);
//-		$stmt = $conn->executeCachedQuery('SELECT* FROM users', array(), $types, $cacheProfile);

		return new ViewModel(array('rowset' => $stmt));
	}
	
	// C -Create
	public function createAction()
	{
		$form = new UserForm();
		
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
			 
				$data = $form->getData();
				unset($data['submit']); // Cannot use object of type CsnUser\Entity\UserEntity as array
				if (empty($data['usr_registration_date'])) $data['usr_registration_date'] = '2013-07-19 12:00:00';				
				$this->getDoctrineConn()->insert('users',$data);

				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-doctrine-dbal', 'action' => 'index'));										
			}
		}		
		
		return new ViewModel(array('form' => $form));
	}
	
	// U -Update
	public function updateAction()
	{
		$id = $this->params()->fromRoute('id');
		if (!$id) return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-doctrine-dbal', 'action' => 'index'));	
		
		$form = new UserForm();
		
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new UserFilter());
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				
				$data = $form->getData();
				unset($data['submit']);
				if (empty($data['usr_registration_date'])) $data['usr_registration_date'] = '2013-07-19 12:00:00';
				$this->getDoctrineConn()->update('users', $data, array('usr_id' => $id));
				
				return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-doctrine-dbal', 'action' => 'index'));
			}			 
		}
		else{
// 			$sql = "SELECT * FROM users WHERE usr_id = ?";
//			$stmt = $this->getDoctrineConn()->prepare($sql);
//			$stmt->bindValue(1, 1);
//			$stmt->execute();
			$form->setData($this->getDoctrineConn()-> fetchAssoc('SELECT * FROM users WHERE usr_id = ?', array($id)));
		}

		return new ViewModel(array('form' => $form, 'id' => $id));		
	}
	
	// D -Delete
	public function deleteAction()
	{
		$id = $this->params()->fromRoute('id');
		if ($id) {
			$this->getDoctrineConn()->delete('users', array('usr_id' => $id));
		}
		
		return $this->redirect()->toRoute('csn_user/default', array('controller' => 'user-doctrine-dbal', 'action' => 'index'));										
	}
	
	public function getUsersTable()
	{
		if (!$this->usersTable) {
		// You can use the SM to composite the object
			$resultSetPrototype = new HydratingResultSet(new ReflectionHydrator(), new UserEntity());
//			$resultSetPrototype->setObjectPrototype(new UserEntity());	
//			$resultSetPrototype->setHydrator(new ReflectionHydrator());			
			$this->usersTable = new TableGateway(
				'users', 
				$this->getServiceLocator()->get('Zend\Db\Adapter\Adapter'),
				null, // new \Zend\Db\TableGateway\Feature\RowGatewayFeature('usr_id') // Zend\Db\RowGateway\RowGateway Object
				$resultSetPrototype
			);
		}
		return $this->usersTable;
	}
	
	public function getDoctrineConn()
	{
		if (!$this->conn) {
			$config = new \Doctrine\DBAL\Configuration();
			$connectionParams = array(
				'dbname' => 'fmi',
				'user' => 'root',
				'password' => 'password',
				'host' => 'localhost',
				'driver' => 'pdo_mysql',
			);
			// DriverManager returns an instance of Doctrine\DBAL\Connection which is a wrapper around the underlying driver connection (which is often a PDO instance).
			$conn = \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $config);
			$this->conn = $conn;		
		}
		return $this->conn;
	}
	
	public function getEntityManager()
	{
		if (!$this->entityManager) {
			$this->dbal;
		}
		return $this->entityManager;
	}
	
	// We don't have to do that we have enough autoloaders already registered: Composer and Eventualy Zend
	// this could go to doctrine_autoloader.php or init_autoloader.php
	public function registerDocrineClassLoader()
	{
/*
		echo '__DIR__ = ' . __DIR__ . "<br />\n";
		// __DIR__ = C:\Documents and Settings\user\fmi\module\CsnUser\src\CsnUser\Controller

		echo 'realpath(__FILE__) = ' . realpath(__FILE__) . "<br />\n";
		// realpath(__FILE__) = C:\Documents and Settings\user\fmi\module\CsnUser\src\CsnUser\Controller\UserDoctrineController.php

		echo 'realpath(__DIR__) = ' . realpath(__DIR__) . "<br />\n";
		// realpath(__DIR__) = C:\Documents and Settings\user\fmi\module\CsnUser\src\CsnUser\Controller

		echo 'dirname(__DIR__) = ' . dirname(__DIR__) . "<br />\n";
		// dirname(__DIR__) = C:\Documents and Settings\user\fmi\module\CsnUser\src\CsnUser

		echo 'realpath(dirname(__FILE__)."/../../../../../vendor/doctrine/common/lib/Doctrine/Common"' . realpath(dirname(__FILE__).'/../../../../../vendor/doctrine/common/lib/Doctrine/Common') . "<br />\n";
		// realpath(dirname(__FILE__)."/../../../../../vendor/doctrine/common/lib/Doctrine/Common"C:\Documents and Settings\user\fmi\vendor\doctrine\common\lib\Doctrine\Common
		require realpath(dirname(__FILE__).'/../../../../../vendor/doctrine/common/lib/Doctrine/Common/ClassLoader.php');

//-		$pathToDoctrineCommon = realpath(dirname(__FILE__).'/../../../../../vendor/doctrine/common/lib/Doctrine/Common/');
		$pathToDoctrineCommon = realpath(dirname(__FILE__).'/../../../../../vendor/doctrine/common/lib/');
		echo "pathToDoctrineCommon = " . $pathToDoctrineCommon . "<br />\n";
		// pathToDoctrineCommon = C:\Documents and Settings\user\fmi\vendor\doctrine\common\lib\Doctrine\Common\ClassLoader.php
		// The autoloader works when we point  to this folder:
		// pathToDoctrineCommon = C:\Documents and Settings\user\fmi\vendor\doctrine\common\lib
*/		
		// Common loader
		$pathToDoctrineCommon = realpath(dirname(__FILE__).'/../../../../../vendor/doctrine/common/lib/');
		$classLoaderCommon = new ClassLoader('Doctrine\Common', $pathToDoctrineCommon); // it works perfect like this
		$classLoaderCommon->register(); // spl_autoload_register(array($this, 'loadClass')); gets registered	
//-		echo '$classLoaderCommon->canLoadClass("Doctrine\Common\EventManager") = ' . $classLoaderCommon->canLoadClass('Doctrine\Common\EventManager') . "<br />\n";
//-		print_r($classLoaderCommon->getClassLoader('Doctrine\Common\EventManager'));
		
		// DBAL loader
		$pathToDoctrineDbal = realpath(dirname(__FILE__).'/../../../../../vendor/doctrine/dbal/lib/');
		$classLoaderDbal = new ClassLoader('Doctrine\DBAL', $pathToDoctrineDbal); // it works perfect like this
		$classLoaderDbal->register(); // spl_autoload_register(array($this, 'loadClass')); gets registered
//-		echo '$classLoaderDbal->canLoadClass("Doctrine\DBAL\DriverManager") = ' . $classLoaderDbal->canLoadClass('Doctrine\DBAL\DriverManager') . "<br />\n";
//-		print_r($classLoaderDbal->getClassLoader('Doctrine\DBAL\DriverManager'));
		
		// ORM loader
		$pathToDoctrineOrm = realpath(dirname(__FILE__).'/../../../../../vendor/doctrine/orm/lib/');
		$classLoaderOrm = new ClassLoader('Doctrine\ORM', $pathToDoctrineOrm); // it works perfect like this
		$classLoaderOrm->register(); // spl_autoload_register(array($this, 'loadClass')); gets registered
//-		echo '$classLoaderOrm->canLoadClass("Doctrine\ORM\EntityManager") = ' . $classLoaderOrm->canLoadClass('Doctrine\ORM\EntityManager') . "<br />\n";	
//-		print_r($classLoaderOrm->getClassLoader('Doctrine\ORM\EntityManager'));
		// Doctrine\Common\ClassLoader Object ( [fileExtension:protected] => .php [namespace:protected] => Doctrine\ORM [includePath:protected] => C:\Documents and Settings\user\fmi\vendor\doctrine\orm\lib [namespaceSeparator:protected] => \ )
	}
}