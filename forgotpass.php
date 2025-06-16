<?php
require 'php/ping_test.php';
include 'constants/session_config.php';

if ($is_logged_in){
  header("Location: home.php");
} else {
  header("forgotpass.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Forgot Password</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>

  <style>
    body, html {
      height: 100%;
      margin: 0;
      background-image: url('images/shoe.avif');
      background-size: cover;
      font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
    }
                
    .forgot-box {
      background-color: rgba(255, 255, 255, 0.85);
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
      padding: 40px;
      max-width: 400px;
      margin: 8% auto;
    }

    .form-control {
      border-radius: 10px;
    }

    .form-control:focus {
        box-shadow: 0 0 5px rgba(54, 53, 53, 0.8) !important;
    }

    .btn-dark {
      width: 100%;
      border-radius: 10px;
    }

  </style>
</head>
<script>
  function disableResetButton(){
    const btn = document.getElementById("reset_btn");
    document.getElementById("login-link").style.display = "none";
    btn.disabled = true;
    btn.innerText = "Just a moment...";
    btn.style.backgroundColor = "#6c757d";
  }
</script>
<body>

  <?php require 'constants/navbar_index.php'; ?>
  <!-- --------------------------------------------------- -->
  <?php
if (isset($_GET['error'])) {
    $msg = "";
    if ($_GET['error'] == 'invalid_credentials') $msg = "Invalid Credentials. Please try again.";
    elseif ($_GET['error'] == 'wrong_security') $msg = "Incorrect security answer.";
    elseif ($_GET['error'] == 'update_failed') $msg = "Password update failed. Please try again.";
    elseif ($_GET['error'] == 'aborted') $msg = "Operation aborted. Please try again.";
    if ($msg) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">'
            . $msg .
            '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }
}
?>
<!-- --------------------------------------------------- -->
  <?php require 'loader.php'; ?>


  <div class="container">
    <div class="forgot-box">
      <h2 class="text-center mb-4">Reset your password</h2>

      <form action="auth/forgotpass_auth.php" method="POST" onsubmit="disableResetButton()">
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" class="form-control" id="username" required maxlength="12">
        </div>

        <div class="mb-3">
          <label for="security" class="form-label">Security question (Year of Birth)</label>
          <input type="password" name="security" class="form-control" id="security" required maxlength="4">
        </div>

        <button type="submit" class="btn btn-dark" id="reset_btn">Reset Password</button>

        <div class="mt-3 text-center">
          <a href="login.php" id="login-link" style="text-decoration: none; color: rgb(121, 137, 137);">Go back</a>
        </div>
      </form>
    </div>
  </div>

  <?php require 'constants/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
