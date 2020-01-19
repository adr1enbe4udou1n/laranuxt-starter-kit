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

    'presets' => [
        'admin_preview' => [
            'w'   => 120,
            'h'   => 80,
            'fit' => 'crop',
        ],
        'extra_small' => [
            'w'   => 100,
            'h'   => 100,
            'fit' => 'crop',
        ],
        'small' => [
            'w'   => 400,
            'h'   => 400,
            'fit' => 'crop',
        ],
        'medium' => [
            'w'   => 800,
            'h'   => 800,
            'fit' => 'crop',
        ],
        'large' => [
            'w'   => 2000,
            'h'   => 1000,
            'fit' => 'crop',
        ],
    ],
];
