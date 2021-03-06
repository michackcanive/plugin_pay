<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0496213049c99be8e3ee2a147fba3930
{
    public static $prefixLengthsPsr4 = array (
        'I' => 
        array (
            'Inc\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Inc\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0496213049c99be8e3ee2a147fba3930::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0496213049c99be8e3ee2a147fba3930::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0496213049c99be8e3ee2a147fba3930::$classMap;

        }, null, ClassLoader::class);
    }
}
