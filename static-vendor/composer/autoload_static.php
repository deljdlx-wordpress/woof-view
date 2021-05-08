<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3d1d29923ada5dfca0992545f2460fec
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'Woof\\View\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Woof\\View\\' => 
        array (
            0 => __DIR__ . '/../..' . '/class',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3d1d29923ada5dfca0992545f2460fec::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3d1d29923ada5dfca0992545f2460fec::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3d1d29923ada5dfca0992545f2460fec::$classMap;

        }, null, ClassLoader::class);
    }
}
