<?php

return [
    /* --------------------------------------------------------------------------------------------
     * Menu Configuration
     * --------------------------------------------------------------------------------------------
     */
    'menu_filters' => [
        CodeCoz\AimAdmin\MenuBuilder\Filters\HrefFilter::class,
        CodeCoz\AimAdmin\MenuBuilder\Filters\ActiveFilter::class,
        CodeCoz\AimAdmin\MenuBuilder\Filters\ClassesFilter::class,
    ],

    /* --------------------------------------------------------------------------------------------
     * File Upload Configuration
     * --------------------------------------------------------------------------------------------
     */
    'upload_file_type' => ['png', 'jpg', 'bmp', 'pdf', 'doc', 'xls', 'ppt'],
    'upload_file_size' => 5 * 1024,

    /* --------------------------------------------------------------------------------------------
     * Auth Configuration
     * --------------------------------------------------------------------------------------------
     */
    'auth' => [
        'controller' => \CodeCoz\AimAdmin\Http\Controllers\Auth\AuthController::class,
        'user_model' => \App\Models\User::class,
        'url' => 'login',
        'logout_url' => 'logout',
        'middleware' => ['guest', 'web'],
    ],
    'footer_text' => 'Anything you want',
    'registration' => [
        'controller' => \CodeCoz\AimAdmin\Http\Controllers\Auth\RegistrationController::class,
        'fields' => [
            'number' => 'id',
            'text' => 'full_name'
        ]
    ],
    'back_to_top' => true,
    'layout_class' => [
        'body' => '',
        'brand' => '',
        'sidebar' => '',
        'navbar' => '',
        'footer' => '',
    ]
];
