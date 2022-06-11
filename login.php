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
                $insertUserQuery = "INSERT INTO user (email, password,phonenumber,firstname,surname_prefix,surname,isAdmin) ". 
                "VALUES ( :email, :password, :phonenumber, :firstname, :surname, :prefix, 0)";
                $passwordHash = password_hash($_POST['txtPassword'],PASSWORD_DEFAULT);
                $stm = $conn->prepare($insertUserQuery);
                $stm->bindParam(":email",$_POST['txtEmail']);
                $stm->bindParam(":password",$passwordHash);
                $stm->bindParam(":phonenumber",$_POST['txtPhoneNumber']);
                $stm->bindParam(":firstname",$_POST['txtFirstName']);
                $stm->bindParam(":prefix",$_POST['txtPrefix']);
                $stm->bindParam(":surname",$_POST['txtSurname']);
                if($stm->execute()) {
                echo "geregisteerd";
                ?>    </form>
                <?php
                }
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
                if(isset($_POST['btnLogin'])) {
                    $password = $_POST['txtPasswordLogin'];

                    $query = "SELECT * FROM user WHERE email=:username";
                    $stm = $conn->prepare($query);
                    $stm->bindParam(":username",$_POST['txtEmailLogin']);
                    if($stm->execute()) {
                        $user = $stm->fetch(PDO::FETCH_OBJ);
                        if(password_verify($password,$user->password)) {
                            session_start();
                            $_SESSION['user'] = $user->user_id;
                            $_SESSION['user_name'] = $user->firstname;
                            $_SESSION['password'] = $user->password;
                            $_SESSION['isAdmin'] = $user->isAdmin;
                            header("Location: index.php");
                        }
                    } 
                }
                ?>
            </form>
        
        </div>
        <div id="imageDiv"></div>
    </div>


        
            
    

        
    
        
            

   
    
</body>
</html>