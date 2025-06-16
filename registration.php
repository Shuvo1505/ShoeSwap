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
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body,
    html {
      height: 100%;
      margin: 0;
      background-image: url('images/shoe.avif');
      background-size: cover;
      font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
    }

    .register-box {
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 15px;
      box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
      padding: 40px;
      max-width: 600px;
      margin: auto;
      margin-top: 4%;
      margin-bottom: 4%;
      transition: transform 0.3s ease-in-out;
    }

    .register-box:hover {
      transform: scale(1.01);
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
  function disableSignupButton(){
    const btn = document.getElementById("sign-up_btn");
    document.getElementById("after_register").style.display = "none";
    btn.disabled = true;
    btn.innerText = "Just a moment...";
    btn.style.backgroundColor = "#6c757d";
  }
</script>

<body>

  <?php require 'constants/navbar_index.php'; ?>
  <!-- show alert if user is not registered or incorrect_password -->
  <?php
  if (isset($_GET['error'])) {
    $error = $_GET['error'];
    $message = '';

    switch ($error) {
      case 'password_mismatch':
        $message = 'Passwords do not match.';
        break;
      case 'username_exists':
        $message = 'Username already exists.';
        break;
      case 'email_exists':
        $message = 'Email already exists.';
        break;
      case 'invalid_fname':
        $message = 'First name must only contain letters and no spaces or special characters.';
        break;
      case 'invalid_lname':
        $message = 'Last name must only contain letters and no spaces or special characters.';
        break;
      case 'invalid_pin':
        $message = 'PIN code must be exactly 6 digits.';
        break;
      case 'invalid_phone':
        $message = 'Phone number must be exactly 10 digits and cannot start with 0.';
        break;
      case 'invalid_password':
        $message = 'Password must have at least 8 characters including uppercase, lowercase, digit, and special character.';
        break;
      case 'invalid_email':
        $message = 'Invalid email format.';
        break;
      case 'registration_failed':
        $message = 'Registration failed. Please try again.';
        break;
      case 'password_weak':
        $message = 'Password must be at least 8 characters long and include at least one letter, one number, and one special character.';
        break;
        case 'username_weak':
          $message = 'Username must be at least 8 characters long and contains no spaces.';
          break;
      default:
        $message = 'An unexpected error occurred.';
    }


    echo "
    <div class='alert alert-danger alert-dismissible fade show' role='alert'>
        $message
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
  }

  if (isset($_GET['success']) && $_GET['success'] == 'registered') {
    echo "
    <div class='alert alert-success alert-dismissible fade show' role='alert'>
        Registration successful! You can now log in.
        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
    </div>";
  }
  ?>

  <!-- ------------------------------------------------------------- -->
  <?php require 'loader.php'; ?>

  <div class="container">
    <div class="register-box">
      <h2 class="text-center mb-4">Create Account</h2>

      <form action="auth/regis_auth.php" method="POST" onsubmit="disableSignupButton()">

        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="first-name" class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" id="first-name" required maxlength="15">
          </div>
          <div class="mb-3 col-md-6">
            <label for="last-name" class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" id="last-name" required maxlength="15">
          </div>
        </div>

        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <input type="text" name="username" class="form-control" id="username" required maxlength="12">
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email address</label>
          <input type="email" name="email" class="form-control" id="email" required maxlength="50">
        </div>

        <div class="row">
          <div class="mb-3 col-md-6">
            <label for="password" class="form-label">Password</label>
            <input type="password" name="password" class="form-control" id="password" required>
          </div>
          <div class="mb-3 col-md-6">
            <label for="confirm-password" class="form-label">Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" id="confirm-password" required>
          </div>
        </div>
        
        <?php require 'constants/city_states_section.php'; ?>

        <div class="mb-3">
          <label for="security" class="form-label">Security Question (Year of Birth)</label>
          <input type="text" name="security" class="form-control" id="security" required maxlength="4">
        </div>

        <button type="submit" class="btn btn-dark" id="sign-up_btn">Create Account</button>

        <div class="mt-3 text-center">
          <small id="after_register">Already have an account? <a href="login.php" id="login-link"
              style="text-decoration: none; color: rgb(121, 137, 137);">Login here</a></small>
        </div>

      </form>
    </div>
  </div>

  <?php require 'constants/footer.php'; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>