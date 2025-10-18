<?php


return [

    'defaults' => [
        'title' => env('APP_NAME', 'Laravel'),
        'description' => 'Welcome to our website',
        'keywords' => 'laravel, seo, meta tags',
        'robots' => 'index,follow',
    ],

    'title_separator' => ' | ',

    'og_defaults' => [
        'site_name' => env('APP_NAME', 'Laravel'),
        'type' => 'website',
        'locale' => 'en_US',
    ],

    'twitter_defaults' => [
        'card' => 'summary_large_image',
        'site' => '@yourhandle',
    ],

];
