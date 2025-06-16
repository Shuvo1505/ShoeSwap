<?php
require '../php/ping_test.php';
include('database.php');
session_start();
$conn = mysqli_connect($host, $username, $password, "shoeswap");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST["user-name"]);
    $pass = trim($_POST["user-pass"]);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    if (strlen($user) > 12 || empty($user) || empty($pass)){
        echo "
        <script>alert('Login failed!'); window.location.replace('../login.php');</script>
    ";
    exit;
    }

    $stmt = $conn->prepare("SELECT * FROM user WHERE USERNAME = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

      
        

        if (password_verify($pass, $row["PASSWORD"])) { // Use password_verify() if passwords are hashed
            $_SESSION["userId"] = $row["userId"];
            $_SESSION["user"] = $row["FNAME"];
            $_SESSION["username"] = $row["USERNAME"];
            $_SESSION["user_email"] = $row["EMAIL_ID"];
            $_SESSION["status"] = "active";
            header("Location: otp_auth_login.php");
            
        } else {
            // Password mismatch
            header("Location: ../login.php?error=incorrect_password");
        }
    } else {
        // User doesn't exist
        header("Location: ../login.php?error=user_not_found");
    }

    $stmt->close();
    mysqli_close($conn);
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
