<?php

namespace CsnFileManager\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use CsnFileManager\Form\UploadForm;

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
		$this->init();
		if (!is_dir($this->_dir)) {
			mkdir($this->_dir, 0777);
		}			
		$form = new UploadForm($this->_dir, 'upload-form');
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

    public function deleteAction()
    {
		$this->init();
		$file = urldecode($this->params()->fromRoute('id'));
		$filename = $this->_dir . DIRECTORY_SEPARATOR . $file;
		unlink ($filename);
		return $this->redirect()->toRoute('csn-file-manager');		
		return new ViewModel(array());
	}
	
	public function viewAction()
	{
		$this->init();
		$file = urldecode($this->params()->fromRoute('id'));
		$filename = $this->_dir . DIRECTORY_SEPARATOR . $file;
		$contents = null;
		if (file_exists($filename)) {
			$handle = fopen($filename, "r"); // "r" - not r but b for Windows "b" - keeps giving me errors no file
			$contents = fread($handle, filesize($filename));
			fclose($handle);
		}
		return new ViewModel(array('contents' => $contents));
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