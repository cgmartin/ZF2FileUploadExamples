<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'fileupload_examples'         => 'ZF2FileUploadExamples\Controller\Examples',
            'fileupload_prgexamples'      => 'ZF2FileUploadExamples\Controller\PrgExamples',
            'fileupload_progressexamples' => 'ZF2FileUploadExamples\Controller\ProgressExamples',
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
                            'multi-html5' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/multi-html5',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_prgexamples',
                                        'action'        => 'multi-html5',
                                    ),
                                ),
                            ),
                            'fieldset' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/fieldset',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_prgexamples',
                                        'action'        => 'fieldset',
                                    ),
                                ),
                            ),
                        ),
                    ),

                    //
                    // PRG PLUGIN EXAMPLES
                    //
                    'progress' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/progress',
                        ),
                        'child_routes' => array(
                            'session' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/session',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_progressexamples',
                                        'action'        => 'session',
                                    ),
                                ),
                            ),
                            'session_partial' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/session-partial',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_progressexamples',
                                        'action'        => 'session-partial',
                                    ),
                                ),
                            ),
                            'session-progress' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/session-progress',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_progressexamples',
                                        'action'        => 'session-progress',
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
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);
