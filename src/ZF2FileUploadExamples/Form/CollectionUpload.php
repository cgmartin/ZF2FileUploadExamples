<?php

namespace ZF2FileUploadExamples\Form;

use Zend\InputFilter;
use Zend\Form\Form;
use Zend\Form\Element;

class CollectionUpload extends Form
{
    public $numFileElements = 2;

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $this->addElements();
        $this->setInputFilter($this->createInputFilter());
    }

    public function addElements()
    {
        // File Input
        $file = new Element\File('file');
        $file->setLabel('Multi File');

        $fileCollection = new Element\Collection('file-collection');
        $fileCollection->setOptions(array(
             'count'          => $this->numFileElements,
             'allow_add'      => false,
             'allow_remove'   => false,
             'target_element' => $file,
        ));
        $this->add($fileCollection);

        // Text Input
        $text = new Element\Text('text');
        $text->setLabel('Text Entry');
        $this->add($text);
    }

    public function createInputFilter()
    {
        $inputFilter = new InputFilter\InputFilter();

        // File Collection
        $fileCollection = new InputFilter\InputFilter();
        for ($i = 0; $i < $this->numFileElements; $i++) {
            $file = new InputFilter\FileInput($i);
            $file->setRequired(true);
            $file->getFilterChain()->attachByName(
                'filerenameupload',
                array(
                    'target'          => './data/tmpuploads/',
                    'overwrite'       => true,
                    'use_upload_name' => true,
                )
            );
            $fileCollection->add($file);
        }
        $inputFilter->add($fileCollection, 'file-collection');

        // Text Input
        $text = new InputFilter\Input('text');
        $text->setRequired(true);
        $inputFilter->add($text);

        return $inputFilter;
    }
}