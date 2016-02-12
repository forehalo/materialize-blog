<?php

namespace App\Services;

use Illuminate\Validation\Validator;

class Validation extends Validator
{
    public function validateTags($attribute, $value, $parameters)
    {
        return preg_match("/^[^\s]{1,50}?(,[^\s]{1,50})*$/u", $value);
    }
}