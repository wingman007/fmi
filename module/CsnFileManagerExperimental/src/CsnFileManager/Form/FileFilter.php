<?php
namespace CsnFileManager\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class FileFilter extends InputFilter
{
	public function __construct($path)
	{
		
		$filter = new \Zend\Filter\File\Rename($path);
		$this->add($filter);
/*
		// self::__construct(); // parent::__construct(); - trows and error
		$this->add(array(
			'name'     => 'usrName',
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
					'name'		=> 'DoctrineModule\Validator\NoObjectExists',
					'options' => array(
						'object_repository' => $sm->get('doctrine.entitymanager.orm_default')->getRepository('AuthDoctrine\Entity\User'),
						'fields'            => 'usrName'
					),
				),
			),
		));

        $this->add(array(
            'name'       => 'usrEmail',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress'
                ),
				array(
					'name'		=> 'DoctrineModule\Validator\NoObjectExists',
					'options' => array(
						'object_repository' => $sm->get('doctrine.entitymanager.orm_default')->getRepository('AuthDoctrine\Entity\User'),
						'fields'            => 'usrEmail'
					),
				),
            ),
        ));
		
		$this->add(array(
			'name'     => 'usrPassword',
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

		$this->add(array(
			'name'     => 'usrPasswordConfirm',
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
                array(
                    'name'    => 'Identical',
                    'options' => array(
                        'token' => 'usrPassword',
                    ),
                ),
			),
		));	
*/		
	}
}