<?php

namespace ZF2FileUploadExamples\Controller;

use ZF2FileUploadExamples\Form;
use ZF2FileUploadExamples\InputFilter;
use Zend\Debug\Debug;
use Zend\View\Model\ViewModel;

class PartialExamples extends BasicExamples
{
    /**
     * Example of a single file upload when form is partially valid.
     *
     * @return array|ViewModel
     */
    public function singleAction()
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
                    $tempFilePath = './data/tmpuploads/partial-single-' . uniqid(true);
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
            array_map('unlink', glob('./data/tmpuploads/partial-single-*'));
        }

        $view = new ViewModel(array(
           'title'     => 'Partial Validation Examples',
           'form'      => $form,
           'tempFiles' => (isset($this->sessionContainer->singleActionTempFile))
                          ? array($this->sessionContainer->singleActionTempFile)
                          : null,
        ));
        $view->setTemplate('zf2-file-upload-examples/basic-examples/single');
        return $view;
    }
}
