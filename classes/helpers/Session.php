<?php
namespace helpers;

class Session
{

    public function __construct()
    {
        session_start();
    }
    public function push($key,$value)
    {
        if (!isset($_SESSION[$key]))
        {
            $_SESSION[$key]=[];
        }

        $_SESSION[$key][]=$value;

    }
    public function add($key,$value)
    {
        if (!isset($_SESSION[$key]))
        {
            $_SESSION[$key]=[];
        }

        $_SESSION[$key]=$value;

    }

    public function get($key)
    {
        return isset($_SESSION[$key])?$_SESSION[$key]:false;

    }

    public function hasSession($key)
    {
        return isset($_SESSION[$key])? true:false;

    }


    public function remove($key)
    {
         unset($_SESSION[$key]);

    }

    public function destroy()
    {
         session_destroy();

    }






}