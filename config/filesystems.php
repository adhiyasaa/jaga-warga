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

        // Konfigurasi S3 default (biarkan saja)
        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => false,
            'throw' => false,
        ],

        // --- INI DISK SUPABASE KITA YANG DIPERBAIKI ---
        'supabase' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'), 
            'endpoint' => env('AWS_ENDPOINT'),
            'region' => env('AWS_DEFAULT_REGION'), // BIARKAN INI (untuk menghindari error 'region missing')
            
            // --- INI PERBAIKANNYA ---
            'use_path_style_endpoint' => true, // UBAH MENJADI 'true'
            // --- AKHIR PERBAIKAN ---
            
            'visibility' => 'public',
        ],
        // --- AKHIR BLOK SUPABASE ---

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    */

    'links' => [
        // public_path('storage') => storage_path('app/public'),
    ],

];
