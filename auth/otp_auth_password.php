<?php
require '../php/ping_test.php';
include('database.php');
require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

session_start();

function isValidPassword($password) {
    $pattern = '/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&^_-]).{8,}$/';
    return preg_match($pattern, $password);
}

// DB connection
$conn = mysqli_connect($host, $username, $password, "shoeswap");
if (!$conn) die("Connection failed: " . mysqli_connect_error());

$error = "";
$showModal = false;

// OTP Verification
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["otp_input"]) && isset($_POST["newpass"])) {
    $userInput = trim($_POST["otp_input"]);
    if (!isset($_SESSION["otp"]) || !isset($_SESSION["otp_time"])) {
        //$error = "Session expired. Please login again.";
        $error = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 16);
        $_SESSION['err_sess_exp'] = $error;
        header("Location: otp_fail.php?eid=". urlencode($error));
        exit();
    } elseif ((time() - $_SESSION["otp_time"]) > 360) { //valid for 6 minutes = 360 seconds
        unset($_SESSION["otp"], $_SESSION["otp_time"]);
        //$error = "Login code expired. Please login again.";
        $error = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 16);
        $_SESSION['err_otp_exp'] = $error;
        header("Location: otp_fail.php?eid=". urlencode($error));
        exit();
    } elseif ($userInput === $_SESSION["otp"]) {
        //successfully verified OTP

        if (isValidPassword($_POST["newpass"])){
            unset($_SESSION["otp"], $_SESSION["otp_time"]);
            $hashed_password = password_hash($_POST["newpass"], PASSWORD_DEFAULT);
            $username = $_SESSION['username'];
            $update_sql = "UPDATE user SET PASSWORD = ? WHERE USERNAME = ?";
            $update_stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($update_stmt, "ss", $hashed_password, $username);
            if (mysqli_stmt_execute($update_stmt)) {
                header("Location: ../login.php?success=password_reset");
                unset($_SESSION["username"], $_SESSION['username_email']);
                exit();
            } else {
                header("Location: ../forgotpass.php?error=update_failed");
                unset($_SESSION["username"], $_SESSION['username_email']);
                exit();
            }
        } else {
            echo "<script>alert('Password must be at least 8 characters long and include at least one letter, one number, and one special character.');window.location.replace('../login.php');</script>";
            session_destroy();
            exit;
        }
    } else {
        //$error = "Invalid login code. Please try again.";
        $error = substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 16);
        $_SESSION['err_bad_otp'] = $error;
        header("Location: otp_fail.php?eid=". urlencode($error));
        exit();
    }
} else {
    // Generate and send OTP only on first load
    $otp = substr(str_shuffle("0123456789"), 0, 6);
    $_SESSION['otp'] = $otp;
    $_SESSION['otp_time'] = time();

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'system.vacation.rental@gmail.com';
        $mail->Password = 'aafiydmizxllcysy'; // App password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('system.vacation.rental@gmail.com', 'ShoeSwap');
        $mail->addAddress($_SESSION["username_email"] ?? '');

        $mail->isHTML(true);
        $mail->Subject = 'Password reset code';
        $mail->Body = '
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; color: #333; }
                            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                            .header { font-size: 24px; font-weight: bold; color: #1a73e8; margin-bottom: 20px; }
                            .content { font-size: 16px; line-height: 1.5; }
                            .otp { font-size: 20px; font-weight: bold; color: #ff6f61; }
                            .footer { font-size: 14px; color: #888; margin-top: 20px; }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="header">User Verification</div>
                            <div class="content">
                                <p>Dear User,</p>
                                <p>We have received a request to change your password. To complete the account creation process, please use the following code:</p>
                                <p class="otp">' . $otp . '</p>
                                <p>This code is valid for 6 minutes. Please do not share it with anyone.</p>
                                <p>If you did not request this, please ignore this email or contact support immediately.</p>
                            </div>
                            <div class="footer">
                                <p>Best regards,</p>
                                <p><strong>ShoeSwap Team</strong></p>
                                <p>If you have any questions, feel free to <a href="mailto:system.vacation.rental@gmail.com">contact support</a>.</p>
                            </div>
                        </div>
                    </body>
                    </html>
        ';
        $mail->send();
    } catch (Exception $e) {
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
    $showModal = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- OTP Modal -->
<div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" class="modal-content">
      <div class="modal-body">
        <label for="otp_input" class="form-label">Enter your password reset code</label>
        <input type="text" name="otp_input" class="form-control" required style="border: 2px solid  #007bff">
        <br>
        <label for="newpass" class="form-label">Enter your new password</label>
        <input type="password" name="newpass" class="form-control" id="newpass" required style="border: 2px solid  #007bff">
    </div>
      <div class="modal-footer">
      <div class="text-muted align-items-center"><strong>Note: </strong>A password reset code has been sent to your registered email address. You need to enter the reset code and new password both to reset your password.</div>
    </div>
        <button type="submit" class="btn btn-primary" style="background-color: #007bff; border-radius: 0%;">Click to Verify</button>
      </div>
    </form>
  </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
<?php if ($showModal): ?>
    const otpModal = new bootstrap.Modal(document.getElementById('otpModal'), {
        backdrop: 'static',
        keyboard: false
    });
    otpModal.show();
<?php endif; ?>
</script>
</body>
</html>
