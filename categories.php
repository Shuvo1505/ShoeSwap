<?php
require 'php/ping_test.php';
session_start();

if ($_SESSION["status"] === "active"){
  include('auth/database.php');
if (isset($_GET['brand'])) {
  $brand = $_GET['brand'];

  // Sanitize brand name (optional but recommended)
  $brand = mysqli_real_escape_string($conn, $brand);

  // Filter query
  $query = "SELECT * FROM shoes WHERE brand = '$brand'";
} else {
  // Default: show all products
  $query = "SELECT * FROM shoes";
}

$result = mysqli_query($conn, $query);
// Now display products as usual...
} else {
  header("Location: login.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $brand ?></title>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,700&display=swap" rel="stylesheet">
  <!--Swiperjs Link -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!--BootStrap Link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <title>Step Up Your Style</title>

  <link rel="icon" href="images\icons\webisite_logo.png" type="image/x">
  <link rel="stylesheet" href="css/wishlist.css">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
  <?php
  include('constants/navbar_other.php');
  ?>
  <div class="p-4 m-4 border rounded shadow-sm">
    <h4 class="border-start border-4 border-primary rounded ps-3 py-2 px-3  mb-0" style="color: #213555">
      <?php echo $brand ?>
    </h4>
  </div>

  <!-- Filter Box -->
  <div class="p-4 m-4 border rounded shadow-sm mb-5">
    <form id="filterForm">
      <div class="row">
        <!-- Type Filter -->
        <div class="col-md-2">
          <label for="type">Type</label>
          <select class="form-select" id="type" name="type">
            <option value="">All Types</option>
            <!-- PHP to fetch options -->
            <?php
            $query = "SELECT DISTINCT type FROM shoes WHERE brand = '$brand'";
            $result_types = $conn->query($query);
            while ($row = $result_types->fetch_assoc()) {
              echo "<option value='" . $row['type'] . "'>" . $row['type'] . "</option>";
            }
            ?>
          </select>
        </div>

        <!-- Category Filter -->
        <div class="col-md-2">
          <label for="category">Category</label>
          <select class="form-select" id="category" name="category">
            <option value="">All Categories</option>
            <!-- PHP to fetch options -->
            <?php
            $query = "SELECT DISTINCT category FROM shoes WHERE brand = '$brand'";
            $result_category = $conn->query($query);
            while ($row = $result_category->fetch_assoc()) {
              echo "<option value='" . $row['category'] . "'>" . $row['category'] . "</option>";
            }
            ?>
          </select>
        </div>

        <!-- Shoe Usage Filter -->
        <div class="col-md-2">
          <label for="shoe_usage">Shoe Usage</label>
          <select class="form-select" id="shoe_usage" name="shoe_usage">
            <option value="">All Uses</option>
            <!-- PHP to fetch options -->
            <?php
            $query = "SELECT DISTINCT shoe_usage FROM shoes WHERE brand = '$brand'";
            $result_usage = $conn->query($query);
            while ($row = $result_usage->fetch_assoc()) {
              echo "<option value='" . $row['shoe_usage'] . "'>" . $row['shoe_usage'] . "</option>";
            }
            ?>
          </select>
        </div>

        <!-- Size Filter -->
        <div class="col-md-2">
          <label for="size">Size</label>
          <select class="form-select" id="size" name="size">
            <option value="">All Sizes</option>
            <!-- PHP to fetch options -->
            <?php
            $query = "SELECT DISTINCT size FROM shoes WHERE brand = '$brand'";
            $result_size = $conn->query($query);
            while ($row = $result_size->fetch_assoc()) {
              echo "<option value='" . $row['size'] . "'>" . $row['size'] . "</option>";
            }
            ?>
          </select>
        </div>

        <!-- Gender Filter -->
        <div class="col-md-2">
          <label for="gender">Gender</label>
          <select class="form-select" id="gender" name="gender">
            <option value="">All Genders</option>
            <!-- PHP to fetch options -->
            <?php
            $query = "SELECT DISTINCT gender FROM shoes WHERE brand = '$brand'";
            $result_gender = $conn->query($query);
            while ($row = $result_gender->fetch_assoc()) {
              echo "<option value='" . $row['gender'] . "'>" . $row['gender'] . "</option>";
            }
            ?>
          </select>
        </div>

        <!-- Price Filter -->
        <div class="col-md-2">
          <label for="price">Price</label>
          <select class="form-select" id="price" name="price">
            <option value="">All Prices</option>
            <option value="0-1000">₹0 - ₹1000</option>
            <option value="1000-3000">₹1000 - ₹3000</option>
            <option value="3000-9000">₹3000 - ₹9000</option>
            <option value="9000+">₹9000+</option>
          </select>
        </div>
      </div>
    </form>
  </div>


  <div class="container py-5">
    <div class="row">
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <?php
          $percentageDifference = (($row['purchase_price'] - $row['selling_price']) / $row['purchase_price']) * 100;
          ?>
          <div class="col-lg-3 col-md-4 mb-3 product-card" data-type="<?php echo $row['type']; ?>"
            data-category="<?php echo $row['category']; ?>" data-shoe_usage="<?php echo $row['shoe_usage']; ?>"
            data-size="<?php echo $row['size']; ?>" data-gender="<?php echo $row['gender']; ?>"
            data-price="<?php echo $row['selling_price']; ?>">
            <a href="product_page.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark">
              <div class="product-box">
                <div class="product-inner-box position-relative">

                  <div class="icons position-absolute d-flex gap-2">
                    <form action="php/add_to_wishlist.php" method="post">
                      <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                      <button type="submit" class="btn btn-light rounded-pill text-danger">
                        <img src="images/icons/heart.png" width="15px" alt="Wishlist">
                      </button>
                    </form>


                    <form action="php/del_wishlist.php" method="post">
                      <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                      <button type="submit" class="btn btn-light rounded-pill text-dark">
                        <img src="images/icons/bin.png" width="15px" alt="Delete">
                      </button>
                    </form>
                  </div>

                  <div class="position-absolute top-0 start-0 m-2">
                    <span class="badge bg-danger text-white rounded-pill px-3 py-2">
                      <?= round($percentageDifference, 2); ?>% OFF
                    </span>
                  </div>


                  <img src="seller/php/<?php echo $row['image_url']; ?>" alt="" id="product-img" class="img-fluid img-item">

                  <div class="cart-btn">
                    <form action="php/add_to_order.php" method="post">
                      <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                      <button class="btn btn-light shadow-sm">Add to Cart</button>
                    </form>
                  </div>

                </div>

                <div class="product info">
                  <div class="product-name">
                    <h6 class="text-muted mb-1"><?php echo $row['brand']; ?></h6>
                    <h5 class="card-title mb-2"><?php echo $row['type']; ?></h5>
                  </div>
                  <div class="product-price">
                    <span class="h6 mb-0 text-primary">₹ <?php echo $row['selling_price']; ?></span>
                  </div>
                </div>
              </div>
            </a>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <img src="images/no_data.jpg" class="img-fluid">
      <?php endif; ?>
    </div>
  </div>

  <?php require 'constants/footer.php'; ?>
  <script src="js/categories.js"></script>
  <script>

  </script>

</body>

</html>