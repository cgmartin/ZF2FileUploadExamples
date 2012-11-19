<?php

namespace ZF2FileUploadExamples\Controller;

use ZF2FileUploadExamples\Form;
use ZF2FileUploadExamples\InputFilter;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class Examples extends AbstractActionController
{
    /**
     * @var Container
     */
    protected $sessionContainer;

    public function __construct()
    {
        $this->sessionContainer = new Container('file_upload_examples');
    }

    public function indexAction()
    {
        return array();
    }

    public function successAction()
    {
        return array(
            'formData' => $this->sessionContainer->formData,
        );
    }

    protected function redirectToSuccessPage($formData = null)
    {
        $this->sessionContainer->formData = $formData;
        $response = $this->redirect()->toRoute('fileupload/success');
        $response->setStatusCode(303);
        return $response;
    }

    /**
     * Example of a single file upload form.
     *
     * @return array|ViewModel
     */
    public function singleAction()
    {
        $form = new Form\SingleUpload('file-form');

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
                //Debug::dump($fileData); die();

                //
                // ...Save the form...
                //
                return $this->redirectToSuccessPage($form->getData());
            }
        }

        return array('form' => $form);
    }

    /**
     * Example of a single File element using the HTML5 "multiple" attribute.
     *
     * @return array|ViewModel
     */
    public function multiHtml5Action()
    {
        $form = new Form\MultiHtml5Upload('file-form');

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
                //Debug::dump($fileData); die();

                //
                // ...Save the form...
                //
                return $this->redirectToSuccessPage($form->getData());
            }
        }

        $view = new ViewModel(array(
           'legend' => 'Multiple File Upload with HTML5',
           'form'   => $form,
        ));
        $view->setTemplate('zf2-file-upload-examples/examples/single');
        return $view;
    }

    /**
     * Example of a single File element using the HTML5 "multiple" attribute.
     *
     * @return array|ViewModel
     */
    public function collectionAction()
    {
        $form = new Form\CollectionUpload('file-form');

        if ($this->getRequest()->isPost()) {
            // Postback
            $data = array_merge(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            $form->setData($data);
            if ($form->isValid()) {
                // Get raw file data array
                //for ($i=0; $i < $form->numFileElements; $i++) {
                //    $fileData = $form->get('file-collection')->get($i)->getValue();
                //    Debug::dump($fileData);
                //}
                //die();

                //
                // ...Save the form...
                //
                return $this->redirectToSuccessPage($form->getData());
            }
        }

        return array('form' => $form);
    }

    /**
     * Example of a single file upload when form is partially valid.
     *
     * @return array|ViewModel
     */
    public function partialAction()
    {
        $form = new Form\SingleUpload('file-form');
        $inputFilter = $form->getInputFilter();

        if ($this->getRequest()->isPost()) {
            // POST Request: Process form
            $data = array_merge(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );

            // Disable required file input if we already have an upload
            if (isset($this->sessionContainer->singleActionTempFile)) {
                $inputFilter->get('file')->setRequired(false);
            }

            $form->setData($data);
            if ($form->isValid()) {
                // If we did not get a new file upload this time around, use the temp file
                $data = $form->getData();
                if (empty($data['file'])) {
                    $data['file'] = $this->sessionContainer->singleActionTempFile['tmp_name'];
                }
                //
                // ...Save the form...
                //
                return $this->redirectToSuccessPage($data);
            } else {
                // Form was not valid, but the file input might be...
                // Save file to a temporary file if valid.
                $data = $form->getData();
                if (!empty($data['file'])) {
                    // NOTE: $data['file'] contains the filtered file path
                    $fileData = $form->get('file')->getValue(); // Get the raw file upload array value
                    $tempFilePath = './data/tmpuploads/partial-' . uniqid(true);
                    move_uploaded_file($data['file'], $tempFilePath);
                    $fileData['tmp_name'] = $tempFilePath;
                    $this->sessionContainer->singleActionTempFile = $fileData;
                }
            }
        } else {
            // GET Request: Clear any previous temp files
            unset($this->sessionContainer->singleActionTempFile);

            // NOTE: Instead of using the following code, I'd suggest having a
            // background process/cron clear out old/stale temporary file uploads,
            // such as using "tmpwatch" or "tmpreaper" linux commands.
            // Do not use this in a real site. It's a quick & dirty cleanup method for
            // the purposes of the example.
            array_map('unlink', glob('./data/tmpuploads/partial-*'));
        }

        $view = new ViewModel(array(
           'title'     => 'Partial Validation Examples',
           'form'      => $form,
           'tempFiles' => (isset($this->sessionContainer->singleActionTempFile))
               ? array($this->sessionContainer->singleActionTempFile)
               : null,
        ));
        $view->setTemplate('zf2-file-upload-examples/examples/single');
        return $view;
    }
}
