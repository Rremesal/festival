<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="style.css"/>
    <title>Product Ordered</title>
</head>
<body id="orderedBody">
    <?php include("menu.php");?>
    <div id="orderedDiv">
        <h2>Your order has been placed.</h2>
        <?php unset($_SESSION['shoppingCart']); ?>
        <?php header("Refresh: 1 webshop.php");?>
    </div>
    <script src="script.js"></script>
</body>
</html>