<?php 
    session_start(); 
    session_unset();
    header("Refresh: 0.1 login.php");
?>