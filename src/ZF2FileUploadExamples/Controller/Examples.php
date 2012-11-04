<?php

namespace ZF2FileUploadExamples\Controller;

use ZF2FileUploadExamples\Form;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Debug\Debug;
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
                return $this->redirectToSuccessPage($form->getData());
            }
        }

        return array(
            'form' => $form,
        );
    }

    /**
     * Example of a single file upload form w/ Post-Redirect-Get plugin.
     *
     * @return array|ViewModel
     */
    public function singlePrgAction()
    {
        $form = new Form\SingleUpload('file-form');
        $prg = $this->fileprg($form, 'fileupload/single-prg');
        if (false !== $prg && isset($prg->response)) {
            // Form has run validators/filters
            // Do what needs to be done with the data (if valid)
            if ($prg->isValid) {
                return $this->redirectToSuccessPage($form->getData());
            } else {
                // Return PRG redirect response
                return $prg->response;
            }
        }

        $view = new ViewModel(array(
            'form' => $form,
        ));
        $view->setTemplate('zf2-file-upload-examples/examples/single');
        return $view;
    }
}
