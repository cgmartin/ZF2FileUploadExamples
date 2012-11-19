<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'fileupload_examples'    => 'ZF2FileUploadExamples\Controller\Examples',
            'fileupload_prgexamples' => 'ZF2FileUploadExamples\Controller\PrgExamples',
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
                    'success' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/success',
                            'defaults' => array(
                                'controller'    => 'fileupload_examples',
                                'action'        => 'success',
                            ),
                        ),
                    ),

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

                    'multi-html5' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/multi-html5',
                            'defaults' => array(
                                'controller'    => 'fileupload_examples',
                                'action'        => 'multi-html5',
                            ),
                        ),
                    ),

                    'collection' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/collection',
                            'defaults' => array(
                                'controller'    => 'fileupload_examples',
                                'action'        => 'collection',
                            ),
                        ),
                    ),

                    'partial' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/partial',
                            'defaults' => array(
                                'controller'    => 'fileupload_examples',
                                'action'        => 'partial',
                            ),
                        ),
                    ),

                    //
                    // PRG PLUGIN EXAMPLES
                    //
                    'prg' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/prg',
                        ),
                        'child_routes' => array(
                            'single' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/single',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_prgexamples',
                                        'action'        => 'single',
                                    ),
                                ),
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
