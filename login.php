<?php 
    include("festivaldb.php"); 
    $conn = connectToDB();
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="style.css"/>
    <script src="script.js"></script>
    <title>Log in</title>
</head>
<body id="loginBody">
    <?php require("menu.php"); ?>
    <div class="content" id="loginPage">
        <div id="registerDiv">
            <form id="registerForm" method="POST">
                <h2>Register Account</h2>
                <label for="txtFirstName">First name:</label>
                <div><input type="text" name="txtFirstName" id="txtFirstName"/></div>
                <label for="txtPrefix">(Prefix +) Surname:</label>
                <div><input type="text" class="inputPrefix" name="txtPrefix" id="txtPrefix"/> <input type="text" name="txtSurname"/></div>
                <label for="txtPhoneNumber">Phone number:</label>
                <div><input type="text" name="txtPhoneNumber" id="txtPhoneNumber"/></div>
                <label for="txtEmail">Email:</label>
                <div><input type="text" name="txtEmail" id="txtEmail"/></div>
                <label for="txtPassword">Password:</label>
                <div><input type="password" name="txtPassword" id="txtPassword"/></div>
                <label for="txtConfirmPassword">Confirm password:</label>
                <div><input type="password" name="txtConfirmPassword"/></div>
                <div><input type="submit"  value="Register" class="btnForm" name="btnRegister"/></div>
            
            <?php 
            if(isset($_POST['btnRegister']) && $_POST['txtPassword'] == $_POST['txtConfirmPassword']) {

                insertUserInDB($_POST['txtFirstName'],$_POST['txtPrefix'], $_POST['txtSurname'],
                $_POST['txtPhoneNumber'],$_POST['txtEmail'],$_POST['txtPassword']);
                ?>    </form>
                <?php
            }
                ?>
                </form>

            <form id="loginForm" method="POST">
                <h2>Log in</h2>
                <label for="txtEmailLogin">Email:</label>
                <div><input type="text" name="txtEmailLogin" id="txtEmailLogin"/></div>
                <label for="txtPasswordLogin">Password:</label>
                <div><input type="text" name="txtPasswordLogin" id="txtPasswordLogin"/></div>
                <div><input type="submit" class="btnForm" name="btnLogin" value="Log in"/></div>
                
                <?php 
                if(isset($_POST['btnLogin'])) verifyPasswordOfUser($_POST['txtEmailLogin'],$_POST['txtPasswordLogin']);
                ?>
            </form>
        
        </div>
        <div id="imageDiv"></div>
    </div>


        
            
    

        
    
        
            

   
    
</body>
</html>