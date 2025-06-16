<?php
require 'php/ping_test.php';
include 'constants/session_config.php';
if (!$is_logged_in){
    header("Location: login.php");
    exit;
}

include("../auth/database.php");
$conn = mysqli_connect($host, $username, $password, "shoeswap");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user = $_SESSION['s_user'];

// Fetch user details from database
$sql = "SELECT * FROM seller WHERE USERNAME = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $user);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if ($row['GOVT_ID_TYPE'] === '' || $row['ID_NUMBER'] === '' ||
$row['FNAME'] === '' || $row['LNAME'] === '' ||
$row['USERNAME'] === '' || $row['EMAIL_ID'] === '' || $row['SECURITY_QUES'] === '' ||
$row['ADDRESS'] === '' || $row['CITY'] === '' ||
$row['PIN'] === '' || $row['PHONE_NUMBER'] === ''){
  echo "<script>alert('Please complete your seller profile or verify your identity by uploading a valid government-issued ID before listing your product or viewing your order!'); window.location.replace('homepage_seller.php');</script>";
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Step Up Your Style</title>
    <link rel="icon" href="images\webisite_logo.png" type="image/x">

  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    body {
        background-image: url('images/shoe.avif'); 
        background-size:cover;
        
        min-height: 100vh;
        
    }
    .category-img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      transition: transform 0.2s ease;
    }

    .category-img:hover {
      transform: scale(1.05);
    }

    .category-label {
      margin-top: 10px;
      font-weight: 600;
    }

    .card {
      max-width: 700px;
    }
  </style>
</head>
<body class="bg-light">

<?php include('static/navbar.php'); ?>


  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="card shadow-lg text-center p-4">
      <h2 class="mb-4">Sell Your Shoes</h2>
      <p class="text-muted mb-4">Choose a category</p>

      <div class="row justify-content-center">
        <!-- Men -->
        <div class="col-4">
          <a href="apply.php" onclick="male()" class="text-decoration-none text-dark">
            <img src="images/man.jpg" alt="Men" class="category-img">
            <div class="category-label">Men</div>
          </a>
        </div>
        <!-- Women -->
        <div class="col-4">
          <a href="apply.php" onclick="female()" class="text-decoration-none text-dark">
            <img src="images/woman.jpg" alt="Women" class="category-img">
            <div class="category-label">Women</div>
          </a>
        </div>
        <!-- Kids -->
        <div class="col-4">
          <a href="apply.php" onclick="kid()" class="text-decoration-none text-dark">
            <img src="images/kids.jpg" alt="Kids" class="category-img">
            <div class="category-label">Kids</div>
          </a>
        </div>
      </div>
    </div>
  </div>
  <?php include('static/footer.php'); ?>

  <!-- Bootstrap 5 JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/choice_gender.js"></script>
</body>
</html>
