<?php
require 'php/ping_test.php';
session_start();
    if (isset($_GET['status'])) {
        if ($_GET['status'] === 'success') {
          echo "<script>alert('Account created successfully! You can now login.');</script>";
        }
      }

include 'constants/session_config.php';
if ($is_logged_in){
    header("Location: homepage_seller.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step Up Your Style</title>

    <link rel="icon" href="images\webisite_logo.png" type="image/x">
</head>
<style> 
    body, html {
      height: 100%;
      margin: 0;
      background-size: cover;
      background-image: url('images/shoe.avif');
      font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
    }

</style>
<script>
function disableLoginButton() {
  const btn = document.getElementById("login_btn");
  document.getElementById("register-link").style.display = "none";
  document.getElementById("forgot-link").style.display = "none";
  btn.disabled = true;
  btn.innerText = "Just a moment...";
  btn.style.backgroundColor = "#6c757d";
}
</script>
<body>
    <?php include('static/navbar_index.php'); ?>
    <?php include('loader.php') ?>
    <!-- -------------------------------Body-------------------------------->
    <section id="login" class="py-5">
        <div class="card mx-auto shadow-lg" style="max-width: 500px; border-radius: 10px;">
            <div class="card-header">
                <center>
                    <i class="bi bi-person-circle fs-1"></i>
                    <h4 class="mb-0">Seller Login</h4>
                </center>
            </div>
            <div class="card-body p-5 pb-3">
                <form action="auth/login_auth.php" method="POST" onsubmit="disableLoginButton()">
                    <div class="mb-3">
                        <!-- <input type="text"  name="user-name" placeholder="Username" autocomplete="off" required> -->
                        <input type="text" name="user-name" id="user-name" class="form-control" placeholder="Username" autocomplete="on" required maxlength="12">
                    </div>
                    <div class="mb-4">
                            <input type="password" name="user-pass" id="user-pass" class="form-control" placeholder="Password" autocomplete="off" required>
                    </div>
                    <div class="text-center mb-3">
                    <button type="submit" class="btn btn-dark" id="login_btn">Login</button>
                    </div>
                    <center>
                    <p><a href="registration.php" class="text-decoration-none text-primary" id="register-link">Register</a> <br>
                    <a href="forgotpass.php" class="text-decoration-none text-primary" id="forgot-link">Forgot Password?</a></p>
                    </center>
                </form>
                
            </div>
        </div>
    </section>


    <!-- -------------------------------Body-------------------------------->
    <?php include('static/footer.php') ?>
</body>
</html>