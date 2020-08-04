<?php

namespace App\Helper;
/**
|--------------------------------------------------------------------------
| Elements class
|--------------------------------------------------------------------------
|
| Used add elements on views.
|
 */
class Elements
{
    /**
     * @param string $element The name of the element.
     * @param array $data     (optional) Array of data.
     */
    public static function element(string $element, array $data = [])
    {
        require ROOT . "/templates/elements/{$element}.php";
    }
}