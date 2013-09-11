<?php
// File: UploadForm.php // File Post-Redirect-Get Plugin
namespace CsnFileManager\Form;

use Zend\InputFilter;
use Zend\Form\Element;
use Zend\Form\Form;

class UploadMultiForm extends Form
{

	protected $_dir;

    public function __construct($dir, $name = null, $options = array())
    {
        parent::__construct($name, $options);
		$this->_dir = $dir;
        $this->addElements();
        $this->addInputFilter();
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('image-file');
        $file->setLabel('Avatar Image Upload')
             ->setAttribute('id', 'image-file')
             ->setAttribute('multiple', true);   // That's it
        $this->add($file);
		
        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Upload',
                'id' => 'submitbutton',
            ),
        ));
    }

	/**
	 * Adding a RenameUpload filter to our form’s file input, with details on where the valid files should be stored
	 */
    public function addInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();

        // File Input
        $fileInput = new InputFilter\FileInput('image-file');
        $fileInput->setRequired(true);

        // You only need to define validators and filters
        // as if only one file was being uploaded. All files
        // will be run through the same validators and filters
        // automatically.
        $fileInput->getValidatorChain()
            ->attachByName('filesize',      array('max' => 204800))
            ->attachByName('filemimetype',  array('mimeType' => 'image/png,image/x-png, image/jpeg'));
//            ->attachByName('fileimagesize', array('maxWidth' => 100, 'maxHeight' => 100));

        // All files will be renamed, i.e.:
        //   ./data/tmpuploads/avatar_4b3403665fea6.png,
        //   ./data/tmpuploads/avatar_5c45147660fb7.png
        $fileInput->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'    => $this->_dir, // './data/tmpuploads/avatar.png',
                'randomize' => true,
            )
        );
        $inputFilter->add($fileInput);

        $this->setInputFilter($inputFilter);
    }
}