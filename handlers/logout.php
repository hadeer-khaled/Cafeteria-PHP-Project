<?php
   // Start the session to access session variables
   session_start();
   
 
       setcookie('auth_token', '', time() - 36000, '/');
   
       // Optionally, you may want to destroy the session data
       echo "Session data before destroying: ";
       session_unset();
       session_destroy();
   
   // Redirect the user to the login page
   header('Location: ../pages/index.php');
   exit();
   ?>
   
