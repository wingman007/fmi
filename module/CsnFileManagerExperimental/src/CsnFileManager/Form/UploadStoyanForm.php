<?php
// http://framework.zend.com/manual/2.1/en/modules/zend.form.file-upload.html
namespace CsnFileManager\Form;

use Zend\Form\Form;
use Zend\Form\Element;

class UploadForm extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('registration');
        $this->setAttribute('method', 'post');
/*
        $this->add(array(
            'name' => 'file',
            'attributes' => array(
                'type'  => 'Zend\Form\Element\File',
            ),
            'options' => array(
                'label' => 'Single file input',
            ),
        ));
*/		

		// Single file upload
		$file = new Element\File('file');
		$file->setLabel('Single file input');

		// HTML5 multiple file upload
		$multiFile = new Element\File('multi-file');
		$multiFile->setLabel('Multi file input')
				  ->setAttribute('multiple', true);

		// $form = new Form('my-file');
		$this->add($file)
			 ->add($multiFile);

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Upload',
                'id' => 'submitbutton',
            ),
        )); 
    }
}