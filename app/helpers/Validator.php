<?php

namespace App\Helper;
/**
 * Used in all models for common validate rules.
 */
class Validator
{
    /**
     * Used to check if the values are emtpy.
     * @param array $data
     * @return void|bool
     */
    public function notBlank(array $data)
    {
        foreach ($data as $key => $value) {
            if ($value === '') {
                echo json_encode([
                    'result' => false,
                    'message' => ucfirst($key) . ' cannot be empty',
                ], JSON_PRETTY_PRINT); die;
            }
        }
        return true;
    }
}