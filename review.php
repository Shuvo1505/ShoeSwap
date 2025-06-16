<?php

//initiating session
require 'php/ping_test.php';
session_start();

// checking if the user has logged in or not

if ($_SESSION["status"] === "active") {

    //storing user data

    include("auth/database.php");
    // Calculate total price and offer price of selected items


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


        <title>Review</title>
        <link rel="stylesheet" href="css/cart.css">
        <link rel="icon" href="images/logo-round.png" type="image/x">
        <style>
            .gradient-custom {
                /* fallback for old browsers */
                background: #6a11cb;

                /* Chrome 10-25, Safari 5.1-6 */
                background: -webkit-linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1));

                /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
                background: linear-gradient(to right, rgba(106, 17, 203, 1), rgba(37, 117, 252, 1))
            }
        </style>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

    </head>

    <body>

        <!-- -------------------------------Navbar-------------------------------->
        <?php include('constants/navbar.php') ?>
        <!-- --------------------navbar---------------------- -->

        <div class="p-4 m-4 border rounded shadow-sm">
            <h4 class="border-start border-4 border-primary rounded ps-3 py-2 px-3  mb-0" style="color: #213555">
                Post Review for Seller
            </h4>
        </div>

        <!-- -------------------------------Body-------------------------------->
        <?php
        if (isset($_POST['Review'])) {
            // Check if the form is submitted
    
            // Retrieve the value of product_id
    
            $_SESSION['product_id'] = $_POST['product_id'];

            // You can now use the $product_id variable for further processing or database operations
    
        }
        ?>


        <section style="background-color: #eee;">
            <div class="container my-5 py-5">
                <div class="alert alert-success" role="alert">
                    We protect Seller's Privacy, hence You are Seeing Review of Seller you bought from.
                </div>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-12 ">
                        <div class="card">


                            <div class="card-footer py-3 border-0" style="background-color: #f8f9fa;">
                                <form action="php/review_creation.php" method="POST">
                                    <!-- Add the form element with the appropriate action and method attributes -->
                                    <div class="d-flex flex-start w-100">
                                        <img class="rounded-circle shadow-1-strong me-3" src="images/user.png" alt="avatar"
                                            width="40" height="40" />
                                        <div class="form-outline w-100">
                                            <textarea class="form-control" name="comment" id="textAreaExample" rows="4"
                                                style="background: #fff;"></textarea>
                                            <label class="form-label" for="textAreaExample">Message</label>
                                        </div>
                                    </div>
                                    <!-- Star Rating Section -->
                                    <div class="mb-3">
                                        <label class="form-label">Your Rating:</label>
                                        <div id="star-rating" class="text-warning fs-4">
                                            <i class="bi bi-star" data-value="1"></i>
                                            <i class="bi bi-star" data-value="2"></i>
                                            <i class="bi bi-star" data-value="3"></i>
                                            <i class="bi bi-star" data-value="4"></i>
                                            <i class="bi bi-star" data-value="5"></i>
                                        </div>
                                        <input type="hidden" name="rating" id="rating" value="">
                                    </div>

                                    <div class="float-end mt-2 pt-1">
                                        <input type="hidden" name="product_id"
                                            value="<?php echo $_SESSION['product_id']; ?>">
                                        <button type="submit" class="btn btn-primary btn-sm" name="submit_comment">Post
                                            comment</button>
                                        <button type="button" class="btn btn-outline-primary btn-sm"
                                            onclick="clearTextArea()">Cancel</button>
                                    </div>
                                </form>
                                <script>
                                    const stars = document.querySelectorAll('#star-rating i');
                                    const ratingInput = document.getElementById('rating');

                                    stars.forEach(star => {
                                        star.addEventListener('click', () => {
                                            const rating = star.getAttribute('data-value');
                                            ratingInput.value = rating;

                                            stars.forEach(s => {
                                                s.classList.remove('bi-star-fill');
                                                s.classList.add('bi-star');
                                            });

                                            for (let i = 0; i < rating; i++) {
                                                stars[i].classList.remove('bi-star');
                                                stars[i].classList.add('bi-star-fill');
                                            }
                                        });
                                    });

                                    function clearTextArea() {
                                        document.getElementById('textAreaExample').value = '';
                                        ratingInput.value = '';
                                        stars.forEach(star => {
                                            star.classList.remove('bi-star-fill');
                                            star.classList.add('bi-star');
                                        });
                                    }
                                </script>

                            </div>


                            <?php

                            // Retrieve shoe data from database
                            $sql = "SELECT c.comment, c.user, c.comment_time, s.seller_name
                            FROM comment c
                            JOIN shoes s ON c.shoes_id = s.id
                            WHERE c.seller = (SELECT seller_name FROM shoes WHERE id =" . $_SESSION['product_id'] . ")
                            ";
                            $result = $conn->query($sql);



                            // Check if there are any rows returned
                            if ($result->num_rows > 0) {

                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <div class="card-body">
                                        <div class="d-flex flex-start align-items-center">
                                            <img class="rounded-circle shadow-1-strong me-3" src="images/user.png" alt="avatar"
                                                width="60" height="60" />
                                            <div>
                                                <h6 class="fw-bold text-primary mb-1">
                                                    <?php echo $row['user']; ?>
                                                </h6>
                                                <p class="text-muted small mb-0">
                                                    Shared publicly -
                                                    <?php echo $row['comment_time']; ?>
                                                </p>
                                            </div>
                                        </div>

                                        <p class="mt-3 mb-4 pb-2">
                                            <?php echo $row['comment']; ?>
                                        </p>
                                    </div>
                                    <?php


                                }
                            }
                            ?>


                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- -------------------------------Body-------------------------------->
        <!-- -------------------------------footer-------------------------------->
        <?php include('constants/footer.php') ?>
        <!-- Optional JavaScript; choose one of the two! -->


        <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
            integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
            crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct"
            crossorigin="anonymous"></script>




        <script src="js/card.js"></script>
    </body>

    </html>



    <?php
} else {
    // if not logged then redirecting to login page
    header("Location: login.php");
    exit();

}

?>