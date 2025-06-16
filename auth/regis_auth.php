<?php
require '../php/ping_test.php';
session_start();
include('database.php');
$conn = mysqli_connect($host, $username, $password, "shoeswap");

function isValidPhoneNumber(string $phoneNumber): bool {

    // Check if all digits are the same
    if (preg_match('/^(\d)\1{9}$/', $phoneNumber) === 1) {
        return false;
    }

    // Reject known sequential patterns
    $invalidPatterns = ['1234567890', '0123456789', '1234567899','0123456788'];
    if (in_array($phoneNumber, $invalidPatterns)) {
        return false;
    }

    return true;
}

function isValidUsername($username) {
    $username = trim($username);
    return !empty($username) &&
           strpos($username, ' ') === false &&
           strlen($username) >= 8 &&
           strlen($username) <= 12;
}

function isValidPassword($password) {
    $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&^_-]).{8,}$/';
    return preg_match($pattern, $password);
}

function isValidPinCode(string $pinCode): bool {

    // Check if all digits are the same (e.g., 111111)
    if (preg_match('/^(\d)\1{5}$/', $pinCode) === 1) {
        return false;
    }

    // Reject known sequential patterns
    $invalidPatterns = ['123456', '012345'];
    if (in_array($pinCode, $invalidPatterns)) {
        return false;
    }

    return true;
}

function isValidEmail(string $email): bool {
    // Use PHP's built-in filter
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Trim input values
    $fname      = trim($_POST["first_name"]);
    $lname      = trim($_POST["last_name"]);
    $username   = trim($_POST["username"]);
    $email      = trim($_POST["email"]);
    $password   = trim($_POST["password"]);
    $confirm    = trim($_POST["confirm_password"]);
    $state      = trim($_POST["state"]);
    $city       = trim($_POST["city"]);
    $pin        = trim($_POST["pin"]);
    $phone      = trim($_POST["phone"]);
    $security   = trim($_POST["security"]);

    // Check password match
    if ($password !== $confirm) {
        header("Location: ../registration.php?error=password_mismatch");
        exit();
    }

    if (!isValidPassword($password)){
        header("Location: ../registration.php?error=password_weak");
        exit();
    }

    if (!isValidUsername($username)){
        header("Location: ../registration.php?error=username_weak");
        session_destroy();
        exit();
    }

    // check all lengths
    if (
        empty($fname) || strlen($fname) > 15 ||
        empty($lname) || strlen($lname) > 15 ||
        empty($username) || strlen($username) > 12 ||
        empty($email) || strlen($email) > 50 ||
        empty($state) || strlen($state) > 100 ||
        empty($city) || strlen($city) > 100 ||
        empty($security) || strlen($security) != 4 || !ctype_digit($security) ||
        empty($pin) || strlen($pin) != 6 || !ctype_digit($pin) ||
        empty($phone) || strlen($phone) != 10 || !ctype_digit($phone) ||
        !isValidPhoneNumber($phone) || !isValidPinCode($pin) || !isValidEmail($email)
    ) {
        header("Location: ../registration.php?error=registration_failed");
        exit();
    }    

    // Check if username or email exists
    $stmt = $conn->prepare("SELECT USERNAME, EMAIL_ID FROM user WHERE USERNAME = ? OR EMAIL_ID = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        if ($row['USERNAME'] === $username) {
            header("Location: ../registration.php?error=username_exists");
            exit();
        }
        if ($row['EMAIL_ID'] === $email) {
            header("Location: ../registration.php?error=email_exists");
            exit();
        }
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    try {
        $_SESSION["register_user"] = [
            "fname" => $fname,
            "lname" => $lname,
            "username" => $username,
            "email" => $email,
            "password" => password_hash($password, PASSWORD_DEFAULT),
            "state" => $state,
            "city" => $city,
            "pin" => $pin,
            "phone" => $phone,
            "security" => $security
        ];

        header("Location: otp_auth_register.php");
        exit();
    } catch (mysqli_sql_exception $e) {
        $error = $e->getMessage();

        // Match specific MySQL CHECK constraint errors
        if (strpos($error, 'chk_fname_alpha') !== false) {
            $errorCode = "invalid_fname";
        } elseif (strpos($error, 'chk_lname_alpha') !== false) {
            $errorCode = "invalid_lname";
        } elseif (strpos($error, 'chk_pin_format') !== false) {
            $errorCode = "invalid_pin";
        } elseif (strpos($error, 'chk_phone_format') !== false) {
            $errorCode = "invalid_phone";
        } elseif (strpos($error, 'chk_password_format') !== false) {
            $errorCode = "invalid_password";
        } elseif (strpos($error, 'chk_email_format') !== false) {
            $errorCode = "invalid_email";
        } else {
            $errorCode = "registration_failed";
        }

        header("Location: ../registration.php?error=" . $errorCode);
        exit();
    }
} else {
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
