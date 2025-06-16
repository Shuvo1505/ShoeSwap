<?php
require 'php/ping_test.php';
include('auth/database.php');
include('constants/session_config.php');
if ($is_logged_in){
if (isset($_GET['id'])) {
  $product_id = $_GET['id'];
  $query = "SELECT * FROM shoes WHERE id = ?";
  $stmt = $conn->prepare($query);
  $stmt->bind_param("i", $product_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    ?><!DOCTYPE html>
    <html lang="en">

    <head>
      <meta charset="UTF-8" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <title><?php echo $row['brand'] ?></title>
      <link rel="icon" href="images\icons\webisite_logo.png" type="image/x">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
      <style>
        .product-image {
          max-height: 400px;
          object-fit: cover;
          width: 100%;
          /* Let Bootstrap manage the width */
        }

        .thumbnail {
          width: 80px;
          height: 80px;
          object-fit: cover;
          cursor: pointer;
          opacity: 0.6;
          transition: opacity 0.3s ease;
        }

        .thumbnail:hover,
        .thumbnail.active {
          opacity: 1;
        }

        .thumbnail-container {
          /* display: flex; */
          gap: 10px;
          flex-wrap: wrap;
        }

        .size-selector {
          max-width: 600px;
          margin: 20px auto;
          font-family: Arial, sans-serif;
          background-color: #f9f9f9;
          padding: 15px;
          border-radius: 8px;
          box-shadow: 0 0 5px rgba(0, 0, 0, 0.1);
        }

        .size-selector h3 {
          margin-bottom: 10px;
        }

        .sizes-grid {
          display: grid;
          grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
          gap: 10px;
        }

        .size-box {
          border: 1px solid #ccc;
          border-radius: 6px;
          padding: 10px;
          text-align: center;
          font-weight: bold;
          background-color: white;
          cursor: pointer;
          transition: 0.2s ease;
        }

        .size-box span {
          display: block;
          font-weight: normal;
          color: #555;
          margin-top: 5px;
        }

        .size-box:hover {
          border-color: black;
        }

        .size-box.selected {
          background-color: black;
          color: white;
          border: 2px solid black;
        }

        .size-box.selected span {
          color: white;
        }


        .size-guide {
          margin-top: 10px;
          font-size: 13px;
          color: gray;
          text-align: right;
          cursor: pointer;
        }
      </style>
    </head>

    <body>

      <?php require 'constants/navbar_other.php'; ?>

      <div class="container mt-5">
        <div class="row">
          <!-- Sticky Image Section -->
          <div class="left-cont col-lg-6 mb-4">
            <div style="position: -webkit-sticky; position: sticky; top: 100px;">
              <img src="seller/php/<?php echo $row['image_url']; ?>" alt="Product"
                class="img-fluid rounded mb-3 product-image" id="mainImage" />

              <div class="d-flex gap-3 flex-wrap">
                <img src="seller/php/<?php echo $row['image_url']; ?>" alt="Thumbnail 1" class="thumbnail rounded active"
                  onclick="changeImage(event, this.src)" />

                <img src="seller/php/<?php echo $row['image_url_f']; ?>" alt="Thumbnail 2" class="thumbnail rounded"
                  onclick="changeImage(event, this.src)" />

                <img src="seller/php/<?php echo $row['image_url_s']; ?>" alt="Thumbnail 3" class="thumbnail rounded"
                  onclick="changeImage(event, this.src)" />


              </div>
            </div>
          </div>



          <!-- Product Details -->
          <div class="right-cont col-md-6" style="margin-top: 1px;">
            <h2 class="mb-3"><?php echo $row["brand"]; ?></h2>
            <p class="text-muted mb-4">Type: <?php echo $row["type"]; ?></p>
            <div class="mb-3">
              <span class="h4 me-2">₹<?php echo $row["selling_price"]; ?></span>
              <span class="text-muted"><s>₹<?php echo $row["purchase_price"]; ?></s></span>
            </div>
            <?php
            // Step 1: Get seller_name for the given shoe
            $sellerQuery = "SELECT seller_name FROM shoes WHERE id = '" . $row["id"] . "'";
            $sellerResult = $conn->query($sellerQuery);

            if ($sellerResult && $sellerResult->num_rows > 0) {
              $sellerName = $sellerResult->fetch_assoc()['seller_name'];

              // Step 2: Get sellerId from seller table
              $idQuery = "SELECT sellerId FROM seller WHERE username = '$sellerName'";
              $idResult = $conn->query($idQuery);

              if ($idResult && $idResult->num_rows > 0) {
                $sellerId = $idResult->fetch_assoc()['sellerId'];

                // Step 3: Get average rating and review count
                $reviewQuery = "SELECT AVG(rating) AS avg_rating, COUNT(*) AS total_reviews 
                        FROM comment 
                        WHERE sellerId = $sellerId";
                $reviewResult = $conn->query($reviewQuery);

                if ($reviewResult && $reviewResult->num_rows > 0) {
                  $reviewData = $reviewResult->fetch_assoc();
                  $avgRating = isset($reviewData['avg_rating']) ? round($reviewData['avg_rating'], 1) : 0; // Ensure it's set
                  $totalReviews = $reviewData['total_reviews'] ?? 0; // Default to 0 if no reviews
        
                  // Step 4: Generate star HTML
                  $fullStars = floor($avgRating);
                  $halfStar = ($avgRating - $fullStars) >= 0.5 ? 1 : 0;
                  $emptyStars = 5 - $fullStars - $halfStar;

                  echo '<div class="mb-3">';
                  for ($i = 0; $i < $fullStars; $i++) {
                    echo '<i class="bi bi-star-fill text-warning"></i>';
                  }
                  if ($halfStar) {
                    echo '<i class="bi bi-star-half text-warning"></i>';
                  }
                  for ($i = 0; $i < $emptyStars; $i++) {
                    echo '<i class="bi bi-star text-warning"></i>';
                  }
                  echo '<span class="ms-2">' . $avgRating . ' (' . $totalReviews . ' reviews)</span>';
                  echo '</div>';
                } else {
                  echo '<div class="mb-3"><span>No reviews yet</span></div>';
                }
              } else {
                echo '<div class="mb-3"><span>Seller not found</span></div>';
              }
            } else {
              echo '<div class="mb-3"><span>Product not found</span></div>';
            }
            ?>




            <!-- ---------------------------------- -->




            <!-------------------------------------------------------------------------------->



            <div class="d-flex flex-wrap gap-2 mt-2">
              <form action="php/add_to_order.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="btn btn-primary mb-2">
                  <i class="bi bi-cart-plus"></i> Add to Cart
                </button>
              </form>

              <form action="php/add_to_wishlist.php" method="post">
                <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="btn btn-outline-secondary mb-2">
                  <i class="bi bi-heart"></i> Add to Wishlist
                </button>
              </form>
            </div>
<br>
            <div class="mt-4">
              <h5>Key Features:</h5>
              <ul>
                <li><?php echo "<Strong>Size : </Strong>" . $row['size']; ?></li>
                <li><?php echo "<Strong>Gender : </Strong>" . $row['gender']; ?></li>
                <li><?php echo "<Strong>Category : </Strong>" . $row['category']; ?></li>
                <li><?php echo "<Strong>Shoe Usage : </Strong>" . $row['shoe_usage']; ?></li>
              </ul>
            </div>
            <div class="mt-4">
              <p><?php echo $row['description']; ?></p>
            </div>
          </div>
        </div>
        <?php
        $seller_name = $row['seller_name'];
        // Get seller_id from current product
    
        // Fetch seller reviews
        $review_query = "SELECT c.*, u.FNAME, u.LNAME, u.username
                 FROM comment c 
                 JOIN user u ON c.userId = u.userId 
                 WHERE c.sellerId = (SELECT sellerId FROM seller WHERE username = '$seller_name')";

        $review_result = mysqli_query($conn, $review_query);
        ?>

        <div class="mt-5">
          <h4>Seller Reviews</h4>
          <?php if (mysqli_num_rows($review_result) > 0): ?>
            <?php while ($review = mysqli_fetch_assoc($review_result)): ?>
              <div class="border rounded p-3 mb-3">
                <strong>
                  <?php
                  echo htmlspecialchars($review['FNAME'] . ' ' . $review['LNAME']);
                  ?>
                </strong>

                <?php echo ' [ @' . htmlspecialchars($review['username']) . ' ]' ?>
                <!-- Star Rating Display -->
                <div class="mt-1 mb-2">
                  <?php
                  $rating = round($review['rating'], 1);
                  $fullStars = floor($rating);
                  $halfStar = ($rating - $fullStars) >= 0.5 ? 1 : 0;
                  $emptyStars = 5 - $fullStars - $halfStar;

                  for ($i = 0; $i < $fullStars; $i++) {
                    echo '<i class="bi bi-star-fill text-warning"></i>';
                  }
                  if ($halfStar) {
                    echo '<i class="bi bi-star-half text-warning"></i>';
                  }
                  for ($i = 0; $i < $emptyStars; $i++) {
                    echo '<i class="bi bi-star text-warning"></i>';
                  }
                  echo '<span class="ms-2">' . $rating . '</span>';
                  ?>
                </div>


                <p class="mb-1"><?php echo nl2br(htmlspecialchars($review['comment'])); ?></p>
                <small class="text-muted"><?php echo $review['created_at']; ?></small>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <p>No reviews for this seller yet.</p>
          <?php endif; ?>
        </div>

      </div>

      <?php
  } else {
    echo "<script>alert('Product not found!');window.location.replace('home.php');</script>";
  }
} else {
  echo "<script>alert('Invalid product ID!');window.location.replace('home.php');</script>";
  }
} else {
  header("Location: login.php");
  exit;
}
?>

  <script>
    function changeImage(event, src) {
      document.getElementById('mainImage').src = src;
      document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
      event.target.classList.add('active');
    }
  </script>
  <?php
  // require 'php/shoe.php'; 
  ?>
  <?php require 'constants/footer.php'; ?>


</body>

</html>