<?php 

namespace AlbumTdg\Model\Table;

use Zend\Db\TableGateway\TableGateway;

class Album extends TableGateway
{
	public function __construct($adapter)
	{
		parent::__construct(__CLASS__, $adapter);
	}
	
	public function getComplexQuery($id = 2)
	{
		$adapter = $this->getAdapter();
		$result = $adapter->query('SELECT * FROM `album` WHERE `id` = ?', array($id));
		return $result;
	}
}