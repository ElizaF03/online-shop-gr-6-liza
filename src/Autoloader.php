<?php

class Autoloader
{
    public static function registrate()
    {
        $autoloader = function (string $class) {

            $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
            $path = $path . ".php";
            $path = __DIR__ . '//' . $path;

            if (file_exists($path)) {
                require_once $path;
                return true;
            }
            return false;
        };
        spl_autoload_register($autoloader);
    }
}