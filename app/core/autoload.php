<?php
/**
 * |--------------------------------------------------------------------------
 * | Custom autoload function
 * |--------------------------------------------------------------------------
 * | Used to autoload classes from AUTOLOAD_CLASSES constant.
 * @param string $class
 * @return void
 */
function loader(string $class): void
{
    // reversing the class name twice due to namespaces in order to get the actual class name without namespace
    $class = strrev(explode('\\', strrev($class))[0]);
    foreach (AUTOLOAD_CLASSES as $path) {
        $class_file = $path . DIRECTORY_SEPARATOR . $class . '.php';
        if (file_exists($class_file)) {
            require_once $class_file;
        }
    }
}

spl_autoload_register('loader');