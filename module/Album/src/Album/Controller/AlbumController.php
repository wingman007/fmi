<?php
namespace Album\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
<<<<<<< HEAD
use Album\Model\Album;          // <-- Add this import
use Album\Form\AlbumForm;       // <-- Add this import

class AlbumController extends AbstractActionController
{
    protected $albumTable;
    
    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }
    
    public function indexAction()
    {
        return new ViewModel(array(
            'albums' => $this->getAlbumTable()->fetchAll(),
        ));
    }

=======
use Album\Model\Album; // <-- Add this import
use Album\Form\AlbumForm; // <-- Add this import

class AlbumController extends AbstractActionController
{
  
    protected $albumTable;
  
    public function indexAction()
    {
      return new ViewModel(array(
            'albums' => $this->getAlbumTable()->fetchAll(),
      ));
    }

    // Add content to this method:
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
    public function addAction()
    {
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Album();
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $album->exchangeArray($form->getData());
                $this->getAlbumTable()->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }
        return array('form' => $form);
    }

<<<<<<< HEAD
=======
    // Add content to this method:
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album', array(
                'action' => 'add'
            ));
        }
        $album = $this->getAlbumTable()->getAlbum($id);

<<<<<<< HEAD
        $form  = new AlbumForm();
=======
        $form = new AlbumForm();
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());

            if ($form->isValid()) {
                $this->getAlbumTable()->saveAlbum($form->getData());

                // Redirect to list of albums
                return $this->redirect()->toRoute('album');
            }
        }

        return array(
            'id' => $id,
            'form' => $form,
        );
    }

<<<<<<< HEAD
=======
    // Add content to the following method:
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->getAlbumTable()->deleteAlbum($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return array(
<<<<<<< HEAD
            'id'    => $id,
            'album' => $this->getAlbumTable()->getAlbum($id)
        );
    }
=======
            'id' => $id,
            'album' => $this->getAlbumTable()->getAlbum($id)
        );
    }
  
// module/Album/src/Album/Controller/AlbumController.php:
    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }
>>>>>>> e6069389b80e7d3f1e0b75bd0fd59d987ac36951
}