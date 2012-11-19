<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'fileupload_basicexamples'   => 'ZF2FileUploadExamples\Controller\BasicExamples',
            'fileupload_partialexamples' => 'ZF2FileUploadExamples\Controller\PartialExamples',
            'fileupload_prgexamples'     => 'ZF2FileUploadExamples\Controller\PrgExamples',
        ),
    ),
    'router' => array(
        'routes' => array(
            'fileupload' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/file-upload-examples',
                    'defaults' => array(
                        'controller'    => 'fileupload_basicexamples',
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
                                'controller'    => 'fileupload_basicexamples',
                                'action'        => 'success',
                            ),
                        ),
                    ),
                    //
                    // SIMPLE EXAMPLES
                    //
                    'simple' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/simple',
                        ),
                        'child_routes' => array(
                            'single' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/single',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_basicexamples',
                                        'action'        => 'single',
                                    ),
                                ),
                            ),

                            'multi-html5' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/multi-html5',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_basicexamples',
                                        'action'        => 'multi-html5',
                                    ),
                                ),
                            ),

                            'collection' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/collection',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_basicexamples',
                                        'action'        => 'collection',
                                    ),
                                ),
                            ),
                        ),
                    ),
                    //
                    // PARTIAL VALIDATION EXAMPLES
                    //
                    'partial' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/partial',
                        ),
                        'child_routes' => array(
                            'single' => array(
                                'type'    => 'Literal',
                                'options' => array(
                                    'route'    => '/single',
                                    'defaults' => array(
                                        'controller'    => 'fileupload_partialexamples',
                                        'action'        => 'single',
                                    ),
                                ),
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
