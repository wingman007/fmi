<?php
namespace AuthDoctrine\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter
{
	public function __construct($sm)
	{
		// self::__construct(); // parnt::__construct(); - trows and error
		$this->add(array(
			'name'     => 'username', // 'usr_name'
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
				array(
					'name'		=> 'Zend\Validator\Db\RecordExists',
					'options' => array(
						'table'   => 'users',
						'field'   => 'usr_name',
						'adapter' => $sm->get('Zend\Db\Adapter\Adapter'),
					),
				),
			),
		));
		
		$this->add(array(
			'name'     => 'password', // usr_password
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
						'min'      => 6,
						'max'      => 12,
					),
				),
			),
		));		
	}
}