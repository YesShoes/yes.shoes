<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6cf87926df5764f388edcae91bf125c2
{
    public static $prefixLengthsPsr4 = array (
        'S' => 
        array (
            'SkyVerge\\WooCommerce\\Facebook\\' => 30,
        ),
        'C' => 
        array (
            'Composer\\Installers\\' => 20,
        ),
        'A' => 
        array (
            'Automattic\\WooCommerce\\ActionSchedulerJobFramework\\' => 51,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'SkyVerge\\WooCommerce\\Facebook\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
        'Composer\\Installers\\' => 
        array (
            0 => __DIR__ . '/..' . '/composer/installers/src/Composer/Installers',
        ),
        'Automattic\\WooCommerce\\ActionSchedulerJobFramework\\' => 
        array (
            0 => __DIR__ . '/..' . '/woocommerce/action-scheduler-job-framework/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6cf87926df5764f388edcae91bf125c2::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6cf87926df5764f388edcae91bf125c2::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit6cf87926df5764f388edcae91bf125c2::$classMap;

        }, null, ClassLoader::class);
    }
}
