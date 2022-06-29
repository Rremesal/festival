<?php 
    session_start();
    unset($_SESSION['shoppingCart'][$_GET['id']]);
    header("Location: order.php");