<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => env('IMAGE_DRIVER', 'gd'),

    'thumbnails' => [
        'admin_preview' => [
            'width'  => 120,
            'height' => 80,
        ],
        'extra_small' => [
            'width'  => 100,
            'height' => 100,
        ],
        'small' => [
            'width'  => 400,
            'height' => 400,
        ],
        'medium' => [
            'width'  => 800,
            'height' => 800,
        ],
        'large' => [
            'width'  => 2000,
            'height' => 1000,
        ],
    ],
];
