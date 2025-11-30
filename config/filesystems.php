<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => public_path('storage'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => true,
        ],

        // DISK KHUSUS POSTINGAN (Bucket: posts)
        'supabase_posts' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET_POSTS'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => true, 
            'visibility' => 'public',
            'throw' => true,
        ],


        // DISK UTAMA SUPABASE (Bucket: reports)
        'supabase' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'region' => env('AWS_DEFAULT_REGION'),
            'use_path_style_endpoint' => true,
            'visibility' => 'public',
            'throw' => true,
            'http' => [
                'verify' => false,
            ],
        ],

        'supabase_info' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'bucket' => 'information',
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'region' => env('AWS_DEFAULT_REGION'),
            'url' => str_replace('/reports', '/information', env('AWS_URL')),
            'use_path_style_endpoint' => true,
            'visibility' => 'public',
            'throw' => true,            
            'http' => [
                'verify' => false,
            ],
        ],

        'supabase_profile' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => 'profile',
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => true,
            'visibility' => 'public',
            'throw' => true,
            'url' => str_replace('/reports', '/profile', env('AWS_URL')), 
            'http' => [
                'verify' => false,
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
