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
            } else {
                Debug::dump($form->getMessages());
            }
        }

        return array('form' => $form);
    }

    /**
     * Example of AJAX File Upload with Session Progress and partial validation.
     *
     * @return array|ViewModel
     */
    public function sessionPartialAction()
    {
        $form = new Form\SingleUpload('file-form');
        $inputFilter = $form->getInputFilter();
        $container   = new Container('partialExample');
        $tempFile    = $container->partialTempFile;


        if ($this->getRequest()->isPost()) {
            // Postback
            $data = array_merge(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            // whenever you post input element via ajax they might end up a an empty string, we fix that
            if (isset($data['file']) && $data['file'] === '') {
                $data['file'] = array('name' =>  '', 'type' => '', 'tmp_name' => '', 'error' =>  UPLOAD_ERR_NO_FILE, 'size' => 0);
            }
            // Disable required file input if we already have an upload
            if (isset($tempFile)) {
                $inputFilter->get('file')->setRequired(false);
            }

            $form->setData($data);
            if ($form->isValid()) {
                // If we did not get a new file upload this time around, use the temp file
                $data = $form->getData();
                if (empty($data['file'])) {
                    $data['file'] = $tempFile['tmp_name'];
                }

                // Get raw file data array
                $fileData = $form->get('file')->getValue();

                if (empty($data['file'])) {
                    $data['file'] = $tempFile['tmp_name'];
                }

                $result = Debug::dump($data, 'success', false);
            } else {
                // Extend the session
                $container->setExpirationHops(1, 'partialTempFile');

                // Form was not valid, but the file input might be...
                // Save file to a temporary file if valid.
                $result = Debug::dump($data, 'submitted (fixed)', false);
                $data = $form->getData();
                $result .= Debug::dump($data, 'form::getData', false);
                if (!empty($data['file'])) {
                    // NOTE: $data['file'] contains the filtered file path
                    $tempFile = $form->get('file')->getValue(); // Get the raw file upload array value
                    $tempFilePath = './data/tmpuploads/partial' . uniqid('_');
                    move_uploaded_file($data['file'], $tempFilePath);
                    $tempFile['tmp_name'] = $tempFilePath;
                    $container->partialTempFile = $tempFile;
                }

            }
        } else {
            // GET Request: Clear previous temp file from session
            unset($container->partialTempFile);
            $tempFile = null;
            $result = '';
        }

        return array(
            'title' => 'Session Partial Progress Upload',
            'form' => $form,
            'tempFiles' => (isset($tempFile)) ? array($tempFile) : null,
            'result' => $result
        );
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
