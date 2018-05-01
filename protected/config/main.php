<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');


return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'HRM',
    'defaultController' => 'dashboard',
    //'homeUrl'=>'home',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'ext.YiiMailer.YiiMailer',
        /*         * * for gallery extesnion *** */
        'ext.galleryManager.*',
        'ext.galleryManager.models.*',
        'ext.galleryManager.GalleryController',
        'ext.yiisortablemodel.models.*',
        'ext.yii_select2.Select2',
    ),
    //'viewPath' => 'views/admin',
    'controllerMap' => array(
        'floara' => array(
            'class' => 'ext.floara.FloaraController',
        ),
    ),
    //'theme'=>'bootstrap', // requires you to copy the theme under your themes directory
    'modules' => array(
        // uncomment the following to enable the Gii tool

        /*'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'admin',
            'generatorPaths' => array(
                'bootstrap.gii',
            ),
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('*', '::1'),
        ),*/
    ),
    // application components
    'components' => array(
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
        ),
        'phpThumb' => array(
            'class' => 'ext.EPhpThumb.EPhpThumb.EPhpThumb',
        ),
        // to disable caching
        'components' => array(
            'assetManager' => array(
                'linkAssets' => false,
            ),
        ),
        /*         * *For gallery extension  ** */
        'widgetFactory' => array(
            'class' => 'CWidgetFactory',
            'widgets' => array(
                'GalleryManager' => array(
                    'controllerRoute' => '/gallery',
                ),
                'SAImageDisplayer' => array(
                    'baseDir' => 'media',
                    'originalFolderName' => '',
                    'sizes' => array(
                        'small' => array('width' => 180, 'height' => 180),
                        'big' => array('width' => 540, 'height' => 299),
                    ),
                    'groups' => array(
                        'users' => array(
                            'tiny' => array('width' => 80, 'height' => 80),
                            'small' => array('width' => 180, 'height' => 180),
                            'medium' => array('width' => 270, 'height' => 270),
                            'big' => array('width' => 540, 'height' => 299),
                        ),
                    ),
                ),
            )
        ),
        'image' => array(
            'class' => 'application.extensions.image.CImageComponent',
            // GD or ImageMagick
            'driver' => 'GD',
            // ImageMagick setup path
            'params' => array('directory' => '/var/www/projects/PHPLib/ImageMagick-6.8.6-8'),
        ),
        'mailer' => array(
            'class' => 'ext.mail.Mailer',
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '_<slug>' => 'home/page',
                'article-<slug>' => 'home/article',
            ),
        ),
        // uncomment the following to use a MySQL database
        'db' => require(dirname(__FILE__) . '/connection.php'),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'dashboard/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages


            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'admin@hrm.com',
        'dateFormatJS' => 'mm/dd/yy', /* must be the same as the {{dateModelFormat}} but with Y instead of yy (m=>mm , d=>dd) */
        'dateFormatPHP' => 'm/d/Y H:i',
        'projectUrl' => 'http://egysn.com',
        'Normal' => 1,
        'Admin' => 2,
        'subAdmin' => 3,
    ),
);