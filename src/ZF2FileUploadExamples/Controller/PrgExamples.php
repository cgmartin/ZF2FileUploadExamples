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
        $form = new Form\SingleUpload('file-form');
        $inputFilter = $form->getInputFilter();

        // Disable required file input if we already have an upload
        if ($this->getRequest()->isPost()
            && isset($this->sessionContainer->partialTempFile)
        ) {
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
                    $data['file'] = $this->sessionContainer->partialTempFile['tmp_name'];
                }

                //
                // ...Save the form...
                //

                // Clear temp file from session
                unset($this->sessionContainer->partialTempFile);

                // vvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvvv
                // TODO: The following code is a work-around for bug #2505
                // https://github.com/zendframework/zf2/issues/2505
                // ...and should be removed when fixed.
                $prgContainer = new Container('file_prg_post1');
                unset($prgContainer->post); unset($prgContainer->errors);
                // TODO: There still seems to be a Session bug even with this workaround.
                // ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

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
                    $this->sessionContainer->partialTempFile = $fileData;
                }
            }
            // Return PRG redirect response
            return $prg;
        } elseif (false === $prg) {
            // GET Request: Clear previous temp file from session
            unset($this->sessionContainer->partialTempFile);
        }

        $view = new ViewModel(array(
            'title'     => 'Post/Redirect/Get Example',
            'form'      => $form,
            'tempFiles' => (isset($this->sessionContainer->partialTempFile))
                           ? array($this->sessionContainer->partialTempFile)
                           : null,
        ));
        $view->setTemplate('zf2-file-upload-examples/examples/single');
        return $view;
    }
}
