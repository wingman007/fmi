<?php	
	class CommentController extends AdminController {		
		public function __construct() {
			parent::__construct();
		}
		
		public function indexAction() {
			$this->loadModel();
			$this->loadView();
			
			$comments = $this->model->getWaitingComments();
			//echo "<pre>";print_r($comments);echo "</pre>";
			
			$this->view->set('comments', $comments);
			$this->view->display();
		}
		
		public function allAction() {
			$this->loadModel();
			$this->loadView('index');
			
			$comments = $this->model->getAllComments();
			
			$this->view->set('comments', $comments);
			$this->view->display();
		}
		
		public function reportedAction() {
			$this->loadModel();
			$this->loadView();
			
			$comments = $this->model->getReportedComments();
			$this->view->set('comments', $comments);
			$this->view->display();
		}
		
		public function editAction() {
			$this->loadModel();
			$this->loadView();
			
			$com_id = (int)$this->getParam('edit');
			
			if(strtolower($_SERVER['REQUEST_METHOD']) == "post")
			{
				$comment = array(
					'com_text' => $this->clear($_POST['com_text']),
					'com_status' => $_POST['com_status'],
					'com_isactive' => (int)$_POST['com_isactive'],
				);
				
				if(!$error)
				{
					$this->model->db->update('#_comments', $comment, "com_id = '$com_id' ");
					
					$error[] = $this->lang['comment_edited'];
					$this->setMessage($error, "success");
					
					// redirect 
					if(isset($_POST['submit'])) $this->_call("/admincp/comment/");
				}
				else
					$this->setMessage($error, "error");
					
			}
			
			// get comment
			$comment = $this->model->getComment($com_id);
			#echo "<pre>";print_r($comment);echo "</pre>";
			
			$this->view->set('com_id', $com_id);
			$this->view->set('comment', $comment);
			$this->view->display();
		}
		
		public function deleteAction() {
			$this->loadModel();
			
			$com_id = (int)$this->getParam('delete');
			
			$this->model->db->delete('#_comments', "com_id = '$com_id' ");
			
			$this->_call($_SERVER['HTTP_REFERER']);
		}
		
		public function settingsAction() {
			$settingsModel = $this->loadModel('SettingsM', 'admincp', 'Settings', true);
			$contactModel = $this->loadModel('Contact', 'admincp', 'Contact', true);
			$this->loadModel();
			$this->loadView();
			
			$current_settings = $settingsModel->getSettings();
			$settings = $this->model->getData('#_contact_settings');
			
			if(strtolower($_SERVER['REQUEST_METHOD']) == "post") {
				$settings = array(
					'comment_terms_link' => $_POST['comment_terms_link'],
					'comment_show_gravatar' => (int)$_POST['comment_show_gravatar'],
					'comment_num_likes_marking' => $_POST['comment_num_likes_marking'],
					'comment_show_captcha' => (int)$_POST['comment_show_captcha'],
					'comment_captcha' => $_POST['comment_captcha'],
				);
				
				$settingsModel->updateSettings('#_config', $settings);
				
				$recaptcha_settings = array(
					'captcha_public_key' => $_POST['captcha_public_key'],
					'captcha_private_key' => $_POST['captcha_private_key'],
				);
				
				$contactModel->updateSettings('#_contact_settings', $recaptcha_settings);
			}
			
			$current_settings = $settingsModel->getSettings();
			$settings = $this->model->getData('#_contact_settings');
			#echo "<pre>";print_r($settings);echo "</pre>";
			
			$this->view->set('settings', $settings);
			$this->view->set('current_settings', $current_settings);
			$this->view->display();
		}
	}