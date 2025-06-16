<?php
require 'php/ping_test.php';
include 'constants/session_config.php';
if (!$is_logged_in){
    header("Location: login.php");
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
    
    <script src="js/apply.js"></script>
</head>
<style>
    body {
        background-image: url('images/shoe.avif');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        min-height: 100vh;
    }
    .form-card {
    background-color: rgba(255, 255, 255, 0.95); /* White with slight transparency */
    border-radius: 15px;
    padding: 30px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}
</style>
<script>
<?php
echo "
function blockInputs(){
    const e14 = document.getElementById('submit_btn');
    e14.disabled = true;

    e14.innerText = 'Uploading...';
    e14.style.backgroundColor = '#6c757d';
}
";
?>
</script>
<body>
    <!-- -------------------------------Navbar-------------------------------->
    <?php include('static/navbar.php'); ?>
<!-- -----------------------body-------------------- -->
    <div class="container my-5 form-section">
    <div class="form-card shadow-lg p-5 border rounded">
      <h2 class="text-center">Upload Product Details</h2>
      <form id="data-form" enctype="multipart/form-data" action="php/item_upload.php" method="POST" onsubmit="blockInputs()">
        
        <div class="mb-3">
          <label for="gender" class="form-label">Gender</label>
          <input type="text" id="gender" name="gender" class="form-control" readonly required>
        </div>

        <div class="mb-3">
          <label for="brand-name" class="form-label">Brand Name</label>
          <select id="brand-name" name="brand-name" class="form-select" required>
            <option value="" disabled selected>Select</option>
            <option>Nike</option>
            <option>Adidas</option>
            <option>Reebok</option>
            <option>Gucci</option>
            <option>Air Jordan</option>
            <option>New Balance</option>
            <option>Puma</option>
            <option>Skechers</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="type" class="form-label">Type</label>
          <select id="type" name="type" class="form-select" required>
            <option value="" disabled selected>Select</option>
            <option>Sneaker</option>
            <option>Loafer</option>
            <option>Casual</option>
            <option>Brogues</option>
            <option>Sport Shoes</option>
            <option>Slippers</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="category" class="form-label">Category</label>
          <select id="category" name="category" class="form-select" required>
            <option value="" disabled selected>Select</option>
            <option>Leather</option>
            <option>Foam</option>
            <option>Canvas</option>
            <option>Suede</option>
            <option>Cons</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="shoe-size" class="form-label">Shoe Size</label>
          <select id="shoe-size" name="shoe-size" class="form-select" required>
            <option value="" disabled selected>Select</option>
            <option>US-1</option>
            <option>US-2</option>
            <option>US-3</option>
            <option>US-4</option>
            <option>US-5</option>
            <option>US-6</option>
            <option>US-7</option>
            <option>US-8</option>
            <option>US-9</option>
            <option>US-10</option>
            <option>US-11</option>
            <option>US-12</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="usage" class="form-label">Usage Time</label>
          <select id="usage" name="usage" class="form-select" required>
            <option value="" disabled selected>Select</option>
            <option>Less than 1 month</option>
            <option>1-3 months</option>
            <option>3-6 months</option>
            <option>6-9 months</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="pur_price" class="form-label">Purchase Price (₹)</label>
          <input type="text" id="pur_price" name="pur_price" class="form-control" required maxlength="10">
        </div>

        <div class="mb-3">
          <label for="sell_price" class="form-label">Selling Price (₹)</label>
          <input type="text" id="sell_price" name="sell_price" class="form-control" required maxlength="10">
        </div>

        <div class="mb-3">
          <label for="desc" class="form-label">Description</label>
          <textarea class="form-control" id="desc" name="desc" rows="3" maxlength="255"></textarea>
        </div>

        <div class="mb-3">
          <label for="main_image" class="form-label">Main Image</label>
          <input type="file" id="main_image" name="main_image" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
          <label for="first_image" class="form-label">Image First</label>
          <input type="file" id="first_image" name="first_image" class="form-control" accept="image/*" required>
        </div>

        <div class="mb-3">
          <label for="second_image" class="form-label">Image Second</label>
          <input type="file" id="second_image" name="second_image" class="form-control" accept="image/*" required>
        </div>

        <div class="text-center">
          <button type="submit" id="submit_btn" class="btn btn-dark px-5">Upload</button>
        </div>
      </form>
    </div>
  </div>
    <!-- -----------------------body-------------------- -->

    <!-- -------------------------------footer-------------------------------->
    <?php include('static/footer.php'); ?>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/choice_gender.js"></script>
</body>

</html>