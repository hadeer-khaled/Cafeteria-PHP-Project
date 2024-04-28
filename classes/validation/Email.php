<?php
namespace validation;
require_once 'ValidationInterface.php';
class Email implements ValidationInterface
{
    public function validate($name, $value)
    {
        $msg='';
        if (!filter_var($value,FILTER_VALIDATE_EMAIL))
        {
            $msg="$name Is not a valid email address";
        }
        return $msg;
    }
}