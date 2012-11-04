<?php

namespace ZF2FileUploadExamples\Form;

use Zend\InputFilter;
use Zend\Form\Form;
use Zend\Form\Element;

class SingleUpload extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);
        $inputFilter = new InputFilter\InputFilter();

        // File Input
        $file = new Element\File('file');
        $file->setLabel('File Input');
        $this->add($file);

        $fileInput = new InputFilter\Input('file');
        $fileInput->setRequired(true);
        $inputFilter->add($fileInput);

        // Text Input
        $text = new Element\Text('text');
        $text->setLabel('Text Entry');
        $this->add($text);

        $textInput = new InputFilter\Input('text');
        $textInput->setRequired(true);
        $inputFilter->add($textInput);


        $this->setInputFilter($inputFilter);
    }
}