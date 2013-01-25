<?php

namespace ZF2FileUploadExamples\Controller;

use ZF2FileUploadExamples\Form;
use ZF2FileUploadExamples\InputFilter;
use Zend\Debug\Debug;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;

class PrgExamples extends Examples
{
    /**
     * Example of a single File element using the HTML5 "multiple" attribute
     * w/ the Post-Redirect-Get plugin.
     *
     * @return array|ViewModel
     */
    public function multiHtml5Action()
    {
        $tempFiles = null;

        $form = new Form\MultiHtml5Upload('file-form');
        $prg = $this->fileprg($form);
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg; // Return PRG redirect response
        } elseif (is_array($prg)) {
            if ($form->isValid()) {

                //
                // ...Save the form...
                //

                return $this->redirectToSuccessPage($form->getData());
            } else {
                // Form not valid, but file uploads might be valid
                $fileErrors = $form->get('file')->getMessages();
                if (empty($fileErrors)) {
                    $tempFiles = $form->get('file')->getValue();
                }
            }
        }

        $view = new ViewModel(array(
            'title'     => 'Post/Redirect/Get Plugin Example',
            'legend'    => 'Multiple File Upload with HTML5',
            'form'      => $form,
            'tempFiles' => $tempFiles,
        ));
        $view->setTemplate('zf2-file-upload-examples/examples/single');
        return $view;
    }

    /**
     * Example of a single File element within a nested Fieldset
     * w/ the Post-Redirect-Get plugin.
     *
     * @return array|ViewModel
     */
    public function fieldsetAction()
    {
        $tempFiles = array();

        $form = new Form\FieldsetUpload('file-form');
        $prg = $this->fileprg($form);
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            return $prg; // Return PRG redirect response
        } elseif (is_array($prg)) {
            if ($form->isValid()) {

                //
                // ...Save the form...
                //

                return $this->redirectToSuccessPage($form->getData());
            } else {
                // Form not valid, but file uploads might be valid
                $file1Errors = $form->get('fieldset')->get('file')->getMessages();
                if (empty($file1Errors)) {
                    $tempFiles['file'] = $form->get('fieldset')->get('file')->getValue();
                }
                $file2Errors = $form->get('file2')->getMessages();
                if (empty($file2Errors)) {
                    $tempFiles['file2'] = $form->get('file2')->getValue();
                }
            }
        }

        $view = new ViewModel(array(
            'title'     => 'Post/Redirect/Get Plugin Example',
            'legend'    => 'Nested Fieldset Elements',
            'form'      => $form,
            'tempFiles' => $tempFiles,
        ));
        $view->setTemplate('zf2-file-upload-examples/examples/fieldset');
        return $view;
    }
}
