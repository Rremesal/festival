

<?php 
    function connectToDB() {
        $host = "localhost";
        $username = "root";
        $password = "";
        $dbname = "festival";
    
        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
            return $conn;
        } catch (Exception $ex) {
            echo "verbinding mislukt";
        }
    
    }

    function insertUserInDB($firstname,$surname_prefix,$surname,$phonenumber,$email,$password) {
        $conn = connectToDB();
        
        $insertUserQuery = "INSERT INTO user (firstname,surname_prefix,surname,phonenumber,email, password,isAdmin) ". 
        "VALUES (:firstname, :prefix,  :surname, :phonenumber, :email, :password, 0)";
        $passwordHash = password_hash($password,PASSWORD_DEFAULT);
        $stm = $conn->prepare($insertUserQuery);
        $stm->bindParam(":email",$email);
        $stm->bindParam(":password",$passwordHash);
        $stm->bindParam(":phonenumber",$phonenumber);
        $stm->bindParam(":firstname",$firstname);
        $stm->bindParam(":prefix",$surname_prefix);
        $stm->bindParam(":surname",$surname);
        $stm->execute();

        $selectUserQuery = "SELECT * FROM user WHERE email='$email'";
        $stm = $conn->prepare($selectUserQuery);
        $stm->execute();
        $registeredUser = $stm->fetch(PDO::FETCH_OBJ);
        session_start();
        $_SESSION['user'] = $registeredUser->user_id;
        $_SESSION['user_name'] = $registeredUser->firstname;
        $_SESSION['password'] = $registeredUser->password;
        $_SESSION['isAdmin'] = $registeredUser->isAdmin;
        header("Location: index.php");

    }

    function varifyPasswordOfUser($email,$password) {
        $conn = connectToDB();
        $query = "SELECT * FROM user WHERE email=:username";
        $stm = $conn->prepare($query);
        $stm->bindParam(":username",$email);
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

    function hashPassword($password){
        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

        return $hashedPassword;
    }
?>