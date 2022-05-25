
<a href="index.php"><img id="logo" src="images/logo.png"/></a>
<?php if(isset($_SESSION['user'])) {
?>      <a onclick="showDropDown()"><img id="userLogo" src="images/user_logo.png"/></a>
<?php } ?>

<div id="dropdown">
    <div><a href="login.php"> <?php if(!isset($_SESSION['user'])) echo "Sign in"; else echo "Logged in as: ".$_SESSION['user']; ?></a></div>
    <?php  if(isset($_SESSION['user'])) {
    ?>     <a href="logout.php">Log out</a>
    <?php
        }
    ?>



</div>
<div id="menu"> 
    <a href="line-up.php">Line-up</a>
    <a href="contact.php">Contact</a>
    <a href="#">Buy tickets</a>
    <a id="btnLogin" href="login.php">Log in</a>
</div>
