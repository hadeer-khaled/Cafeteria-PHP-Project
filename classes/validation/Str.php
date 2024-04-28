<?php
namespace validation;
require_once 'ValidationInterface.php';
class Str implements ValidationInterface
{
    public function validate($name, $value)
    {
        $msg='';
        if (is_numeric($value))
        {
            $msg="$name must be a string";
        }
        return $msg;
    }
}