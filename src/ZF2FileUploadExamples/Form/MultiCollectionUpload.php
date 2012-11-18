<?php

namespace ZF2FileUploadExamples\Form;

use Zend\InputFilter;
use Zend\Form\Form;
use Zend\Form\Element;

class MultiCollectionUpload extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        // File Input
        $file = new Element\File('file');
        $file->setLabel('File Input');
        $this->add($file);

        // Text Input
        $text = new Element\Text('text');
        $text->setLabel('Text Entry');
        $this->add($text);
    }
}