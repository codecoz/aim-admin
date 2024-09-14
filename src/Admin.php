<?php

namespace CodeCoz\AimAdmin;

class Admin
{
    // Build wonderful Aim Admin Package

    public static function packagePath($path): string
    {
        return __DIR__ . "/../$path";
    }

}
