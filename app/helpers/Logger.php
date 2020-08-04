<?php

namespace App\Helper;
/**
|--------------------------------------------------------------------------
| Logger class
|--------------------------------------------------------------------------
|
| Used to log errors.
|
 */
class Logger
{
    /**
     * Used to log errors/custome error messages in specific files.
     * @param string $message
     * @param string $file
     * @return void
     */
    public static function logError(string $message, string $file): void
    {
        $timestamp = date("Y-m-d H:i:s");
        error_log("$timestamp: $message \n", 3, ROOT . "/tmp/logs/{$file}.log");
    }
}