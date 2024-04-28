<?php
namespace validation;
require_once 'ValidationInterface.php';
class Numeric implements ValidationInterface
{
    public function validate($name, $value)
    {
        $msg='';
        if (!empty($value)&&!is_string($value))
        {
            $msg="$name must be numeric";
        }
        return $msg;
    }
}