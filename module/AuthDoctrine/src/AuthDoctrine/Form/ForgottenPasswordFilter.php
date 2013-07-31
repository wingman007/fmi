<?php
namespace AuthDoctrine\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class ForgottenPasswordFilter extends InputFilter
{
	public function __construct($sm)
	{
        $this->add(array(
            'name'       => 'usrEmail',
            'required'   => true,
            'validators' => array(
                array(
                    'name' => 'EmailAddress'
                ),
				array(
					'name'		=> 'DoctrineModule\Validator\ObjectExists',
					'options' => array(
						'object_repository' => $sm->get('doctrine.entitymanager.orm_default')->getRepository('AuthDoctrine\Entity\User'),
						'fields'            => 'usrEmail'
					),
				),
            ),
        ));	
	}
}