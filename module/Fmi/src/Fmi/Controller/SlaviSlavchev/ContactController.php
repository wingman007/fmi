<?php
	class ContactController extends AdminController {
		public function __construct() {
			parent::__construct();
		}
		
		public function indexAction() {
			$this->loadModel('Contact');
			$this->loadView();
			$mails = $this->model->getData('#_contact_sentmails', null, null, 'sentmail_id', 'DESC');
			
			$this->view->set('mails', $mails);
			$this->view->display();
		}
		
		public function settingsAction() {
			$this->loadModel('Contact');
			$this->loadView('settings');
			$settings = $this->model->getData('#_contact_settings');
			//echo "<pre>";print_r($settings);exit;
			
			if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
			{
				$update_settings = array(
					'mail_to' => $_POST['mail_to'],
					'captcha_public_key' => $_POST['captcha_public_key'],
					'captcha_private_key' => $_POST['captcha_private_key'],
					'show_captcha' => (int)$_POST['show_captcha'],
					'show_tel' => (int)$_POST['show_tel'],
					'show_extra_info' => (int)$_POST['show_extra_info'],
					'use_captcha' => $_POST['use_captcha'],
				);

				$this->model->updateSettings('#_contact_settings', $update_settings);
				
				$error[] = $this->lang['c_updated'];
				$this->setMessage($error, 'success');
			}
			
			$settings = $this->model->getData('#_contact_settings');
			//echo "<pre>";print_r($settings);echo "</pre>";
			
			$this->view->set('settings', $settings);
			$this->view->display();
			
		}
		
		public function viewAction() {
			$this->loadModel('Contact');
			$this->loadView();
			
			$mail_id = (int)$this->getParam('view');
			
			$contact = $this->model->getRow('#_contact_sentmails', array('sentmail_id' => $mail_id));
			
			$this->view->set('contact', $contact);
			$this->view->display();
		}
	}