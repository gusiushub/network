<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit4b74d7bebf3619f702f8c020656ad8fe
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Workerman\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Workerman\\' => 
        array (
            0 => __DIR__ . '/..' . '/workerman/workerman',
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit4b74d7bebf3619f702f8c020656ad8fe::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit4b74d7bebf3619f702f8c020656ad8fe::$prefixDirsPsr4;

        }, null, ClassLoader::class);
    }
}
