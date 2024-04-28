<?php
namespace validation;
require_once 'ValidationInterface.php';
class Img implements ValidationInterface
{
    public function validate($name, $value)
    {
        $msg='';
        $ext=pathinfo($value,PATHINFO_EXTENSION);
        $extensions=['png','jpeg','jpg'];
        if (!empty($value)&&!in_array(strtolower($ext),$extensions))
        {
            $msg="$name is not a valid image";
            
        }
        return $msg;
    }
}