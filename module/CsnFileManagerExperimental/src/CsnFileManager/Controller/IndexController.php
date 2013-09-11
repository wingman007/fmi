<?php

namespace CsnFileManager\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use CsnFileManager\Form\FileForm;
use CsnFileManager\Form\FileFilter;

use CsnFileManager\Form\UploadSingleForm;
use CsnFileManager\Form\UploadSimpleForm;
use CsnFileManager\Form\UploadMultiForm;

class IndexController extends AbstractActionController
{
	protected $_dir = null;
	
	public function init()
	{
		$config = $this->getServiceLocator()->get('Config');
		$fileManagerDir = $config['file_manager']['dir'];
		if ($user = $this->identity()) {
			
		} else {
			return $this->redirect()->toRoute('home');		
		}

		$this->_dir = realpath($fileManagerDir) .
			DIRECTORY_SEPARATOR .
			$user->getUsrId();
	}
	
    public function indexAction()
	{
		$this->init();
		$files = array();
    	if (is_dir($this->_dir)) {
			$handle = opendir($this->_dir);
	    	if ($handle) {	
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != "..") {
						$files[] = $entry;
					}
				}
				closedir($handle);
	    	}		
		}
		return new ViewModel(array('files' => $files));
	}
	
    public function uploadAction()
    {
		return $this->redirect()->toRoute('csn-file-manager/default', array('controller' => 'index', 'action' => 'upload-multi'));
		$this->init();
		
		if (!is_dir($this->_dir)) {
			mkdir($this->_dir, 0777);
		}
	
//		$form = new FileForm();
//		$filter = new FileFilter($this->_dir);
		
//		$element = $form->get('file');
//		$specs = $element->getInputSpecification();
//		$filter = $form->getInputFilter();
//		echo '<h1>Filter:</h1><pre>';
//		print_r($filter);
//		echo '</pre>';

		$form = new UploadSingleForm();

/*
		$request = $this->getRequest();
        if ($request->isPost()) {
			$form->setInputFilter(new RegistrationFilter($this->getServiceLocator()));
			$form->setData($request->getPost());
			 if ($form->isValid()) {
				$this->prepareData($user);
				$this->sendConfirmationEmail($user);
				$this->flashMessenger()->addMessage($user->getUsrEmail());
				$entityManager->persist($user);
				$entityManager->flush();				
				return $this->redirect()->toRoute('auth-doctrine/default', array('controller'=>'registration', 'action'=>'registration-success'));					
			}			 
		}		
*/		
		
		return new ViewModel(array('form' => $form));
	}
	
	/**
	 * The action that uses a simple form (no filter) without moving the file to a new directory. The simplest variant.
	 *
	 * The values we are receiving. The file doesn'g get moved, but it is renamed to a random name.
	 *	Array
	 *	(
	 *		[image-file] => Array
	 *			(
	 *				[name] => text2.txt
	 *				[type] => text/plain
	 *				[tmp_name] => C:\WINDOWS\Temp\php1452.tmp
	 *				[error] => 0
	 *				[size] => 1380
	 *			)
	 *		[submit] => Upload
	 *	)
	 * @link http://framework.zend.com/manual/2.1/en/modules/zend.form.file-upload.html
	 * @return Zend\View\Model\ViewModel|array returns the standard things
	 */
    public function uploadSimpleAction()
    {
		$this->init();
		if (!is_dir($this->_dir)) {
			mkdir($this->_dir, 0777);
		}		
		$form = new UploadSimpleForm();

	   $request = $this->getRequest();
		if ($request->isPost()) {
			// Make certain to merge the files info!
			$post = array_merge_recursive(
				$request->getPost()->toArray(),
				$request->getFiles()->toArray()
			);

			$form->setData($post);
			if ($form->isValid()) {
				$data = $form->getData();
				// Form is valid, save the form!
				echo '<br /><br /><br /><br /><br /><br /><pre>';
				print_r($data);
				echo '</pre>';
//				return $this->redirect()->toRoute('csn-file-manager');
			}
		}		
		return new ViewModel(array('form' => $form));		
	}

	/**
	 * The action that uses a form for uploading a single file and File Post-Redirect-Get Plugin
	 *
	 * When using other standard form inputs (i.e. text, checkbox, select, etc.) 
	 * along with file inputs in a Form, you can encounter a situation where some 
	 * inputs may become invalid and the user must re-select the file and re-upload. 
	 * PHP will delete uploaded files from the temporary directory at the end of the 
	 * request if it has not been moved away or renamed. Re-uploading a valid file each 
	 * time another form input is invalid is inefficient and annoying to users.
	 *
	 * One strategy to get around this is to split the form into multiple forms. 
	 * One form for the file upload inputs and another for the other standard inputs.
	 *
	 * When you cannot separate the forms, the File Post-Redirect-Get Controller Plugin 
	 * can be used to manage the file inputs and save off valid uploads until the entire form is valid.
	 * 
	 * @return Zend\View\Model\ViewModel|array returns the standard things
	 */
    public function uploadSingleAction()
    {
		$this->init();
		if (!is_dir($this->_dir)) {
			mkdir($this->_dir, 0777);
		}	
		$form     = new UploadSingleForm($this->_dir, 'upload-form');
		$tempFile = null;

		$prg = $this->fileprg($form);
		if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
			return $prg; // Return PRG redirect response
		} elseif (is_array($prg)) {
			if ($form->isValid()) {
				$data = $form->getData();
				// Form is valid, save the form!
				echo '<br /><br /><br /><br /><br /><br /><pre>';
				print_r($data);
				echo '</pre>';
				//- return $this->redirect()->toRoute('upload-form/success');
			} else {
				// Form not valid, but file uploads might be valid...
				// Get the temporary file information to show the user in the view
				$fileErrors = $form->get('image-file')->getMessages();
				if (empty($fileErrors)) {
					$tempFile = $form->get('image-file')->getValue();
				}
			}
		}

		return array(
			'form'     => $form,
			'tempFile' => $tempFile,
		);		
	}

	/**
	 * HTML5 Multi-File Uploads
	 *
	 * I will rename the files to the original names
	 * This is how the data looks after the upload
	 *	Array
	 *	(
	 *		[image-file] => Array
	 *			(
	 *				[0] => Array
	 *					(
	 *						[name] => text.txt
	 *						[type] => text/plain
	 *						[tmp_name] => C:\Documents and Settings\user\fmi\data\uploads\54\php1553_522f35c51564f.tmp
	 *						[error] => 0
	 *						[size] => 7108
	 *					)
	 *
	 *				[1] => Array
	 *					(
	 *						[name] => b.txt.zip
	 *						[type] => application/octet-stream
	 *						[tmp_name] => C:\Documents and Settings\user\fmi\data\uploads\54\php1554_522f35c515844.tmp
	 *						[error] => 0
	 *						[size] => 3066
	 *					)
	 *			)
	 *
	 *		[submit] => Upload
	 *	)
	 * @link http://framework.zend.com/manual/2.1/en/modules/zend.form.file-upload.html
	 * @return Zend\View\Model\ViewModel|array returns the standard things
	 */
    public function uploadMultiAction()
    {
		$this->init();
		if (!is_dir($this->_dir)) {
			mkdir($this->_dir, 0777);
		}		
		$form = new UploadMultiForm($this->_dir, 'upload-form');

	   $request = $this->getRequest();
		if ($request->isPost()) {
			// Make certain to merge the files info!
			$post = array_merge_recursive(
				$request->getPost()->toArray(),
				$request->getFiles()->toArray()
			);

			$form->setData($post);
			if ($form->isValid()) {
				$data = $form->getData();
				// Form is valid, save the form!
				$this->setFileNames($data);
				// The data can be saved in the DataBase				
				return $this->redirect()->toRoute('csn-file-manager');
			}
		}		
		return new ViewModel(array('form' => $form));		
	}
	
	public function viewAction()
	{
		$this->init();
		$file = urldecode($this->params()->fromRoute('id'));

		$filename = $this->_dir . DIRECTORY_SEPARATOR . $file;
		$contents = null;
//		echo '<br /><br /><br /><br /><br /><br /><br /><br /><h1>filename: ' . $filename . '</h1>';
//		echo '<h1>dir = ' . $this->_dir . '</h1>';
		
		if (file_exists($filename)) {
/*
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($this->_dir . DIRECTORY_SEPARATOR . $file)); // $file));
			ob_clean();
			flush();
			// readfile($file);

			readfile($this->_dir . DIRECTORY_SEPARATOR . $file);
			exit;
*/
			// get contents of a file into a string
			// $filename = "/usr/local/something.txt";
			$handle = fopen($filename, "r"); // "r" - not r but b for Windows "b" - keeps giving me errors no file
// 			$handle = fopen('C:\1_phpdocumentor.png', "b");
//			$handle = fopen('C:\WINDOWS\Temp\1_phpdocumentor.png', "r");
			$contents = fread($handle, filesize($filename));
			fclose($handle);
		}		
		return new ViewModel(array('contents' => $contents));
	}
	
    public function downloadAction()
    {
		$this->init();
		$file = urldecode($this->params()->fromRoute('id'));
		$filename = $this->_dir . DIRECTORY_SEPARATOR . $file;
		
		if (file_exists($filename)) {
			header('Content-Description: File Transfer');
			header('Content-Type: application/octet-stream');
			header('Content-Disposition: attachment; filename='.basename($file));
			header('Content-Transfer-Encoding: binary');
			header('Expires: 0');
			header('Cache-Control: must-revalidate');
			header('Pragma: public');
			header('Content-Length: ' . filesize($filename)); // $file));
			ob_clean();
			flush();
			// readfile($file);
			readfile($filename);
			exit;
		}		
		
		return new ViewModel(array());
	}
	
	public function getImageAction()
	{
		$this->init();
		$file = urldecode($this->params()->fromRoute('id'));
		$filename = $this->_dir . DIRECTORY_SEPARATOR . $file;

		if (file_exists($filename)) {
			header('Content-Type: image/jpeg');
			ob_clean();
			flush();
			readfile($filename);
			exit;		
		}
		return new ViewModel(array());
	}

	
    public function deleteAction()
    {
		$this->init();
		$file = urldecode($this->params()->fromRoute('id'));
		$filename = $this->_dir . DIRECTORY_SEPARATOR . $file;
		unlink ($filename);	
		return $this->redirect()->toRoute('csn-file-manager');		
		return new ViewModel(array());		
	}
	
	/**
	 * Change the names of the uploaded files to their original names. Since we don't keep anything in the DB
	 *
	 * @param array $data array of arrays
	 * @return void
	 */	
	protected function setFileNames($data)
	{
		unset($data['submit']);
		foreach ($data['image-file'] as $key => $file) {
			rename($file['tmp_name'], $this->_dir . DIRECTORY_SEPARATOR . $file['name']);
		}		
	}
}