<?php

namespace ZF2FileUploadExamples\InputFilter;

use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Input;

class FileUpload extends InputFilter
{
    public function __construct()
    {
        // File Input
        $file = new Input('file');
        $file->setRequired(true);
        $this->add($file);

        // Text Input
        $text = new Input('text');
        $text->setRequired(true);
        $this->add($text);
    }
}