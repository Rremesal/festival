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
                    <input type="text" id="inputPrefix" name="txtPrefix"/> <input type="text" name="txtSurname"/>
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

    $firstName = $_POST['txtFirstName'];
    $prefix = $_POST['txtPrefix'];
    $surname = $_POST['txtSurname'];
    $phoneNumber = $_POST['txtPhoneNumber'];
    $email = $_POST['txtEmail'];
    $password = $_POST['txtPassword'];

    $insertQuery = "INSERT INTO user (email, password,phonenumber,firstname,surname_prefix,surname) ". 
    "VALUES ('$email','$password','$phoneNumber','$firstName','$prefix','$surname')";
    $stm = $conn->prepare($insertQuery);
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
                    $username = $_POST['txtEmailLogin'];
                    $password = $_POST['txtPasswordLogin'];

                    $query = "SELECT * FROM user WHERE email='$username'";
                    $stm = $conn->prepare($query);
                    var_dump($query);
                    if($stm->execute()) {
                        $rows = $stm->fetch(PDO::FETCH_OBJ);
                        var_dump($rows);
                        if($password === $rows->password) {
                            session_start();
                            $_SESSION['user'] = $rows->user_id;
                            $_SESSION['password'] = $rows->password;
                            $_SESSION['isAdmin'] = $rows->isAdmin;
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