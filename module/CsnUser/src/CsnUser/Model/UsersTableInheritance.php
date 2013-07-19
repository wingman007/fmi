<?php

namespace CsnUser\Model;
// If you are going to extend and inherit use AbstractTableGateway
use Zend\Db\TableGateway\AbstractTableGateway
use Zend\Db\Adapter\Adapter;

class UsersTable extends AbstractTableGateway
{
	public function __construct(Adapter $adapter)
	{
		$this->table = 'users';
		$this->adapter = $adapter;
	}
	// Here i can have a lot of methods serving as repo for SQL statements
}