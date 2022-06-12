<?php include("festivaldb.php"); ?>
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
                <label>First name:<br/>
                    <input type="text" name="txtFirstName"/>
                </label>
                <br/>
                <label>(Prefix +) Surname:<br/>
                    <input type="text" class="inputPrefix" name="txtPrefix"/> <input type="text" name="txtSurname"/>
                </label>
                <br/>
                <label>Phone number:<br/>
                    <input type="text" name="txtPhoneNumber"/>
                </label>
                <br/>
                <label>Email:<br/>
                    <input type="text" name="txtEmail"/>
                </label>
                <br/>
                <label>Password:<br/>
                    <input type="password" name="txtPassword"/>
                </label>
                <br/>
                <br/>
                <input type="submit"  value="Register" class="btnForm" name="btnRegister"/>
                <br/>
            <?php 
            if(isset($_POST['btnRegister'])) {
                insertUserInDB($_POST['txtFirstName'],$_POST['txtPrefix'], $_POST['txtSurname'],
                $_POST['txtPhoneNumber'],$_POST['txtEmail'],$_POST['txtPassword']);
                ?>    </form>
                <?php
            }
                ?>
                </form>

            <form id="loginForm" method="POST">
                <h2>Log in</h2>
                <label>Email:<br/>
                    <input type="text" name="txtEmailLogin"/>
                </label>
                <br/>
                <label>Password:<br/>
                    <input type="text" name="txtPasswordLogin"/>
                </label>
                <br/>
                <br/>
                <input type="submit" class="btnForm" name="btnLogin" value="Log in"/>
                <?php 
                if(isset($_POST['btnLogin'])) varifyPasswordOfUser($_POST['txtEmailLogin'],$_POST['txtPasswordLogin']);
                ?>
            </form>
        
        </div>
        <div id="imageDiv"></div>
    </div>


        
            
    

        
    
        
            

   
    
</body>
</html>