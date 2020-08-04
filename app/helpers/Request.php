<?php

namespace App\Helper;
/**
|--------------------------------------------------------------------------
| Request class
|--------------------------------------------------------------------------
|
| Class used to get and process request info.
|
 */
class Request
{
    /**
     * Used to check the request type.
     * @param string $type
     * @return bool
     */
    public function is(string $type): bool
    {
        switch ($type) {
            case 'POST': {
                return $_SERVER['REQUEST_METHOD'] === 'POST';
            }
            break;
            case 'GET': {
                return $_SERVER['REQUEST_METHOD'] === 'GET';
            }
            break;
            case 'PUT': {
                return $_SERVER['REQUEST_METHOD'] === 'PUT';
            }
            break;
            case 'PATCH': {
                return $_SERVER['REQUEST_METHOD'] === 'PATCH';
            }
            break;
            case 'DELETE': {
                return $_SERVER['REQUEST_METHOD'] === 'DELETE';
            }
            break;
            default : {
                return false;
            }
        }
    }

    /**
     * Parsing all the data that is being sent as JSON. `json_decode`
     * turns our JSON-object into a PHP Associative arra.
     * IF $data === null, then there's no need for JSON data and the
     * server needs to handle the request so $data falls back to $_POST.
     * @param string|null $value
     * @return array|string
     */
    public function data(string $value = null)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if ($data === null) {
            $data = $_POST;
        }
        if (!empty($value)) {
            return $data[$value];
        }
        return $data;
    }
}