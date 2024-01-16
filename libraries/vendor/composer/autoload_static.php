<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit7e34998411c07c8a77995a85e0294ae5
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
        'O' => 
        array (
            'Ozdemir\\Datatables\\' => 19,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
        'Ozdemir\\Datatables\\' => 
        array (
            0 => __DIR__ . '/..' . '/ozdemir/datatables/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'S' => 
        array (
            'Sunra\\PhpSimple\\HtmlDomParser' => 
            array (
                0 => __DIR__ . '/..' . '/sunra/php-simple-html-dom-parser/Src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit7e34998411c07c8a77995a85e0294ae5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit7e34998411c07c8a77995a85e0294ae5::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit7e34998411c07c8a77995a85e0294ae5::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}