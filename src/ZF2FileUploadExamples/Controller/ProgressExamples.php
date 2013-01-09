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
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($data);
            if ($form->isValid()) {
                //
                // ...Save the form...
                //
                Debug::dump($form->getData());
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
        $form        = new Form\SingleUpload('file-form');
        $inputFilter = $form->getInputFilter();
        $container   = new Container('partialExample');
        $tempFile    = $container->partialTempFile;

        if ($this->getRequest()->isPost()) {
            // POST Request: Process form
            $postData = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            // Disable required file input if we already have an upload
            if (isset($tempFile)) {
                $inputFilter->get('file')->setRequired(false);
            }

            $form->setData($postData);
            if ($form->isValid()) {
                // If we did not get a new file upload this time around, use the temp file
                $data = $form->getData();
                if (empty($data['file']) ||
                    (isset($data['file']['error']) && $data['file']['error'] !== UPLOAD_ERR_OK)
                ) {
                    $data['file'] = $tempFile;
                }

                //
                // ...Save the form...
                //

                if (!empty($postData['isAjax'])) {
                    // Send back success information via JSON
                    $this->sessionContainer->formData = $data;
                    return new JsonModel(array(
                        'status'   => true,
                        'redirect' => $this->url()->fromRoute('fileupload/success'),
                        'formData' => $data,
                    ));
                } else {
                    // Non-JS form submit, redirect to success page
                    return $this->redirectToSuccessPage($data);
                }
            } else {
                // Extend the session
                $container->setExpirationHops(1, 'partialTempFile');

                // Form was not valid, but the file input might be...
                // Save file to a temporary file if valid.
                $data = $form->getData();
                $fileErrors = $form->get('file')->getMessages();
                if (empty($fileErrors) && isset($data['file']['error'])
                    && $data['file']['error'] === UPLOAD_ERR_OK
                ) {
                    // NOTE: $data['file'] contains the filtered file path.
                    // 'FileRenameUpload' Filter has been run, and moved the file.
                    $container->partialTempFile = $tempFile = $data['file'];;
                }

                if (!empty($postData['isAjax'])) {
                    // Send back failure information via JSON
                    return new JsonModel(array(
                        'status'     => false,
                        'formErrors' => $form->getMessages(),
                        'formData'   => $data,
                        'tempFile'   => $tempFile,
                    ));
                }
            }
        } else {
            // GET Request: Clear previous temp file from session
            unset($container->partialTempFile);
            $tempFile = null;
        }


        return array(
            'title'     => 'Session Partial Progress Upload',
            'form'      => $form,
            'tempFiles' => (isset($tempFile)) ? array($tempFile) : null,
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
