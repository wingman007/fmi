<?php
namespace AlbumTdg\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class AlbumFilter extends InputFilter
{
	public function __construct()
	{
		// self::__construct(); // parnt::__construct(); - trows and error

		 $this->add(array(
			 'name'     => 'artist',
			 'required' => true,
			 'filters'  => array(
				 array('name' => 'StripTags'),
				 array('name' => 'StringTrim'),
			 ),
			 'validators' => array(
				 array(
					 'name'    => 'StringLength',
					 'options' => array(
						 'encoding' => 'UTF-8',
						 'min'      => 1,
						 'max'      => 100,
					 ),
				 ),
			 ),
		 ));

		 $this->add(array(
			 'name'     => 'title',
			 'required' => true,
			 'filters'  => array(
				 array('name' => 'StripTags'),
				 array('name' => 'StringTrim'),
			 ),
			 'validators' => array(
				 array(
					 'name'    => 'StringLength',
					 'options' => array(
						 'encoding' => 'UTF-8',
						 'min'      => 1,
						 'max'      => 100,
					 ),
				 ),
			 ),
		 ));		

	}
}