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
     * Example of a single file upload form w/ Post-Redirect-Get plugin.
     *
     * @return array|ViewModel
     */
    public function singleAction()
    {
        $form        = new Form\SingleUpload('file-form');
        $inputFilter = $form->getInputFilter();
        $container   = new Container('prgExample');
        $tempFile    = $container->partialTempFile;

        // Disable required file input if we already have an upload
        if ($this->getRequest()->isPost() && isset($tempFile)) {
            $inputFilter->get('file')->setRequired(false);
        }

        $prg = $this->fileprg($form, 'fileupload/prg/single');
        if ($prg instanceof \Zend\Http\PhpEnvironment\Response) {
            // Form has run validators/filters
            // Do what needs to be done with the data (if valid)
            if ($form->isValid()) {
                // If we did not get a new file upload this time around, use the temp file
                $data = $form->getData();
                if (empty($data['file'])) {
                    $data['file'] = $tempFile['tmp_name'];
                }

                //
                // ...Save the form...
                //

                // Clear session data
                unset($container->partialTempFile);
                unset($this->plugin('fileprg')->getSessionContainer()->post);

                return $this->redirectToSuccessPage($data);
            } else {
                // Extend the session
                $container->setExpirationHops(2, 'partialTempFile');

                // Form was not valid, but the file input might be...
                // Save file to a temporary file if valid.
                $data = $form->getData();
                if (!empty($data['file'])) {
                    // NOTE: $data['file'] contains the filtered file path
                    $tempFile = $form->get('file')->getValue(); // Get the raw file upload array value
                    $tempFilePath = './data/tmpuploads/partial' . uniqid('-',true);
                    move_uploaded_file($data['file'], $tempFilePath);
                    $tempFile['tmp_name'] = $tempFilePath;
                    $container->partialTempFile = $tempFile;
                }
            }
            // Return PRG redirect response
            return $prg;
        }

        $view = new ViewModel(array(
            'title'     => 'Post/Redirect/Get Example',
            'form'      => $form,
            'tempFiles' => (isset($tempFile)) ? array($tempFile) : null,
        ));
        $view->setTemplate('zf2-file-upload-examples/examples/single');
        return $view;
    }
}
