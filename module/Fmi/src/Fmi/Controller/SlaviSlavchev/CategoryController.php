<?php
	class CategoryController extends AdminController {
		public function __construct() {
			parent::__construct();
		}
		
		public function indexAction()
		{
			$this->loadModel();
			$categories = $this->model->getCats();
			
			//echo "<pre>";print_r($categories);echo "</pre>";
			
			$this->loadView('category/index');
			$this->view->set('categories', $categories);
			$this->view->display();
		}
		
		public function addAction() {
			$this->loadModel();
			$this->loadView('category/add');
			
			if(strtolower($_SERVER['REQUEST_METHOD']) == "post")
			{
				loader::loadClass('Filter');
				loader::loadClass('Image');
				$user = User::getInstance();
				$user->getId();
				
				$category = array(
					'cat_parentId' => (int)$_POST['cat_parentId'],
					'cat_langId' => (int)$_POST['cat_langId'],
					'cat_userId' => $user->getId(),
					'cat_name' => $this->clear($_POST['cat_name']),
					'cat_seoUrl' => $this->clear($_POST['cat_seoUrl']),
					'cat_description' => addslashes($_POST['cat_description']),
					'cat_descriptionCleared' => Filter::clearHtml($_POST['cat_description']),
					'cat_metaDesc' => $this->clear($_POST['cat_metaDesc']),
					'cat_metaKeywords' => $this->clear($_POST['cat_metaKeywords']),
					'cat_metaData' => $this->clear($_POST['cat_metaData']),
					'cat_dateAdded'	 => date('Y-m-d H:i:s'),
					'cat_dateModified' => date('Y-m-d H:i:s'),
					'cat_titleTag' => $this->clear($_POST['cat_titleTag']),
					'cat_picture' => $_FILES['cat_picture']['name'],
					'cat_isactive' => (int)$_POST['cat_isactive'],
					'cat_template' => $this->clear($_POST['cat_template']),
				);
				
				// checks
				if(empty($category['cat_name'])) $error[] = $this->lang['not_entered']. $this->lang['category_name'];
				if($_FILES['cat_picture']['tmp_name']) 
				{
					if(!Filter::checkFileExt($_FILES['cat_picture']['type']))
						$error[] = $this->lang['allowed_types'];
				}
				
				// if seo url is empty we generate one
				if(empty($category['cat_seoUrl'])) $category['cat_seoUrl'] = $this->model->convertToSeoUrl($_POST['cat_name']);
				
				// Check for a duplicate SEO Url
				if ($this->router->checkDuplicate($category['cat_seoUrl'])) $error[] = $this->lang['duplicate_seo_url'];
				
				if(!$error)
				{
					// insert into db
					$this->model->db->insert('#_categories', $category);
					$last_id = $this->model->db->lastInsertId();
					
					$dir = "public/upload/categories/$last_id/";
					$filename = $_FILES['cat_picture']['name'];
					
					// make the dirs
					mkdir($dir, 0777);
					mkdir($dir . "original/", 0777);
					mkdir($dir . "100/", 0777);
					mkdir($dir . "150/", 0777);
					mkdir($dir . "200/", 0777);
					mkdir($dir . "300/", 0777);
					mkdir($dir . "500/", 0777);
					mkdir($dir . "700/", 0777);
					mkdir($dir . "1000/", 0777);
					
					// if there was an uploaded file
					if($_FILES['cat_picture']['tmp_name'])
					{
						// we move the file to the original category dir
						move_uploaded_file($_FILES["cat_picture"]["tmp_name"], $dir . "original/". $filename);
						
						// generate thumbnails
						$image = new Image();
						$image->start($dir . "original/" . $filename);
						$image->resize(1000);
						$image->save($dir . "1000/" . $filename);
						$image->resize(700);
						$image->save($dir . "700/" . $filename);
						$image->resize(500);
						$image->save($dir . "500/" . $filename);
						$image->resize(300);
						$image->save($dir . "300/" . $filename);
						$image->resize(200);
						$image->save($dir . "200/" . $filename);
						$image->resize(150);
						$image->save($dir . "150/" . $filename);
						$image->resize(100);
						$image->save($dir . "100/" . $filename);
					}
					
					// Store the SEO Url in the router table
					$route_url = '/content/category/view/' . $last_id;
					$this->router->addRule($category['cat_seoUrl'], $route_url, 'Content', 'Category', 'View', $last_id);
					
					$error[] = $this->lang['category_added'];
					$this->setMessage($error, 'success');
					
				}
				else
				{
					$this->setMessage($error, 'error');
				}
				
				//echo "<pre>";print_r($category);echo "</pre>";
				
				
			}
			
			$categories = $this->model->getData('#_categories', null, null, 'cat_id', 'DESC');
			$languages = $this->model->getData('#_lang', null, null, 'lang_id', 'DESC');
			
			
			$this->view->set('categories', $categories);
			$this->view->set('languages', $languages);
			$this->view->display();
		}
		
		public function editAction() {
			$this->loadModel();
			$this->loadView('category/edit');
			$cat_id = (int)$this->getParam('edit');
			
			$old_cat = $this->model->getRow('#_categories', array('cat_id' => $cat_id));
		
			if(strtolower($_SERVER['REQUEST_METHOD']) == "post")
			{
				loader::loadClass('Filter');
				loader::loadClass('Image');
				$user = User::getInstance();
				$user->getId();
				
				$category = array(
					'cat_parentId' => (int)$_POST['cat_parentId'],
					'cat_langId' => (int)$_POST['cat_langId'],
					'cat_name' => $this->clear($_POST['cat_name']),
					'cat_seoUrl' => $this->clear($_POST['cat_seoUrl']),
					'cat_description' => addslashes($_POST['cat_description']),
					'cat_descriptionCleared' => Filter::clearHtml($_POST['cat_description']),
					'cat_metaDesc' => $this->clear($_POST['cat_metaDesc']),
					'cat_metaKeywords' => $this->clear($_POST['cat_metaKeywords']),
					'cat_metaData' => $this->clear($_POST['cat_metaData']),
					'cat_dateModified' => date('Y-m-d H:i:s'),
					'cat_titleTag' => $this->clear($_POST['cat_titleTag']),
					'cat_isactive' => (int)$_POST['cat_isactive'],
					'cat_template' => $this->clear($_POST['cat_template']),
				);
				
				// checks
				if(empty($category['cat_name'])) $error[] = $this->lang['not_entered']. $this->lang['category_name'];
				if($_FILES['cat_picture']['tmp_name']) 
				{
					if(!Filter::checkFileExt($_FILES['cat_picture']['type']))
						$error[] = $this->lang['allowed_types'];
					
					$category['cat_picture'] = $_FILES['cat_picture']['name'];
				}
				
				// if seo url is empty we generate one
				if(empty($category['cat_seoUrl'])) $category['cat_seoUrl'] = $this->model->convertToSeoUrl($_POST['cat_name']);
				
				if($old_cat['cat_seoUrl'] != $category['cat_seoUrl'])
				{
					// Check for a duplicate SEO Url
					if ($this->router->checkDuplicate($category['cat_seoUrl'])) $error[] = $this->lang['duplicate_seo_url'];
				}
				
				if(!$error)
				{
					// update db
					$this->model->db->update('#_categories', $category, "cat_id = '$cat_id'");
					$last_id = $cat_id;
					
					$dir = "public/upload/categories/$last_id/";
					$filename = $_FILES['cat_picture']['name'];
					
					// if there was an uploaded file
					if($_FILES['cat_picture']['tmp_name'])
					{
						// first we must remove the old image
						unlink($dir . "original/" .$old_cat['cat_picture']);
						unlink($dir . "1000/" .$old_cat['cat_picture']);
						unlink($dir . "700/" .$old_cat['cat_picture']);
						unlink($dir . "500/" .$old_cat['cat_picture']);
						unlink($dir . "300/" .$old_cat['cat_picture']);
						unlink($dir . "200/" .$old_cat['cat_picture']);
						unlink($dir . "150/" .$old_cat['cat_picture']);
						unlink($dir . "100/" .$old_cat['cat_picture']);
					
						// we move the file to the original category dir
						move_uploaded_file($_FILES["cat_picture"]["tmp_name"], $dir . "original/". $filename);
						
						// generate thumbnails
						$image = new Image();
						$image->start($dir . "original/" . $filename);
						$image->resize(1000);
						$image->save($dir . "1000/" . $filename);
						$image->resize(700);
						$image->save($dir . "700/" . $filename);
						$image->resize(500);
						$image->save($dir . "500/" . $filename);
						$image->resize(300);
						$image->save($dir . "300/" . $filename);
						$image->resize(200);
						$image->save($dir . "200/" . $filename);
						$image->resize(150);
						$image->save($dir . "150/" . $filename);
						$image->resize(100);
						$image->save($dir . "100/" . $filename);
					}
					
					// update the SEO Url in the router table
					$seo_url_array = array(
						'route_seo_url' => $category['cat_seoUrl'],
						'route_url' => '/content/category/view/' . $last_id,
					);
					$this->model->db->update('#_route', $seo_url_array, "item_id = $last_id");
					
					$error[] = $this->lang['category_edited'];
					$this->setMessage($error, 'success');
					
					// redirect 
					if(isset($_POST['submit'])) $this->_call("/admincp/content/category/");
					
				}
				else
				{
					$this->setMessage($error, 'error');
				}
			}
			
			//echo "<pre>";print_r($category);echo "</pre>";
		
			$old_cat = $this->model->getRow('#_categories', array('cat_id' => $cat_id));
			$categories = $this->model->getData('#_categories', null, null, 'cat_id', 'DESC');
			$languages = $this->model->getData('#_lang', null, null, 'lang_id', 'DESC');
			
		
			$this->view->set('old_cat', $old_cat);
			$this->view->set('cat_id', $cat_id);
			$this->view->set('categories', $categories);
			$this->view->set('languages', $languages);
			$this->view->display();
			
		}
		
		public function checkSeoUrlAction() {
			$this->loadModel();
			//$_POST['cat_seoUrl'] = 'Новини';
			echo $this->model->checkSeoUrl($_POST['cat_seoUrl'], "cat_id");
			exit;
		}
		
		public function generateSeoUrlAction() {
			$this->loadModel();
			echo $this->model->convertToSeoUrl($_POST['cat_name']);
			exit;
		}
		
		public function deleteAction() {
			$delete_id = (int)$this->getParam('delete');
			$this->loadModel();
			$cat_info = $this->model->getRow('#_categories', array('cat_id' => $delete_id));
			
			
			// remove dir
			loader::loadClass('Dir');
			Dir::rmdir_r("public/upload/categories/$delete_id/");
			
			// delete from db
			$this->model->db->delete('#_categories', "cat_id = '$delete_id'");
			
			// delete from route db
			$this->model->db->delete('#_route', "route_seo_url = '".$cat_info['cat_seoUrl'] ."' ");
			
			// redirect to previus page
			$this->_call($_SERVER['HTTP_REFERER']);
			
		}
		
	}