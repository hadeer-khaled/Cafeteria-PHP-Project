<?php
namespace helpers;
class Img
{
    private $tmp_name;
    public $imgNewName;
    public function __construct($image)
    {
        $name=$image['name'];
        $this->tmp_name=$image['tmp_name'];
        $ext=pathinfo($name,PATHINFO_EXTENSION);
        $this->imgNewName=uniqid().".".$ext;
    }

    public function upload()
    {
        move_uploaded_file($this->tmp_name,"../images/$this->imgNewName");
    }

    public static function delete($imgName)
    {
        unlink("../images/$imgName");
    }
}