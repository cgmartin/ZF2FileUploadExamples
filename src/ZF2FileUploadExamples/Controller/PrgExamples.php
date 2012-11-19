<?php

namespace ZF2FileUploadExamples\Controller;

use ZF2FileUploadExamples\Form;
use ZF2FileUploadExamples\InputFilter;
use Zend\Debug\Debug;
use Zend\View\Model\ViewModel;

class PrgExamples extends BasicExamples
{
    /**
     * Example of a single file upload form w/ Post-Redirect-Get plugin.
     *
     * @return array|ViewModel
     */
    public function singleAction()
    {
        $form = new Form\SingleUpload('file-form');

        $prg = $this->fileprg($form, 'fileupload/prg/single');
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            // Form has run validators/filters
            // Do what needs to be done with the data (if valid)
            if ($form->isValid()) {
                // Get raw file data array
                $fileData = $form->get('file')->getValue();
                //Debug::dump($fileData); die();

                //
                // ...Save the form...
                //
                return $this->redirectToSuccessPage($form->getData());
            }

            // Return PRG redirect response
            return $prg;
        }

        $view = new ViewModel(array(
            'title' => 'Post/Redirect/Get Example',
            'form'  => $form,
        ));
        $view->setTemplate('zf2-file-upload-examples/basic-examples/single');
        return $view;
    }
}
