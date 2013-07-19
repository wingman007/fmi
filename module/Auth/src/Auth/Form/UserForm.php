<?php
namespace Auth\Form;

use Zend\Form\Form;

class UserForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'usr_name',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Username',
            ),
        ));
		
        $this->add(array(
            'name' => 'usr_password',
            'attributes' => array(
                'type'  => 'password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

        $this->add(array(
            'name' => 'usr_email',
            'attributes' => array(
                'type'  => 'email',
            ),
            'options' => array(
                'label' => 'E-mail',
            ),
        ));	

        $this->add(array(
            'name' => 'usrl_id',
			'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Role',
				'value_options' => array(
					'1' => 'Public',
					'2' => 'Member',
					'3' => 'Admin',
				),
            ),
        ));	

        $this->add(array(
            'name' => 'lng_id',
			'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Language',
				'value_options' => array(
					'1' => 'English',
					'2' => 'French',
					'3' => 'German',
				),
            ),
        ));
		
        $this->add(array(
            'name' => 'usr_active',
			'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'Active',
				'value_options' => array(
					'0' => 'No',
					'1' => 'Yes',
				),
            ),
        ));

        $this->add(array(
            'name' => 'usr_question',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Question',
            ),
        ));

        $this->add(array(
            'name' => 'usr_answer',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Answer',
            ),
        ));
		
        $this->add(array(
            'name' => 'usr_picture',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Picture URL',
            ),
        ));
		
        $this->add(array(
            'name' => 'usr_password_salt',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Password Salt',
            ),
        ));
		
        $this->add(array(
            'name' => 'usr_registration_date',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Registration Date',
            ),
        ));	

        $this->add(array(
            'name' => 'usr_registration_token',
            'attributes' => array(
                'type'  => 'text',
            ),
            'options' => array(
                'label' => 'Registration Token',
            ),
        ));			

        $this->add(array(
            'name' => 'usr_email_confirmed',
			'type' => 'Zend\Form\Element\Select',
            'options' => array(
                'label' => 'E-mail was confirmed?',
				'value_options' => array(
					'0' => 'No',
					'1' => 'Yes',
				),
            ),
        ));
		
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        )); 
    }
}