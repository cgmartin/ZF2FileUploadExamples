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
        } elseif ($prg instanceof \stdClass) {
            if ($prg->isValid) {

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
}
