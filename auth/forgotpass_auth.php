<?php
require '../php/ping_test.php';
session_start();
include('database.php');
$conn = mysqli_connect($host, $username, $password, "shoeswap");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user     = trim($_POST["username"]);
    $question = trim($_POST["security"]);

    if (strlen($user) > 12 || strlen($question) != 4 || empty($user) || empty($question)){
        header("Location: ../forgotpass.php?error=aborted");
        exit();
    }

    // Check if username and matching security answer exist together
    $sql = "SELECT * FROM user WHERE USERNAME = ? AND SECURITY_QUES = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $user, $question);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Both username and security question match
        $_SESSION['username_email'] = $row['EMAIL_ID'];
        $_SESSION['username'] = $row['USERNAME'];
        header("Location: otp_auth_password.php");
        exit;
    } else {
        // No matching user+security pair
        header("Location: ../forgotpass.php?error=invalid_credentials");
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
