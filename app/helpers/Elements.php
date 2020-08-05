<?php
namespace App\Helper;
/**
 * Used add elements on views.
 */
class Elements
{
    /**
     * @param string $element  The name of the element.
     * @param array|null $data (optional) Array of data.
     * @return void
     */
    public static function add(string $element, ?array $data = []): void
    {
        require ELEMENTS . DIRECTORY_SEPARATOR . "{$element}.php";
    }
}
