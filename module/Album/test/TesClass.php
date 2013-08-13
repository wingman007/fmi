<?php
// This calss is just to illustrate concepts. It doesn't work.
class TestClass
{
	public function testIndexAction
	{
		$controller = new AlbumController();
		$this->assert($controller->indexActon(), 3);
	}
	
	public function assertionEqual($value1, $value)
	{
		return ($value1 == $value2)? true : false;
	}
	
	
}