<?php
require '../php/ping_test.php';
session_start();

$err_sess_exp = $_SESSION['err_sess_exp'] ?? null;
$err_otp_exp = $_SESSION['err_otp_exp'] ?? null;
$err_bad_otp = $_SESSION['err_bad_otp'] ?? null;

if (!isset($_GET["eid"])){
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

$error = isset($_GET['eid']) ? urldecode($_GET['eid']) : "Unknown Error";
$error_text = '';

if ($error === $err_sess_exp){
    $error_text = "Session expired!";
} else if ($error === $err_otp_exp){
    $error_text = "Code expired!";
} else if ($error === $err_bad_otp){
    $error_text = "Invalid code!";
} else {
    $error_text = 'Unknown Error';
}
session_destroy();
?>

<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@4/dark.css" rel="stylesheet">
</head>
<body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
<script>
    Swal.fire({
        title: <?= json_encode($error_text) ?>,
        icon: 'error',
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Back to Login",
        allowOutsideClick: false,
        allowEscapeKey: false
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "../login.php";
        }
    });
</script>
</body>
</html>
