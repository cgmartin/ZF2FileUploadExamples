<?php

namespace ZF2FileUploadExamples\Form;

use Zend\InputFilter;
use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\Form\Element;

class FieldsetUpload extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
        $this->setInputFilter($this->createInputFilter());
    }

    public function addElements()
    {
        $fieldset = new Fieldset('fieldset');

        // File Input
        $file = new Element\File('file');
        $file
            ->setLabel('Multi-File Input 1')
            ->setAttributes(array('multiple' => true));
        $fieldset->add($file);

        // Text Input
        $text = new Element\Text('text');
        $text->setLabel('Text Entry');
        $fieldset->add($text);

        $this->add($fieldset);

        // File Input 2
        $file2 = new Element\File('file2');
        $file2
            ->setLabel('Multi-File Input 2')
            ->setAttributes(array('multiple' => true));
        $this->add($file2);
    }

    public function createInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();
        $fieldsetFilter = new InputFilter\InputFilter();

        // File Input
        $file = new InputFilter\FileInput('file');
        $file->setRequired(true);
        $file->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'          => './data/tmpuploads/',
                'overwrite'       => true,
                'use_upload_name' => true,
            )
        );
        //$file->getValidatorChain()->addByName(
        //    'fileextension', array('extension' => 'txt')
        //);
        $fieldsetFilter->add($file);

        // Text Input
        $text = new InputFilter\Input('text');
        $text->setRequired(true);
        $fieldsetFilter->add($text);

        $inputFilter->add($fieldsetFilter, 'fieldset');

        // File Input 2
        $file = new InputFilter\FileInput('file2');
        $file->setRequired(false); // Make this one optional
        $file->getFilterChain()->attachByName(
            'filerenameupload',
            array(
                'target'          => './data/tmpuploads/',
                'overwrite'       => true,
                'use_upload_name' => true,
            )
        );

        return $inputFilter;
    }
}