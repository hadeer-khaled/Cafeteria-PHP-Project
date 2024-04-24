<?php
use helpers\{  
    Request,
    Session,
    Str,
    Img
};
use validation\Validator;

require_once 'classes/helpers/Request.php';
require_once 'classes/helpers/Session.php';
require_once 'classes/validation/Validator.php';
require_once 'classes/helpers/Str.php';
require_once 'classes/helpers/Img.php';


$request= new Request;
$session=new Session;
$validation=new Validator;
