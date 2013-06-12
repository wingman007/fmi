<?php
	class ContentController extends AdminController {
		public function __construct() {
			parent::__construct();
		}
		
		public function indexAction()
		{		
			$this->loadModel();
			$content = $this->model->getCont();
			
			//echo "<pre>";print_r($categories);echo "</pre>";
			
			$this->loadView('content/index');
			$this->view->set('content', $content);
			$this->view->display();
		}
		
		public function addAction() {
			$tagModel = $this->loadModel('Tag', 'admincp', 'Tag', true);
			$this->loadModel();
			$this->loadView('content/add');
			
			if(strtolower($_SERVER['REQUEST_METHOD']) == "post")
			{
				loader::loadClass('Filter');
				loader::loadClass('Image');
				$user = User::getInstance();
				$user->getId();
				
				$content = array(
					'cont_parentId' => (int)$_POST['cont_parentId'],
					'cont_langId' => (int)$_POST['cont_langId'],
					'cont_catId' => (int)$_POST['cont_catId'],
					'cont_userId' => $user->getId(),
					'cont_name' => $this->clear($_POST['cont_name']),
					'cont_seoUrl' => $this->clear($_POST['cont_seoUrl']),
					'cont_text' => addslashes($_POST['cont_text']),
					'cont_textCleared' => Filter::clearHtml($_POST['cont_text']),
					'cont_intro' => addslashes($_POST['cont_intro']),
					'cont_introCleared' => Filter::clearHtml($_POST['cont_intro']),
					'cont_metaDesc' => $this->clear($_POST['cont_metaDesc']),
					'cont_metaKeywords' => $this->clear($_POST['cont_metaKeywords']),
					'cont_metaData' => $this->clear($_POST['cont_metaData']),
					'cont_dateAdded'	 => date('Y-m-d H:i:s'),
					'cont_dateModified' => date('Y-m-d H:i:s'),
					'cont_titleTag' => $this->clear($_POST['cont_titleTag']),
					'cont_isactive' => (int)$_POST['cont_isactive'],
					'cont_datePublish' => $this->clear($_POST['cont_datePublishDate']) . " " . $this->clear($_POST['cont_datePublishTime']),
				);
				
				// checks
				if(empty($content['cont_name'])) $error[] = $this->lang['not_entered']. $this->lang['content_name'];
				// if seo url is empty we generate one
				if(empty($content['cont_seoUrl'])) $content['cont_seoUrl'] = $this->model->convertToSeoUrl($_POST['cat_name']);
				
				// Check for a duplicate SEO Url
				if ($this->router->checkDuplicate($content['cont_seoUrl'])) $error[] = $this->lang['duplicate_seo_url'];
				
				if(!$error)
				{
					// insert into db
					$this->model->db->insert('#_content', $content);
					$last_id = $this->model->db->lastInsertId();
					
					$dir = "public/upload/content/$last_id/";
					
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
					
					if($_FILES['cont_pictures']['tmp_name'][0])
					{
						for($i = 0; $i<count($_FILES['cont_pictures']['name']); $i++)
						{
							// this uploads only images 
							if(Filter::checkFileExt($_FILES['cont_pictures']['type'][$i]))
							{
								$filename = $_FILES["cont_pictures"]["name"][$i];
								
								// we move the file to the original category dir
								move_uploaded_file($_FILES["cont_pictures"]["tmp_name"][$i], $dir . "original/". $filename);
								
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
								
								$image_size = getimagesize($dir . "original/" . $filename);
								//echo "<pre>";print_r($image_size);echo "</pre>";
								
								// add to db
								$image = array(
									'ci_contId' => $last_id,
									'ci_filename' => $filename,
									'ci_width' => $image_size[0],
									'ci_height' => $image_size[1],
									'ci_dateAdded' => date('Y-m-d H:i:s'),
									'ci_dateModified' => date('Y-m-d H:i:s')
								);
								
								$this->model->db->insert('#_content_images', $image);
								
								//echo "<pre>";print_r($image);echo "</pre>";
							}
						}
						
					}
					
					// Store the SEO Url in the router table
					$route_url = '/content/content/view/' . $last_id;
					$this->router->addRule($content['cont_seoUrl'], $route_url, 'Content', 'Content', 'View', $last_id);
					
					// add tags
					if(!empty($_POST['tags']))
						$tagModel->addTags($_POST['tags'], $last_id, $content['cont_langId'], 'content');
					
					// when everything is ok
					$error[] = $this->lang['content_added'];
					$this->setMessage($error, 'success');
					
					// redirect 
					if(isset($_POST['submit'])) $this->_call("/admincp/content/content/");
					
					$this->_call("/admincp/content/content/edit/$last_id");
				}
				else
					$this->setMessage($error, 'error');
				
			}
			
			$categories = $this->model->getData('#_categories', array('cat_langId' => 16), null, 'cat_id', 'DESC');
			$languages = $this->model->getData('#_lang', null, null, 'lang_id', 'DESC');
			
			
			$this->view->set('categories', $categories);
			$this->view->set('languages', $languages);
			$this->view->display();			
		}
		
		public function editAction() {
			$tagModel = $this->loadModel('Tag', 'admincp', 'Tag', true);
			$this->loadModel();
			$this->loadView('content/edit');
			
			$cont_id = (int)$this->getParam('edit');
			$old_content = $this->model->getRow('#_content', array('cont_id' => $cont_id));
			$old_content_datePublish = explode(" ", $old_content['cont_datePublish']);
			
			if(strtolower($_SERVER['REQUEST_METHOD']) == "post")
			{
				loader::loadClass('Filter');
				loader::loadClass('Image');
				$user = User::getInstance();
				$user->getId();
				
				$content = array(
					'cont_parentId' => (int)$_POST['cont_parentId'],
					'cont_langId' => (int)$_POST['cont_langId'],
					'cont_catId' => (int)$_POST['cont_catId'],
					'cont_userId' => $user->getId(),
					'cont_name' => $this->clear($_POST['cont_name']),
					'cont_seoUrl' => $this->clear($_POST['cont_seoUrl']),
					'cont_text' => addslashes($_POST['cont_text']),
					'cont_textCleared' => Filter::clearHtml($_POST['cont_text']),
					'cont_intro' => addslashes($_POST['cont_intro']),
					'cont_introCleared' => Filter::clearHtml($_POST['cont_intro']),
					'cont_metaDesc' => $this->clear($_POST['cont_metaDesc']),
					'cont_metaKeywords' => $this->clear($_POST['cont_metaKeywords']),
					'cont_metaData' => $this->clear($_POST['cont_metaData']),
					'cont_dateModified' => date('Y-m-d H:i:s'),
					'cont_titleTag' => $this->clear($_POST['cont_titleTag']),
					'cont_isactive' => (int)$_POST['cont_isactive'],
					'cont_datePublish' => $this->clear($_POST['cont_datePublishDate']) . " " . $this->clear($_POST['cont_datePublishTime']),
				);
				
				// checks
				if(empty($content['cont_name'])) $error[] = $this->lang['not_entered']. $this->lang['content_name'];
				// if seo url is empty we generate one
				if(empty($content['cont_seoUrl'])) $content['cont_seoUrl'] = $this->model->convertToSeoUrl($_POST['cat_name']);
				
				if($old_content['cont_seoUrl'] != $content['cont_seoUrl'])
				{
					// Check for a duplicate SEO Url
					if ($this->router->checkDuplicate($content['cont_seoUrl'])) $error[] = $this->lang['duplicate_seo_url'];
				}
				
				if(!$error)
				{
					// update db
					$this->model->db->update('#_content', $content, "cont_id = '$cont_id'");
					$last_id = $cont_id;
					$dir = "public/upload/content/$last_id/";
					
					if($_FILES['cont_pictures']['tmp_name'][0])
					{
						for($i = 0; $i<count($_FILES['cont_pictures']['name']); $i++)
						{
							// this uploads only images 
							if(Filter::checkFileExt($_FILES['cont_pictures']['type'][$i]))
							{
								$filename = $_FILES["cont_pictures"]["name"][$i];
								
								// we move the file to the original category dir
								move_uploaded_file($_FILES["cont_pictures"]["tmp_name"][$i], $dir . "original/". $filename);
								
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
								
								$image_size = getimagesize($dir . "original/" . $filename);
								//echo "<pre>";print_r($image_size);echo "</pre>";
								
								// add to db
								$image = array(
									'ci_contId' => $last_id,
									'ci_filename' => $filename,
									'ci_width' => $image_size[0],
									'ci_height' => $image_size[1],
									'ci_dateAdded' => date('Y-m-d H:i:s'),
									'ci_dateModified' => date('Y-m-d H:i:s')
								);
								
								$this->model->db->insert('#_content_images', $image);
							}
						}
						
					}
					
					// add tags
					if(!empty($_POST['tags']))
						$tagModel->addTags($_POST['tags'], $last_id, $content['cont_langId'], 'content');
					
					// update the SEO Url in the router table
					$seo_url_array = array(
						'route_seo_url' => $content['cont_seoUrl'],
						'route_url' => '/content/content/view/' . $last_id,
						'route_controller' => 'Content',
						'route_package' => 'Content',
					);
					$this->model->db->update('#_route', $seo_url_array, "item_id = $last_id");
					
					$error[] = $this->lang['content_edited'];
					$this->setMessage($error, 'success');
					
					// redirect 
					if(isset($_POST['submit'])) $this->_call("/admincp/content/content/");
				}
				else
					$this->setMessage($error, 'error');
				
			}
			
			$old_content = $this->model->getRow('#_content', array('cont_id' => $cont_id));
			$old_content_datePublish = explode(" ", $old_content['cont_datePublish']);
			
			$content_images = $this->model->getData('#_content_images', array('ci_contId' => $cont_id));
			
			$categories = $this->model->getData('#_categories', array( 'cat_langId' => $old_content['cont_langId']), null, 'cat_id', 'DESC');
			$languages = $this->model->getData('#_lang', null, null, 'lang_id', 'DESC');
			
			$tags = $tagModel->getTags($cont_id);
			
			$this->view->set('old_content_datePublish', $old_content_datePublish);
			$this->view->set('content_images', $content_images);
			$this->view->set('tags', $tags);
			$this->view->set('categories', $categories);
			$this->view->set('old_content', $old_content);
			$this->view->set('cont_id', $cont_id);
			$this->view->set('languages', $languages);
			$this->view->display();
			
		}
		
		public function generateSeoUrlAction() {
			$this->loadModel();
			echo $this->model->convertToSeoUrl($_POST['cont_name']);
			exit;
		}
		
		public function deleteAction() {
			$delete_id = (int)$this->getParam('delete');
			$this->loadModel();
			$cont_info = $this->model->getRow('#_content', array('cont_id' => $delete_id));
			
			
			// remove dir
			loader::loadClass('Dir');
			Dir::rmdir_r("public/upload/content/$delete_id/");
			
			// delete from db
			$this->model->db->delete('#_content', "cont_id = '$delete_id'");
			
			// delete from route db
			$this->model->db->delete('#_route', "route_seo_url = '".$cont_info['cont_seoUrl'] ."' ");
			
			// redirect to previus page
			$this->_call($_SERVER['HTTP_REFERER']);
			
		}
		
		public function editImgAction() {
			$img_id = (int)$this->getParam('editImg');
		
			$this->loadModel();
			$pic = $this->model->getRow('#_content_images', array('ci_id' => $img_id));
			//echo "<pre>";print_r($pic);echo "</pre>";
			
			if(strtolower($_SERVER['REQUEST_METHOD']) == 'post')
			{
				$image_update = array(
					'ci_alt' => $this->clear($_POST['ci_alt']),
					'ci_dateModified' => date('Y-m-d H:i:s'),
					'ci_isactive' => (int)$_POST['ci_isactive'],
				);
				
				$this->model->db->update('#_content_images', $image_update, "ci_id = '$img_id'");
			}
			
			$pic = $this->model->getRow('#_content_images', array('ci_id' => $img_id));
			
			$this->loadView('content/editImg');
			$this->view->set('pic', $pic);
			$this->view->display();
		}
		
		public function deleteImgAction() {
			$img_id = (int)$this->getParam('deleteImg');
			$this->loadModel();
			$img = $this->model->getRow('#_content_images', array('ci_id' => $img_id));
			
			// remove img from db
			$this->model->db->delete('#_content_images', "ci_id = '$img_id'");
			
			// remove from server
			$dir = "public/upload/content/$img_id/";
			unlink($dir."original/".$img['ci_filename']);
			unlink($dir."100/".$img['ci_filename']);
			unlink($dir."150/".$img['ci_filename']);
			unlink($dir."200/".$img['ci_filename']);
			unlink($dir."300/".$img['ci_filename']);
			unlink($dir."500/".$img['ci_filename']);
			unlink($dir."700/".$img['ci_filename']);
			unlink($dir."1000/".$img['ci_filename']);
			
			$this->_call($_SERVER['HTTP_REFERER']);
			
		}
		
		public function upAction() {
			$this->loadModel();
			$image_id = (int)$this->getParam('up');
			$image = $this->model->getRow('#_content_images', array('ci_id' => $image_id));
			$this->model->db->update('#_content_images', array('ci_position' => $image['ci_position'] + 1), "ci_id = '$image_id'");
			$this->_call($_SERVER['HTTP_REFERER']);
		}
		
		public function downAction() {
			$this->loadModel();
			$image_id = (int)$this->getParam('down');
			$image = $this->model->getRow('#_content_images', array('ci_id' => $image_id));
			$this->model->db->update('#_content_images', array('ci_position' => $image['ci_position'] - 1), "ci_id = '$image_id'");
			$this->_call($_SERVER['HTTP_REFERER']);
		}
		
		public function getCategoriesAction() {
			$this->loadModel();
			$categories = $this->model->getData('#_categories', array('cat_langId' => $_POST['lang_id']), null, 'cat_id', 'DESC');
			foreach($categories as $k => $v)
			{
				$new_cats[$k]['text'] = $categories[$k]['cat_name'];
				$new_cats[$k]['value'] = $categories[$k]['cat_id'];
			}
			
			
			echo json_encode($new_cats);
			exit;
		}
		
		
		public function selectedAction() {
			$this->loadModel();
			
			if($_POST['option'] == "activate")
			{
				foreach($_POST['selected'] as $contentid)
					$this->model->db->update('#_content', array('cont_isactive' => 1), "cont_id = $contentid");
			}
			else if ($_POST['option'] == "deactivate")
			{
				foreach($_POST['selected'] as $contentid)
					$this->model->db->update('#_content', array('cont_isactive' => 0), "cont_id = $contentid");
			}	
			else if ($_POST['option'] == "delete")
			{
				foreach($_POST['selected'] as $contentid)
				{
					$cont_info = $this->model->getRow('#_content', array('cont_id' => $contentid));
			
					// remove dir
					loader::loadClass('Dir');
					Dir::rmdir_r("public/upload/content/$contentid/");
					
					// delete from db
					$this->model->db->delete('#_content', "cont_id = '$contentid'");
					
					// delete from route db
					$this->model->db->delete('#_route', "route_seo_url = '".$cont_info['cont_seoUrl'] ."' ");
				
				}
			}
			
			$this->_call($_SERVER['HTTP_REFERER']);
			
		}
		
		public function featuredAction() {
			$this->loadModel();
			$content_id = (int)$this->getParam('featured');
			$check = $this->model->getCell('#_content', 'cont_featured', array('cont_id' => $content_id));
			
			if( $check == 0)
				$this->model->db->update('#_content', array('cont_featured' => 1), "cont_id = '$content_id' ");
			else
				$this->model->db->update('#_content', array('cont_featured' => 0), "cont_id = '$content_id' ");
			
			$this->_call($_SERVER['HTTP_REFERER']);
		}
		
		public function shareAction() {
			$this->loadModel();
			$content_id = (int)$this->getParam('share');
			$check = $this->model->getCell('#_content', 'cont_share', array('cont_id' => $content_id));
			
			if( $check == 0)
				$this->model->db->update('#_content', array('cont_share' => 1), "cont_id = '$content_id' ");
			else
				$this->model->db->update('#_content', array('cont_share' => 0), "cont_id = '$content_id' ");
			
			$this->_call($_SERVER['HTTP_REFERER']);
		}
		
		public function mainImgAction() {
			$this->loadModel();
			$image_id = (int)$this->getParam('mainImg');
			$image = $this->model->getRow('#_content_images', array('ci_id' => $image_id));
			
			// first we remove all main statues to this content then we set the selected pic to be main
			$this->model->db->update('#_content_images', array('ci_ismain' => 0), "ci_contId = '{$image['ci_contId']}' ");
			$this->model->db->update('#_content_images', array('ci_ismain' => 1), "ci_id = '$image_id' ");
			$this->_call($_SERVER['HTTP_REFERER']);
		}
		
		
	}