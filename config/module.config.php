<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'fileupload_examples' => 'ZF2FileUploadExamples\Controller\Examples',
        ),
    ),
    'router' => array(
        'routes' => array(
            'fileupload' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/file-upload-examples',
                    'defaults' => array(
                        'controller'    => 'fileupload_examples',
                        'action'        => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(

                    'single' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/single',
                            'defaults' => array(
                                'controller'    => 'fileupload_examples',
                                'action'        => 'single',
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'fileupload' => __DIR__ . '/../view',
        ),
    ),
);
