<?php

namespace ZF2FileUploadExamples\Controller;

use ZF2FileUploadExamples\Form;
use ZF2FileUploadExamples\InputFilter;
use Zend\Debug\Debug;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class BasicExamples extends AbstractActionController
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
        $form->setInputFilter(new InputFilter\FileUpload());

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
        $form->setInputFilter(new InputFilter\FileUpload());

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
        $view->setTemplate('zf2-file-upload-examples/basic-examples/single');
        return $view;
    }
}
