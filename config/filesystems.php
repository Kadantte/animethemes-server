<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        'images' => [
            'driver' => 's3',
            'key' => env('IMAGE_ACCESS_KEY_ID'),
            'secret' => env('IMAGE_SECRET_ACCESS_KEY'),
            'region' => env('IMAGE_DEFAULT_REGION'),
            'bucket' => env('IMAGE_BUCKET'),
            'endpoint' => env('IMAGE_ENDPOINT'),
            'stream_reads' => env('IMAGE_STREAM_READS'),
            'disable_asserts' => env('IMAGE_DISABLE_ASSERTS'),
            'visibility' => env('IMAGE_VISIBILITY'),
            'url' => env('IMAGE_URL'),
            'throw' => false,
        ],

        'videos' => [
            'driver' => 's3',
            'key' => env('VIDEO_ACCESS_KEY_ID'),
            'secret' => env('VIDEO_SECRET_ACCESS_KEY'),
            'region' => env('VIDEO_DEFAULT_REGION'),
            'bucket' => env('VIDEO_BUCKET'),
            'endpoint' => env('VIDEO_ENDPOINT'),
            'stream_reads' => env('VIDEO_STREAM_READS'),
            'disable_asserts' => env('VIDEO_DISABLE_ASSERTS'),
            'visibility' => env('VIDEO_VISIBILITY'),
            'throw' => false,
        ],

        'db-dumps' => [
            'driver' => 'local',
            'root' => storage_path('db-dumps'),
            'throw' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
