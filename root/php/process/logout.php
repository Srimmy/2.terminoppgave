<?php

require_once "../config/config.php";
 

$_SESSION = array();

session_destroy();
 
header("location: ../register/login.php");
exit;
?>