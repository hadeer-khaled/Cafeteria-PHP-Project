<?php
namespace validation;
require_once 'ValidationInterface.php';
class Max implements ValidationInterface
{
    public function validate($name, $value)
    {
        $msg='';
        if (strlen($value)>50)
        {
            $msg="$name must be less than 50 characters";
        }
        return $msg;
    }
}