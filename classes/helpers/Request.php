<?php
namespace helpers;
class Request{

    public function post($key)
    {
        return (isset($_POST[$key])? $_POST[$key] :FALSE);

    }

    public function get($key)
    {
        return (isset($_GET[$key])? $_GET[$key] :FALSE);
    }

    public function redirect($path)
    {
        return header("location:$path");
    }

    public function file($key)
    {
        return (isset($_FILES[$key])? $_FILES[$key] :FALSE);
    }

    public function ispost()
    {
        return ($_SERVER['REQUEST_METHOD']=='POST'? true :FALSE);

    }

    public function isget()
    {
        return ($_SERVER['REQUEST_METHOD']=='GET'? true :FALSE);

    }
}