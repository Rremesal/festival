
<a href="index.php"><img id="logo" src="images/logo.png"/></a>
<?php
    if(isset($_SESSION['user'])) {
?>      <a href="order.php"><img id="shoppingcartLogo" src="images/shoppingcart2.png"/></a>
<?php } else {
?>       <a href="login.php"><img id="shoppingcartLogo" src="images/shoppingcart2.png"/></a>   
<?php }?>


<?php if(isset($_SESSION['user_name'])) {
?>      <a onclick="showDropDown()"><img id="userLogo" src="images/user_logo.png"/></a>
<?php } ?>

<div id="dropdown">
    <div><a href="login.php"> <?="Logged in as: ".$_SESSION['user_name']; ?></a></div>
    <?php  if(isset($_SESSION['user_name'])) {
    ?>     <a href="logout.php">Log out</a>
    <?php
        }
    ?>
</div>

<div id="menu"> 
    <div id="a-items">
        <?php 
            if(isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
        ?>      <a href="module.php">Admin</a>
        <?php }?> 
        <a href="line-up.php">Line-up</a>
        <a href="contact.php">Contact</a>
        <a href="webshop.php">Buy tickets</a>
        <?php 
            if(empty($_SESSION['user'])) {
        ?>      <a id="btnLogin" href="login.php">Log in</a>
        <?php }?>
        
    </div>
</div>
