<?php
namespace AuthDoctrine\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        // we want to ignore the name passed
        parent::__construct('auth');
        $this->setAttribute('method', 'post');
        /*
		$this->add(array(
            'name' => 'usr_id',
            'attributes' => array(
                'type'  => 'hidden',
            ),
        ));
		*/
        $this->add(array(
            'name' => 'username', // 'usr_name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));
        $this->add(array(
            'name' => 'password', // 'usr_password',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

        $this->add(array(
            'name' => 'rememberme',
			'type' => 'checkbox', // 'Zend\Form\Element\Checkbox',			
//            'attributes' => array(
//                'type'  => '\Zend\Form\Element\Checkbox',
//            ),
            'options' => array(
                'label' => 'Remember Me?',
//				'checked_value' => 'true', without value here will be 1
//				'unchecked_value' => 'false', // witll be 1
            ),
        ));	

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Login',
                'id' => 'submitbutton',
            ),
        )); 
    }
}