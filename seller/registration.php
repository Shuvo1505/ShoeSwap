<?php
require 'php/ping_test.php';
session_start();
if (isset($_SESSION["seller_username"])){
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
            integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
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
<Script>
function disableRegisterButton() {
  const btn = document.getElementById("signup_btn");
  document.getElementById("login-link").style.display = "none";
  btn.disabled = true;
  btn.innerText = "Just a moment...";
  btn.style.backgroundColor = "#6c757d";
}
</Script>
<body>
    <?php include('static/navbar_index.php') ?>
    <?php include('loader.php') ?>
    <!-- -------------------------------Body-------------------------------->
    <section id="login" class="py-5">
    <div class="container">
        <div class="card mx-auto shadow-lg" style="max-width: 550px; border-radius: 25px;">
            <!-- Card Header -->
            <div class="card-header text-center bg-white border-0">
                <i class="bi bi-person-circle" style="font-size: 60px;"></i>
                <h3 class="mt-1 mb-0">Seller Registration</h3>
            </div>

            <!-- Card Body with Form -->
            <div class="card-body p-5 pb-2 pt-3">
                <form action="auth/regis_auth.php" method="POST" onsubmit="disableRegisterButton()">
                    <div class="mb-3">
                        <input type="email" name="user-email" id="user-email" class="form-control" placeholder="Email" autocomplete="on" required maxlength="50">
                    </div>
                    <div class="mb-3">
                        <input type="text" name="user-name" id="user-name" class="form-control" placeholder="Username" autocomplete="on" required maxlength="12">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="user-pass" id="user-pass" class="form-control" placeholder="Password" autocomplete="off" required>
                    </div>
                    <div class="mb-3">
                        <input type="password" name="user-pass-confirm" id="user-pass-confirm" class="form-control" placeholder="Re-Enter Password" autocomplete="off" required>
                    </div>
                    <div class="mb-4">
                        <input type="text" name="security-ques" id="security-ques" class="form-control" placeholder="Security Question [Year of Birth]" autocomplete="on" required maxlength="4">
                    </div>
                    <div class="text-center">
                    <button type="submit" class="btn btn-dark" id="signup_btn">Create Account</button>
                    </div>
                </form>
            </div>

            <!-- Card Footer with Links -->
            <div class="card-footer bg-white border-0 d-flex flex-column align-items-center ">
                <a href="login.php" class="text-decoration-none text-dark mb-3" id="login-link">Already Registered? Sign in</a>
            </div>
        </div>
    </div>
</section>



    <!-- -------------------------------Body-------------------------------->
    <!-- -------------------------------footer-------------------------------->
    <?php include('static/footer.php') ?>


</body>
</html>