<?php

namespace ZF2FileUploadExamples\Controller;

use ZF2FileUploadExamples\Form;
use Zend\Debug\Debug;
use Zend\ProgressBar;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class ProgressExamples extends Examples
{
    /**
     * Example of AJAX File Upload with Session Progress.
     *
     * @return array|ViewModel
     */
    public function sessionAction()
    {
        $form = new Form\ProgressUpload('file-form');

        if ($this->getRequest()->isPost()) {
            // Postback
            $data = array_merge(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($data);
            if ($form->isValid()) {
                // Get raw file data array
                $fileData = $form->get('file')->getValue();
                Debug::dump($fileData);
                die();
            }
        }

        return array('form' => $form);
    }

    public function sessionProgressAction()
    {
        $id = $this->params()->fromQuery('id', null);
        $progress = new ProgressBar\Upload\SessionProgress();

        $view = new JsonModel(array(
            'id'     => $id,
            'status' => $progress->getProgress($id),
        ));
        return $view;
    }

}
