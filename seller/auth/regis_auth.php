<?php

require '../php/ping_test.php';
include('database.php');
session_start();
$conn=mysqli_connect($host,$username,$password,"shoeswap");

function isValidEmail(string $email): bool {
    // Use PHP's built-in filter
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function isValidPassword($password) {
    $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&^_-]).{8,}$/';
    return preg_match($pattern, $password);
}

function isValidUsername($username) {
    $username = trim($username);
    return !empty($username) &&
           strpos($username, ' ') === false &&
           strlen($username) >= 8 &&
           strlen($username) <= 12;
}


if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email=trim($_POST["user-email"]);
    $user=$_POST["user-name"];
    $pass=$_POST["user-pass"];
    $passconfirm=$_POST["user-pass-confirm"];
    $security=trim($_POST["security-ques"]);

    if (
        empty($email) || strlen($email) > 50 || !filter_var($email, FILTER_VALIDATE_EMAIL) ||
        empty($user) || strlen($user) > 12 || empty($pass) || empty($passconfirm) ||
        !isValidEmail($email) ||
        empty($security) || strlen($security) != 4 || !ctype_digit($security)
    ) {
        echo "<script>alert('Operation aborted!'); window.location.replace('../login.php');</script>";
        session_destroy();
        exit;
    }

    if ($pass !== $passconfirm){
        echo "<script>alert('Password mismatch!'); window.location.replace('../registration.php');</script>";
        session_destroy();
        exit;
    }

    if (!isValidPassword($pass) || !isValidPassword($passconfirm)){
        echo "<script>alert('Password must be at least 8 characters long and include at least one letter, one number, and one special character.'); window.location.replace('../registration.php');</script>";
        session_destroy();
        exit;
    }

    if (!isValidUsername($user)){
        echo "<script>alert('Username must be at least 8 characters long and contains no spaces.'); window.location.replace('../registration.php');</script>";
        session_destroy();
        exit;
    }

    // ----------connecting to database----------

    $counter=0;
    $sql="select * from seller";
    $result=mysqli_query($conn,$sql);

    if(mysqli_num_rows($result)>0){
        while($rows= mysqli_fetch_assoc($result)){
           if( $rows["USERNAME"]==$user){
            $counter++;
            echo "<script>alert('User already exists!'); window.location.replace('../registration.php');</script>";
            exit;
           }
           elseif($rows["EMAIL_ID"]==$email){
            $counter++;
            echo "<script>alert('Email already exists!'); window.location.replace('../registration.php');</script>";
            exit;
           }
        }
    }
    if($counter<1){

        $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

        if(!$result){
            die("Something went wrong!".mysqli_connect_errno());
        }
        else{
            $_SESSION['seller_email'] = $email;
            $_SESSION['seller_pass'] = $hashedPassword;
            $_SESSION['seller_username'] = $user;
            $_SESSION['seller_security'] = $security;
            header("Location: otp_regis_auth.php");
            exit;
        }
        

    }
    else{
        echo "<script>alert('Unauthorized access!'); window.location.replace('../registration.php');</script>";
        exit;
    }
} else {
    http_response_code(403);
    echo '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>403 Forbidden</title>
<style>
body {
  margin: 0;
  padding: 0;
  background-color: #fff3f3;
  font-family: "Segoe UI", sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  color: #e74c3c;
}
.container {
  text-align: center;
  border: 2px dashed #e74c3c;
  border-radius: 16px;
  padding: 40px;
  background-color: #ffffff;
  box-shadow: 0 0 15px rgba(0,0,0,0.05);
}
h1 {
  font-size: 48px;
  margin-bottom: 10px;
}
p {
  font-size: 20px;
}
</style>
</head>
<body>
<div class="container">
<h1>403 Forbidden</h1>
<p>Kangaroos can\'t jump here!</p>
</div>
</body>
</html>
';
exit;
}
?>
