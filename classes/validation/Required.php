<?php
namespace validation;
require_once 'ValidationInterface.php';
class Required implements ValidationInterface
{
    public function validate($name, $value)
    {
        $msg='';
        if (empty($value))
        {
            $msg="$name is required";
        }
        return $msg;
    }
}