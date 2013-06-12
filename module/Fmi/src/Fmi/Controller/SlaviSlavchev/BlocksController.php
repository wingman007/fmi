<?php
	class BlocksController extends AdminController{
		public function __construct() {
			parent::__construct();
		}
		
		public function indexAction() {
			$this->loadModel();
			$this->loadView('blocks/index');
			
			$blocks = $this->model->getBlocks();
			
			$this->view->set('blocks', $blocks);
			$this->view->display();
		}
		
		public function addAction() {
			$this->loadModel();
			$this->loadView('blocks/add');
			
			if(strtolower($_SERVER['REQUEST_METHOD']) == "post")
			{
				$block = array(
					'block_langId' => (int)$_POST['block_langId'],
					'block_title' => $this->clear($_POST['block_title']),
					'block_name' => $this->clear($_POST['block_name']),
					'block_content' => addslashes($_POST['block_content']),
					'block_dateAdded' => date('Y-m-d H:i:s'),
					'block_dateModified' => date('Y-m-d H:i:s'),
					'block_isactive' => (int)$_POST['block_isactive']
				);
				
				// checks
				if(empty($block['block_title'])) $error[] = $this->lang['not_entered']. $this->lang['title'];
				if(empty($block['block_name'])) $error[] = $this->lang['not_entered']. $this->lang['name'];
				if(empty($block['block_content'])) $error[] = $this->lang['not_entered']. $this->lang['message'];
				
				if(!$error)
				{
					// insert into db
					$this->model->db->insert('#_cms_blocks', $block);
					
					$error[] = $this->lang['block_added'];
					$this->setMessage($error, 'success');
				}
				else
					$this->setMessage($error, 'error');
			}
			
			$languages = $this->model->getData('#_lang', null, null, 'lang_id', 'DESC');
			
			$this->view->set('languages', $languages);
			$this->view->display();
		}
		
		public function editAction() {
			$this->loadModel();
			$this->loadView('blocks/edit');
			
			$block_id = (int)$this->getParam('edit');
			
			if(strtolower($_SERVER['REQUEST_METHOD']) == "post")
			{
				$block = array(
					'block_langId' => (int)$_POST['block_langId'],
					'block_title' => $this->clear($_POST['block_title']),
					'block_name' => $this->clear($_POST['block_name']),
					'block_content' => addslashes($_POST['block_content']),
					'block_dateModified' => date('Y-m-d H:i:s'),
					'block_isactive' => (int)$_POST['block_isactive']
				);
				
				// checks
				if(empty($block['block_title'])) $error[] = $this->lang['not_entered']. $this->lang['title'];
				if(empty($block['block_name'])) $error[] = $this->lang['not_entered']. $this->lang['name'];
				if(empty($block['block_content'])) $error[] = $this->lang['not_entered']. $this->lang['message'];
				
				if(!$error)
				{
					// insert into db
					$this->model->db->update('#_cms_blocks', $block, "block_id = '$block_id'");
					
					$error[] = $this->lang['block_edited'];
					$this->setMessage($error, 'success');
					
					// redirect 
					if(isset($_POST['submit'])) $this->_call("/admincp/content/blocks/");
				}
				else
					$this->setMessage($error, 'error');
			}
			
			$old_block = $this->model->getRow('#_cms_blocks', array('block_id' => $block_id));
			
			$languages = $this->model->getData('#_lang', null, null, 'lang_id', 'DESC');
			
			$this->view->set('old_block', $old_block);
			$this->view->set('block_id', $block_id);
			$this->view->set('languages', $languages);
			$this->view->display();
		}
		
		public function deleteAction(){
			$this->loadModel();
			
			$block_id = (int)$this->getParam('delete');
			$this->model->db->delete('#_cms_blocks', "block_id = '$block_id'");
			
			$this->_call($_SERVER['HTTP_REFERER']);
		}
	}