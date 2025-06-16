<?php
require 'php/ping_test.php';
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Forgot Password</title>
    
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
  function disableResetButton(){
    const btn = document.getElementById("reset_btn");
    document.getElementById("login-link").style.display = "none";
    btn.disabled = true;
    btn.innerText = "Just a moment...";
    btn.style.backgroundColor = "#6c757d";
  }
</script>
<body>
    <?php include("static/navbar_index.php");?>
    <?php require 'loader.php'; ?>
    <!-- -------------------------------Body-------------------------------->
    <section id="login" class="py-5">
        <div class="container">
            <div class="card mx-auto shadow-lg ps-5 pe-5 p-4 m-3" style="max-width: 500px; border-radius: 10px;">
                <div class="text-center">
                    <i class="bi bi-person-circle" style="font-size:50px;"></i>
                    <h3 class="text-center m-2 mb-5">Reset Your Password</h3>
                </div>
                <form action="auth/forgotpass_auth.php" method="POST" onsubmit="disableResetButton()">
                    <div class="mb-3">
                        <input type="text" name="username" id="username" class="form-control" placeholder="Username" autocomplete="off" required maxlength="12">
                    </div>
                    <div class="mb-3">
                        <input type="password" name="security" id="security" class="form-control" placeholder="Year-Of-Birth" autocomplete="off" required maxlength="4">
                    </div>
                    <div class="text-center">
                    <button type="submit" class="btn btn-dark" id="reset_btn">Authenticate</button>
                    </div>
                    <div class="mt-3 text-center">
                    <a href="login.php" id="login-link" style="text-decoration: none; color: rgb(121, 137, 137);">Go back</a>
                    </div>
                </form>
            </div>
        </div>
    </section>



    <!-- -------------------------------Body-------------------------------->
    <!-- -------------------------------footer-------------------------------->
    <?php include("static/footer.php");?>
</body>
</html>