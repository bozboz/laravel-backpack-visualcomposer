<?php

return [
    // model_crudfield value prefix in database
    'field_prefix' => 'visualcomposer_',

    // Installed and available templates to show in crud
    'templates' => [
        \Bozboz\LaravelBackpackVisualcomposer\Templates\ImageInBase64::class,
        \Bozboz\LaravelBackpackVisualcomposer\Templates\Article::class,
        \Bozboz\LaravelBackpackVisualcomposer\Templates\LeftTextRightQuote::class,
        \Bozboz\LaravelBackpackVisualcomposer\Templates\LeftImageRightText::class,
        \Bozboz\LaravelBackpackVisualcomposer\Templates\LeftTextRightImage::class,
        \Bozboz\LaravelBackpackVisualcomposer\Templates\ImageInContainer::class,
        \Bozboz\LaravelBackpackVisualcomposer\Templates\BackgroundImageAndText::class,
        \Bozboz\LaravelBackpackVisualcomposer\Templates\TwoColumnsImageTextCta::class,
        \Bozboz\LaravelBackpackVisualcomposer\Templates\ThreecolumnsImageTextCta::class,
        \Bozboz\LaravelBackpackVisualcomposer\Templates\Slideshow::class,
        \Bozboz\LaravelBackpackVisualcomposer\Templates\Minimal::class,
    ],

    // Available color codes used by some templates
    'colors' => [
        'snow' => '#fffafa',
        'honeydew' => '#f0fff0',
        'mint_cream' => '#f5fffa',
        'azure' => '#f0ffff',
        'alice_blue' => '#f0f8ff',
        'ghost_white' => '#f8f8ff',
        'white_smoke' => '#f5f5f5',
        'seashell' => '#fff5ee',
        'beige' => '#f5f5dc',
        'old_lace' => '#fdf5e6',
        'floral_white' => '#fffaf0',
        'ivory' => '#fffff0',
        'antique_white' => '#faebd7',
        'linen' => '#faf0e6',
        'lavender_blush' => '#fff0f5',
        'misty_rose' => '#ffe4e1',
    ],

    // Wysiwyg options for templates using ckeditor
    'ckeditor' => [
        'extra_plugins' => [],
        'toolbar' => [[
            'Bold',
            'Italic',
            'Link',
        ]],
    ],
];
