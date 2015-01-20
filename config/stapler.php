<?php

return [
    'stapler' => [

        /*
        |--------------------------------------------------------------------------
        | Stapler Public Path Location
        |--------------------------------------------------------------------------
        |
        | The location of the web application's document root.
        |
        */

        'public_path'              => '',

        /*
        |--------------------------------------------------------------------------
        | Stapler Base Path Location
        |--------------------------------------------------------------------------
        |
        | The path to the base of the web application.
        |
        */

        'base_path'                => '',

        /*
        |--------------------------------------------------------------------------
        | Stapler Storage Driver
        |--------------------------------------------------------------------------
        |
        | The default mechanism for handling file storage.  Currently Stapler supports
        | both file system and Amazon S3 as options.
        |
        */

        'storage'                  => 'filesystem',

        /*
        |--------------------------------------------------------------------------
        | Stapler Image Processing Library
        |--------------------------------------------------------------------------
        |
        | The default library used for image processing.  Can be one of the following:
        | Imagine\Gd\Imagine, Imagine\Imagick\Imagine, or Imagine\Gmagick\Imagine.
        |
        */

        'image_processing_library' => 'Imagine\Gd\Imagine',


        /*
        |--------------------------------------------------------------------------
        | Stapler Default Url
        |--------------------------------------------------------------------------
        |
        | The url (relative to your project document root) containing a default image
        | that will be used for attachments that don't currently have an uploaded image
        | attached to them.
        |
        */

        'default_url'              => '/:attachment/:style/missing.png',

        /*
        |--------------------------------------------------------------------------
        | Stapler Default Style
        |--------------------------------------------------------------------------
        |
        | The default style returned from the Stapler file location helper methods.
        | An unaltered version of uploaded file is always stored within the 'original'
        | style, however the default_style can be set to point to any of the defined
        | syles within the styles array.
        |
        */

        'default_style'            => 'original',

        /*
        |--------------------------------------------------------------------------
        | Stapler Styles
        |--------------------------------------------------------------------------
        |
        | An array of image sizes defined for the file attachment.
        | Stapler will attempt to format the file upload into the defined style.
        |
        */

        'styles'                   => [],

        /*
        |--------------------------------------------------------------------------
        | Convert Options
        |--------------------------------------------------------------------------
        |
        | An array of options for setting the quality and DPI of resized images.
        | Default values are 75 for Jpeg quality and 72 dpi for x/y-resolution.
        | Please see the Imagine\Image documentation for more details.
        |
        */

        'convert_options'          => [],

        /*
        |--------------------------------------------------------------------------
        | Keep Old Files Flag
        |--------------------------------------------------------------------------
        |
        | Set this to true in order to prevent older file uploads from being deleted
        | from storage when a record is updated with a new upload.
        |
        */

        'keep_old_files'           => false,

        /*
        |--------------------------------------------------------------------------
        | Preserve Files Flag
        |--------------------------------------------------------------------------
        |
        | Set this to true in order to prevent file uploads from being deleted
        | from the file system when an attachment is destroyed.  Essentially this
        | ensures the preservation of uploads event after their corresponding database
        | records have been removed.
        |
        */
        'preserve_files'           => false,

    ],
    'filesystem' => [

        /*
        |--------------------------------------------------------------------------
        | Stapler File Url
        |--------------------------------------------------------------------------
        |
        | The url (relative to your project document root) where files will be stored.
        | It is composed of 'interpolations' that will be replaced their
        | corresponding values during runtime.  It's unique in that it functions as both
        | a configuration option and an interpolation.
        |
        */

        'url' => '/system/:class/:attachment/:id_partition/:style/:filename',

        /*
        |--------------------------------------------------------------------------
        | Stapler File Path
        |--------------------------------------------------------------------------
        |
        | Similar to the url, the path option is the location where your files will
        | be stored at on disk.  It should be noted that the path option should not
        | conflict with the url option.  Stapler provides sensible defaults that take
        | care of this for you.
        |
        */

        'path' => ':app_root/public:url',

        /*
        |--------------------------------------------------------------------------
        | Override File Permissions Flag
        |--------------------------------------------------------------------------
        |
        | Override the default file permissions used by stapler when creating a new
        | file in the file system.  Leaving this value as null will result in stapler
        | chmod'ing files to 0666.  Set it to a specific octal value and stapler will
        | chmod accordingly.  Set it to false to prevent chmod from occuring (useful
        | for non unix-based environments).
        |
        */

        'override_file_permissions' => null,

    ],

    's3' => [
        [

            /*
            |--------------------------------------------------------------------------
            | S3 Client Config
            |--------------------------------------------------------------------------
            |
            | This is array holds the default configuration options used when creating
            | an instance of Aws\S3\S3Client.  These options will be passed directly to
            | the s3ClientFactory when creating an S3 client instance.
            |
            */
            's3_client_config' => [
                'key' => '',
                'secret' => '',
                'region' => '',
                'scheme' => 'http'
            ],

            /*
            |--------------------------------------------------------------------------
            | S3 Object Config
            |--------------------------------------------------------------------------
            |
            | An array of options used by the Aws\S3\S3Client::putObject() method when
            | storing a file on S3.
            | AWS Documentation for Aws\S3\S3Client::putObject() at
            | http://docs.aws.amazon.com/aws-sdk-php/latest/class-Aws.S3.S3Client.html#_putObject
            |
            */
            's3_object_config' => [
                'Bucket' => '',
                'ACL' => 'public-read'
            ],

            /*
            |--------------------------------------------------------------------------
            | S3 Path
            |--------------------------------------------------------------------------
            |
            | This is the key under the bucket in which the file will be stored.
            | The URL will be constructed from the bucket and the path.
            | This is what you will want to interpolate. Keys should be unique,
            | like filenames, and despite the fact that S3 (strictly speaking) does not
            | support directories, you can still use a / to separate parts of your file name.
            |
            */

            'path' => ':attachment/:id/:style/:filename',

        ],
    ],
];
