<?php
namespace validation;
require_once 'Email.php';
require_once 'Img.php';
require_once 'Max.php';
require_once 'Numeric.php';
require_once 'Required.php';
require_once 'Str.php';


class Validator 
{   
    public $errors=[];
    public function makeValidation($name,$value,$obj)
    {
        return $obj->validate($name,$value);
    }

    public function rules($name,$value,$rules)
    {
        foreach ($rules as $rule) {
            if($rule=='email')
            {
                $this->makeValidation($name,$value, new Email());

            }
            else if($rule=='img')
            {
                $this->makeValidation($name,$value, new Img());

            }
            else if($rule=='max:50')
            {
                $error=$this->makeValidation($name,$value, new Max());

            }
            else if($rule=='numeric')
            {
                $error=$this->makeValidation($name,$value, new Numeric());

            }
            else if($rule=='required')
            {
                $error=$this->makeValidation($name,$value, new Required());

            }
            else if($rule=='string')
            {
                $error=$this->makeValidation($name,$value, new Str());

            }
            else
            {
                $error=false; 
            }

            if($error!=false)
            {
                $this->errors[]=$error;
            }

        }

    }
}