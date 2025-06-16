<?php
require '../php/ping_test.php';
include('../auth/database.php');
session_start();
$conn = mysqli_connect($host, $username, $password, "shoeswap");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST["user-name"];
    $pass = $_POST["user-pass"];

    if (strlen($user) > 12 || empty($pass)){
        echo "<script>alert('Operation aborted!'); window.location.replace('../login.php');</script>";
        session_destroy();
        exit();
    }

    $sql = "SELECT * FROM seller WHERE USERNAME = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $user);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($pass, $row["PASSWORD"])) {
            $_SESSION["s_user"] = $row["USERNAME"];
            $_SESSION["seller_umail"] = $row["EMAIL_ID"];
            $_SESSION["s_status"] = "active";

            header("Location: otp_login_auth.php");
            exit();

        } else {
            echo "<script>alert('Password Mismatch!'); window.location.replace('../login.php');</script>";
            exit();
        }
    } else {
        echo "<script>alert('User does not exist!'); window.location.replace('../login.php');</script>";
        exit();
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
