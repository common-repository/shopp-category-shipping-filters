<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2a66bb52f9503f0316b76f64a446cec7
{
    public static $classMap = array (
        'WordPress_SimpleSettings' => __DIR__ . '/..' . '/objectivco/wordpress-simple-settings/src/wordpress-simple-settings.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit2a66bb52f9503f0316b76f64a446cec7::$classMap;

        }, null, ClassLoader::class);
    }
}