

<?php 
    $host = "localhost";
    $username = "root";
    $password = "";
    $dbname = "festival";

    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname",$username,$password);
    } catch (Exception $ex) {
        echo "verbinding mislukt";
    }

    function hashPassword($password){
        $hashedPassword = password_hash($password,PASSWORD_DEFAULT);

        return $hashedPassword;
    }
?>