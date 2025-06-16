<?php

//initiating session
require 'php/ping_test.php';
session_start();

// checking if the user has logged in or not

if ($_SESSION["status"] === "active") {

  //storing user data



  ?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
      integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">


    <title>Wishlist</title>

    <link rel="icon" href="images\icons\webisite_logo.png" type="image/x">
    <link rel="stylesheet" href="css/wishlist.css">
  </head>

  <body class="bg-light">
    <!-- -------------------------------Navbar-------------------------------->
    <!-- --------------------navbar---------------------- -->
    <?php require 'constants/navbar_other.php'; ?>
    <!-- --------------------navbar---------------------- -->
    <div class="d-flex justify-content-center my-4 px-4">
      <div class="card wishlist-card bg-light shadow-sm"
        style="border-left: 2px solid #ccc; max-width: 500px; width: 100%;">
        <div class="card-body d-flex justify-content-between align-items-center">
          <h2 class="card-title fw-bold mb-0">Wishlist</h2>
          <i class="bi bi-heart fs-4 text-danger" style="cursor: pointer;" title="Add to Wishlist"></i>
        </div>
      </div>
    </div>




    <!-- -------------------------------Body-------------------------------->

    <?php
    // Connect to MySQL database
    include('auth/database.php');

    // Retrieve shoe data from database
    $sql = "SELECT s.id, s.brand, s.type, s.selling_price, s.image_url, s.purchase_price
        FROM wishlist w
        JOIN shoes s ON w.shoes_id = s.id
        WHERE w.user = '{$_SESSION['username']}'";

    $result = $conn->query($sql);
    ?>

    <div class="container">
      <div class="row">
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <?php
            $percentageDifference = (($row['purchase_price'] - $row['selling_price']) / $row['purchase_price']) * 100;
            ?>
            <div class="col-lg-3 col-md-4 mb-3">
              <a href="product_page.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark">
                <div class="product-box">
                  <div class="product-inner-box position-relative">

                    <!-- Icons -->
                    <div class="icons position-absolute d-flex gap-2">
                      <!-- View Product -->
                      <form action="product_page.php" method="get">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                        <button type="submit" class="btn btn-light rounded-pill text-dark">
                          <img src="images/icons/eye.png" width="15px" alt="View">
                        </button>
                      </form>

                      <!-- Remove from Wishlist -->
                      <form action="php/del_wishlist.php" method="post">
                        <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                        <button type="submit" class="btn btn-light rounded-pill text-dark">
                          <img src="images/icons/bin.png" width="15px" alt="Delete">
                        </button>
                      </form>
                    </div>

                    <!-- Sale Badge -->
                    <div class="position-absolute top-0 start-0 m-2">
                    <span class="badge bg-danger text-white rounded-pill px-3 py-2">
                      <?= round($percentageDifference); ?>% OFF
                    </span>
                  </div>


                    <!-- Product Image -->
                    <img src="seller/php/<?= $row['image_url']; ?>" alt="Product Image" id="product-img"
                      class="img-fluid img-item">

                    <!-- Add to Cart -->
                    <div class="cart-btn">
                      <form action="php/add_to_order.php" method="post">
                        <input type="hidden" name="product_id" value="<?= $row['id']; ?>">
                        <button class="btn btn-light shadow-sm">Add to Cart</button>
                      </form>
                    </div>

                  </div>

                  <!-- Product Info -->
                  <div class="product info">
                    <div class="product-name">
                      <h6 class="text-muted mb-1"><?= $row['brand']; ?></h6>
                      <h5 class="card-title mb-2"><?= $row['type']; ?></h5>
                    </div>
                    <div class="product-price">
                      <span class="h6 mb-0 text-primary">₹ <?= $row['selling_price']; ?></span>
                    </div>
                  </div>

                </div>
              </a>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="text-center">
            <img src="images/no_data.jpg" class="img-fluid" alt="No Data Found">
          </div>
        <?php endif; ?>
      </div>
    </div>

    <?php $conn->close(); ?>



    <!-- -------------------------------Body-------------------------------->
    <!-- -------------------------------footer-------------------------------->

    <?php require 'constants/footer.php'; ?>
    <!-- -------------------------------footer-------------------------------->
    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
      integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
      crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
      crossorigin="anonymous"></script>



    <script src="js/wishlist.js"></script>
  </body>

  </html>



  <?php
} else {
  // if not logged then redirecting to login page
  header("Location: login.php");
  exit();

}

?>