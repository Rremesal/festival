
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
        $query = "INSERT INTO user (firstname,surname_prefix,surname,phonenumber,email, password,isAdmin) ". 
        "VALUES (:firstname, :prefix,  :surname, :phonenumber, :email, :password, 0)";
        $passwordHash = password_hash($password,PASSWORD_DEFAULT);
        $stm = $conn->prepare($query);
        $stm->bindParam(":email",$email);
        $stm->bindParam(":password",$passwordHash);
        $stm->bindParam(":phonenumber",$phonenumber);
        $stm->bindParam(":firstname",$firstname);
        $stm->bindParam(":prefix",$surname_prefix);
        $stm->bindParam(":surname",$surname);
        if($stm->execute()) {
            $query = "SELECT * FROM user WHERE email='$email'";
            $stm = $conn->prepare($query);
            $stm->execute();
            $registeredUser = $stm->fetch(PDO::FETCH_OBJ);
            $_SESSION['user'] = $registeredUser->user_id;
            $_SESSION['user_name'] = $registeredUser->firstname;
            $_SESSION['password'] = $registeredUser->password;
            $_SESSION['isAdmin'] = $registeredUser->isAdmin;
            header("Location: index.php");
        } else echo "This email address already exists";
    }

    function verifyPasswordOfUser($email,$password) {
        $conn = connectToDB();
        $query = "SELECT * FROM user WHERE email=:username";
        $stm = $conn->prepare($query);
        $stm->bindParam(":username",$email);
        if($stm->execute()) {
            $user = $stm->fetch(PDO::FETCH_OBJ);
            if(password_verify($password,$user->password)) {
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

    function getTickets() {
        $query = "SELECT * FROM ticket";
        $conn = connectToDB();
        $stm = $conn->prepare($query);
        if($stm->execute()) {
            return $stm->fetchAll(PDO::FETCH_OBJ);
        }
    }

    function TotalTicketsSold() {
        $conn = connectToDB();
        $query = "SELECT SUM(amount) as ticketsSold FROM transaction";
        $stm = $conn->prepare($query);
        $stm->execute();
        return $stm->fetch(PDO::FETCH_OBJ);
    }
