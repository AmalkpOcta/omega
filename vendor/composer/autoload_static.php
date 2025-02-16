<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc417a0880f50f5740e16b9b2583b7593
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc417a0880f50f5740e16b9b2583b7593::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc417a0880f50f5740e16b9b2583b7593::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitc417a0880f50f5740e16b9b2583b7593::$classMap;

        }, null, ClassLoader::class);
    }
}
