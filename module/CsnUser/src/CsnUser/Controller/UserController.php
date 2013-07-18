<?php
namespace CsnUser\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{
	// R - Retrieve
    public function indexAction()
    {
		// 1) Using MySQL API
		$link = mysql_connect('localhost', 'root', 'password');
		if (!$link) {
			die('Could not connect: ' . mysql_error());
		}
		echo 'Connected successfully';
		
		
		$sql    = 'SELECT usr_id FROM fmi.users WHERE usr_id = 1';
		$result = mysql_query($sql, $link);

		if (!$result) {
			echo "DB Error, could not query the database\n";
			echo 'MySQL Error: ' . mysql_error();
			exit;
		}

		while ($row = mysql_fetch_assoc($result)) {
			echo $row['usr_id'];
		}

		mysql_free_result($result);
		
		mysql_close($link);
		
        return new ViewModel();
    }
	
	// C - Create
    public function createAction()
    {
		$link = mysql_connect('localhost', 'root', 'password');
		
        return new ViewModel();
    }
	
	// U - Update
    public function updateAction()
    {
        return new ViewModel();
    }
	
	// D - Delete
    public function deleteAction()
    {
        return new ViewModel();
    }
}