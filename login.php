<?php
require 'php/ping_test.php';
include 'constants/session_config.php';
if ($is_logged_in){
  header("Location: home.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    body, html {
      height: 100%;
      margin: 0;
      background-image: url('images/shoe.avif');
      background-size: cover;
      font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
    }

    .login-box {
      background-color: rgba(255, 255, 255, 0.85);
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
      padding: 40px;
      max-width: 400px;
      margin: auto;
      margin-top: 8%;
      margin-bottom: 7%;
      transition: transform 0.3s ease-in-out;
    }

    .login-box:hover {
      transform: scale(1.02);
    }

    .form-control {
      border-radius: 10px;
    }

    .form-control:focus {
      box-shadow: 0 0 5px rgba(54, 53, 53, 0.8) !important;
    }

    .btn-dark {
      border-radius: 10px;
      width: 100%;
    }
  </style>
</head>
<script>
function disableLoginButton() {
  const btn = document.getElementById("loginBtn");
  document.getElementById("forgot-link").style.display = "none";
  document.getElementById("register-link").style.display = "none";
  document.getElementById("register-head").style.display = "none";
  btn.disabled = true;
  btn.innerText = "Just a moment...";
  btn.style.backgroundColor = "#6c757d";
}
</script>
<body>

<?php require 'constants/navbar_index.php'; ?>

<!-- show alert if user is not registered or incorrect_password -->
<?php
$alertMessage = '';
$greetText = '';
date_default_timezone_set('Asia/Kolkata');
$hour = date('H');
$minute = date('i');

if ($hour < 12) {
    $greetText = 'Good morning!';
} elseif ($hour < 17 || ($hour == 17 && $minute <= 50)) {
    $greetText = 'Good afternoon!';
} else {
    $greetText = 'Good evening!';
}

if (isset($_GET['error'])) {
    if ($_GET['error'] === 'incorrect_password') {
        $alertMessage = "Incorrect password. Please try again.";
    } elseif ($_GET['error'] === 'user_not_found') {
        $alertMessage = "User not found. Please register first.";
    }
}
if (isset($_GET['success'])) {
  if ($_GET['success'] === 'password_reset') {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    Password updated successfully! You can now log in.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
  }
}
?>


<?php if (!empty($alertMessage)): ?>
<div class="alert alert-danger alert-dismissible fade show mt-3 mx-3" role="alert">
  <?php echo $alertMessage; ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>
<!-- ------------------------------------------------------------- -->
<?php require 'loader.php'; ?>

<div class="container">
  <div class="login-box">
        <div class="d-flex justify-content-center">
            <p><strong style="color: #212529;">Hey there, <?php echo $greetText; ?></strong></p>
        </div>
    <h2 class="text-center mb-4">Login</h2>

    <form method="POST" action="auth/login_auth.php" onsubmit="disableLoginButton()">
      <div class="mb-3">
        <label for="user-name" class="form-label">Username</label>
        <input type="text" class="form-control" id="user-name" name="user-name" required placeholder="Enter your username" maxlength="12">
      </div>

      <div class="mb-3">
        <label for="user-pass" class="form-label">Password</label>
        <input type="password" class="form-control" id="user-pass" name="user-pass" required placeholder="Enter your password">
      </div>
 
      <button type="submit" class="btn btn-dark" id="loginBtn">Login</button>

      <div class="mt-3 text-center">
        <small>
          <a href="forgotpass.php" id="forgot-link" style="text-decoration: none; color: rgb(121, 137, 137);">Forgot Password?</a>
        </small><br>
        <small id="register-head">
          Don't have an account?
          <a href="registration.php" id="register-link" style="text-decoration: none; color: rgb(121, 137, 137);">Register</a>
        </small>
      </div>
    </form>
  </div>
</div>

<?php require 'constants/footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
