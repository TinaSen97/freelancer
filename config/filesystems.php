<?php

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

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => config('filesystems.disks.s3.key'),
            'secret' => config('filesystems.disks.s3.secret'),
            'region' => config('filesystems.disks.s3.region'),
            'bucket' => config('filesystems.disks.s3.bucket'),
            //'url' => env('AWS_URL'),
        ],
		
		'dropbox' => [
			  'driver' => 'dropbox',
			  'token' => config('filesystems.disks.dropbox.token'),
		],
		
		'google' => [
        'driver' => 'google',
        'clientId' => config('filesystems.disks.google.clientId'),
        'clientSecret' => config('filesystems.disks.google.clientSecret'),
        'refreshToken' => config('filesystems.disks.google.refreshToken'),
        'folderId' => config('filesystems.disks.google.folderId'), // without folder is root of drive or team drive
        'teamDriveId' => env('GOOGLE_DRIVE_TEAM_DRIVE_ID'),
        ],	
		
		'b2' => [
            'driver'         => 'b2',
            'accountId'      => '0fe2f29a5fef',
            'applicationKey' => '00557b65a1163a62d5b86c2d98f043ed6015450295',
            'bucketName'     => 'Demogg',
            'bucketId'       => env('B2_BUCKET_ID', 'c07f2e224f42f9fa856f0e1f'),
        ],
		
		
    ],

];
