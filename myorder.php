<?php
//initiating session
require 'php/ping_test.php';
session_start();

// checking if the user has logged in or not

if ($_SESSION["status"] === "active") {

    //storing user data


    // Calculate total price and offer price of selected items
    include('auth/database.php');


    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">




        <title>Step Up Your Style</title>

        <link rel="icon" href="images\icons\webisite_logo.png" type="image/x">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link rel="stylesheet" href="css/cart.css">

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('[id^="star-rating-"]').forEach(starContainer => {
                    const stars = starContainer.querySelectorAll('i');
                    const inputId = 'rating-' + starContainer.id.split('-')[2];
                    const ratingInput = document.getElementById(inputId);

                    stars.forEach(star => {
                        star.addEventListener('click', () => {
                            const rating = parseInt(star.getAttribute('data-value'));
                            ratingInput.value = rating;

                            stars.forEach((s, i) => {
                                if (i < rating) {
                                    s.classList.add('bi-star-fill');
                                    s.classList.remove('bi-star');
                                } else {
                                    s.classList.remove('bi-star-fill');
                                    s.classList.add('bi-star');
                                }
                            });
                        });
                    });
                });
            });
        </script>

    </head>

    <body>
    <?php include('constants/navbar_other.php'); ?>

        <div class="d-flex justify-content-center my-4 px-4">
            <div class="card wishlist-card bg-light shadow-sm"
                style="border-left: 2px solid #ccc; max-width: 500px; width: 100%;">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <h2 class="card-title fw-bold mb-0">My Orders</h2>
                    <i class="bi bi-bag-check fs-4 text-primary" style="cursor: pointer;" title="My Orders"></i>
                </div>
            </div>
        </div>
        <!-- -------------------------------Body-------------------------------->
        <section style="background-color: #eee;">
            <div class="container py-5">
                <?php

                // Retrieve shoe data from database
                $sql = "SELECT s.id ,s.type,s.shoe_usage,s.category,s.description,s.gender,s.size, s.brand, s.selling_price, s.image_url,s.purchase_price,o.order_id,o.created_date
                FROM `order` o
                JOIN shoes s ON o.shoes_id = s.id
                WHERE o.user ='{$_SESSION['username']}'";
                $result = $conn->query($sql);

                echo "<div class='container'>";

                // Check if there are any rows returned
                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <div class="row justify-content-center mb-3">
                            <div class="col-md-12 col-xl-10">
                                <div class="card shadow-0 border rounded-3">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                                                <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                                    <img src="<?php echo "seller/php/" . $row["image_url"] . ""; ?>"
                                                        class="w-100" />
                                                    <a href="#!">
                                                        <div class="hover-overlay">
                                                            <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);">
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-lg-6 col-xl-6">
                                                <h5>
                                                <small class="text-danger d-block mb-1">Order ID: <?php echo $row["order_id"]; ?></small>
                                                    <?php echo "" . $row["brand"] . " " . $row["type"] . "";?>
                                                </h5>

                                                <div class="mt-1 mb-0 text-muted small">
                                                    <span>
                                                        <?php echo "For " . $row["gender"] . ""; ?>
                                                    </span>
                                                    <span class="text-primary"> • </span>
                                                    <span>
                                                        <?php echo " " . $row["shoe_usage"] . " old"; ?>
                                                    </span>
                                                    <span class="text-primary"> • </span>
                                                    <span>
                                                        <?php echo "" . $row["category"] . ""; ?><br />
                                                    </span>
                                                </div>

                                                <p>
                                                    <?php echo "Description: " . $row["description"] . ""; ?>
                                                </p>
                                                <?php
                                                $currentDate = date("Y-m-d");
                                                $createdDate = $row['created_date'];

                                                $status = (strtotime($currentDate) > strtotime($createdDate . ' + 4 days')) ? 'Delivered' : 'Item on Way';

                                                if ($status === 'Delivered') { ?>
                                                    <button class="btn btn-outline-primary btn-sm mt-2" data-bs-toggle="modal"
                                                        data-bs-target="#reviewModal<?php echo $row['id']; ?>">
                                                        Write a review
                                                    </button>
                                                <?php } ?>
                                                <?php
                                                // Fetch previous review if exists
                                                $reviewQuery = mysqli_query($conn, "SELECT * FROM comment WHERE shoes_id = " . $row['id'] . " AND userId = '" . $_SESSION['userId'] . "'");

                                                $reviewData = mysqli_fetch_assoc($reviewQuery);
                                                $existingComment = $reviewData['comment'] ?? '';
                                                $existingRating = $reviewData['rating'] ?? '';
                                                ?>

                                                <div class="modal fade" id="reviewModal<?php echo $row['id']; ?>" tabindex="-1"
                                                    aria-labelledby="reviewModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <form action="php/review_creation.php" method="POST">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Your Review</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                        aria-label="Close"></button>
                                                                </div>

                                                                <div class="modal-body" aria-required="true">
                                                                    <div class="mb-3">
                                                                        <label for="comment" class="form-label">Comment:</label>
                                                                        <textarea class="form-control" name="comment"
                                                                            rows="3"><?php echo $existingComment; ?></textarea>
                                                                    </div>

                                                                    <div class="mb-3" aria-required="true">
                                                                        <label class="form-label">Rating:</label>
                                                                        <div id="star-rating-<?php echo $row['id']; ?>"
                                                                            class="text-warning fs-4">
                                                                            <?php for ($i = 1; $i <= 5; $i++) {
                                                                                $filled = ($i <= $existingRating) ? 'bi-star-fill' : 'bi-star';
                                                                                ?>
                                                                                <i class="bi <?php echo $filled; ?>"
                                                                                    data-value="<?php echo $i; ?>"
                                                                                    style="cursor:pointer;"></i>
                                                                            <?php } ?>
                                                                        </div>
                                                                        <input type="hidden" name="rating" required
                                                                            id="rating-<?php echo $row['id']; ?>"
                                                                            value="<?php echo $existingRating; ?>">
                                                                    </div>

                                                                    <input type="hidden" name="product_id"
                                                                        value="<?php echo $row['id']; ?>">
                                                                </div>

                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">Submit
                                                                        Review</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                                            <div class="d-flex flex-row align-items-center mb-1">
                                                    <h4 class="mb-1 me-1">
                                                        <?php 
                                                        // Format price to remove trailing zeros
                                                        $formatted_price = rtrim(rtrim($row["selling_price"], '0'), '.');
                                                        echo "₹ " . $formatted_price; 
                                                        ?>
                                                    </h4>
                                                    <span class="text-danger"><s>
                                                            <?php 
                                                            $formatted_purchase = rtrim(rtrim($row["purchase_price"], '0'), '.');
                                                            echo "₹" . $formatted_purchase; 
                                                            ?>
                                                        </s></span>
                                                </div>
                                                <h6 class="text-success">Free shipping</h6>
                                                <div class="d-flex flex-column mt-4">
                                                    <h6 class="text" style="color: #007bff" type="text">
                                                        <?php echo 'Status: '. $status; ?>
                                                    </h6>
                                                    <div style="display: flex; align-items: center;">
                                                    <form action="pdf.php" method="POST" style="margin-right: 20px;">
                                                        <input type="hidden" name="product_id" value="<?php echo $row["id"]; ?>">
                                                        <input type="hidden" name="brand" value="<?php echo $row["brand"]; ?>">
                                                        <input type="hidden" name="type" value="<?php echo $row["type"]; ?>">
                                                        <input type="hidden" name="category"
                                                            value="<?php echo $row["category"]; ?>">
                                                        <input type="hidden" name="shoe_usage"
                                                            value="<?php echo $row["shoe_usage"]; ?>">

                                                        <input type="hidden" name="gender" value="<?php echo $row["gender"]; ?>">
                                                        <input type="hidden" name="order_created"
                                                            value="<?php echo $row["created_date"]; ?>">
                                                        <input type="hidden" name="size" value="<?php echo $row["size"]; ?>">
                                                        <input type="hidden" name="purchasing_price"
                                                            value="<?php echo $row["purchase_price"]; ?>">
                                                        <input type="hidden" name="selling_price"
                                                            value="<?php echo $row["selling_price"]; ?>">
                                                        <button type="submit"
                                                            class="btn btn-outline-primary btn-sm mt-2" id="invoice-link">Invoice</button>
                                                    </form>
                                                    <?php if ($status == 'Item on Way') { ?>
                                                        <form action="send_cancel.php" method="POST" onsubmit='return confirm("This order is going to be cancelled!")'>
                                                            <input type='hidden' name='product_id'
                                                                value="<?php echo "" . $row["id"] . ""; ?>">

                                                                <input type='hidden' name='your_order_id'
                                                                value="<?php echo "" . $row["order_id"] . ""; ?>">

                                                            <button type="submit" class="btn btn-outline-danger btn-sm mt-2"
                                                                name="cancel" id="cancel-link">Cancel</button>
                                                        </form>
                                                    <?php } ?>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    echo "<img src='images/no_data.jpg' class='img-fluid'>";
                }
                echo "</div>";
                ?>
            </div>
        </section>

        <!-- -------------------------------Body-------------------------------->
        <!-- Toast Container -->
        <?php include('constants/notification.php');?>


        

        <!-- Toast JavaScript -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // var toastElement = document.querySelector('.toast');
                // if (toastElement) {
                //     var toast = new bootstrap.Toast(toastElement, {
                //         delay: 4000 // Show toast for 4 seconds
                //     });
                //     toast.show();
                // }

                // Star rating functionality
                document.querySelectorAll('[id^="star-rating-"]').forEach(function (ratingContainer) {
                    const stars = ratingContainer.querySelectorAll('i');
                    const productId = ratingContainer.id.split('-')[2];
                    const ratingInput = document.getElementById('rating-' + productId);

                    stars.forEach(function (star) {
                        star.addEventListener('click', function () {
                            const value = this.getAttribute('data-value');
                            ratingInput.value = value;

                            // Update star display
                            stars.forEach(function (s, index) {
                                if (index < value) {
                                    s.classList.remove('bi-star');
                                    s.classList.add('bi-star-fill');
                                } else {
                                    s.classList.remove('bi-star-fill');
                                    s.classList.add('bi-star');
                                }
                            });
                        });
                    });
                });
            });
        </script>

        <!-- -------------------------------footer-------------------------------->
        <?php include('constants/footer.php') ?>
        <!-- jQuery and Bootstrap Bundle (includes Popper) -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>

    </html>



    <?php
} else {
    // if not logged then redirecting to login page
    header("Location: login.php");
    exit();

}

?>