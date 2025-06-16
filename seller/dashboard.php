<?php
require 'php/ping_test.php';
session_start();

    $user = $_SESSION["s_user"];

include 'constants/session_config.php';
if (!$is_logged_in){
    header("Location: login.php");
    exit;
}

    // Database connection
    include('../auth/database.php');
    $conn = new mysqli($host, $username, $password, "shoeswap");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch seller details
    $stmt = $conn->prepare("SELECT * FROM seller WHERE USERNAME = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    $seller = $result->fetch_assoc();

    $masking = '';

    if (!$seller) {
        echo "<script>alert('Seller not found!'); window.location.replace('login.php');</script>";
        session_destroy();
        exit();
    }

    if (strlen($seller['ID_NUMBER']) == 10){
        $masking = 'XXX-XXX-';
    } else if (strlen($seller['ID_NUMBER']) == 12){
        $masking = 'XXXX-XXXX-';
    } else if (strlen($seller['ID_NUMBER']) == 8){
        $masking = 'XXXX-';
    } else {
        $masking = 'XXXX-XXXX-XXXX';
    }

    $requiredFields = [
        'FNAME', 'LNAME', 'USERNAME', 'EMAIL_ID', 'ADDRESS', 'CITY', 'PIN', 'PHONE_NUMBER',
        'SECURITY_QUES', 'GOVT_ID_TYPE', 'ID_NUMBER'
    ];
    
    $missing = false;
    foreach ($requiredFields as $field) {
        if (!isset($seller[$field]) || trim($seller[$field]) === '') {
            $missing = true;
            break;
        }
    }

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/dashboard.css">
        <title>Step Up Your Style</title>
        <link rel="icon" href="images/webisite_logo.png" type="image/x-icon">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
        <style>
    body, html {
      height: 100%;
      margin: 0;
      background-image: url('images/shoe.avif');
      font-family: 'Segoe UI', Tahoma, Verdana, sans-serif;
    }
        </style>
    </head>
    <body>

    <!-- Navbar -->
    <?php include('static/navbar.php'); ?>

    <!-- Dashboard Section -->
    <section id="dashboard" class="py-5">
        <div class="container">
            <!-- Profile Card -->
            <div class="card mb-5 shadow-lg">
                <div class="card-header text-center text-white" style="background-color: #213555;">
                    <h2 class="mb-0">Seller Profile</h2>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <!-- Profile Image -->
                        <div class="col-md-4 text-center">
                            <i class="bi bi-person-circle" style="font-size: 150px;"></i>
                            <h4><?php echo $seller['FNAME'] . ' ' . $seller['LNAME']; ?></h4>
                            <h6 class="text-muted"><?php echo $seller['USERNAME']; ?>&nbsp;
                            <?php if ($missing): ?>
                                <i class="fa-solid fa-circle-exclamation" style="color: red;" title="Not verified!"></i>
                            <?php else: ?>
                                <i class="fa-solid fa-circle-check" style="color: green;" title="Verified!"></i>
                            <?php endif; ?>
                            </h6>
                        </div>

                        <!-- Profile Details -->
                        <div class="col-md-6">
                            <div class="form-row">
                            <div class="form-group col-md-6">
                                <h5 class="text-muted">Personal Information</h5>
                                <p><strong>Address:</strong> <?php echo $seller['ADDRESS']; ?></p>
                                <p><strong>City:</strong> <?php echo $seller['CITY']; ?></p>
                                <p><strong>PIN Code:</strong> <?php echo $seller['PIN']; ?></p>
                                <p><strong>Govt. ID Type:</strong> <?php echo $seller['GOVT_ID_TYPE']; ?></p>
                                <p><strong>ID Number:</strong> <?php echo $masking.substr($seller['ID_NUMBER'], -4); ?></p>
                            </div>

                            <div class="form-group col-md-6">
                                <h5 class="text-muted">Contact</h5>
                                <p><strong>Phone:</strong> <?php echo $seller['PHONE_NUMBER']; ?></p>
                                <p><strong>Email:</strong> <?php echo $seller['EMAIL_ID']; ?></p>
                            </div>
                            </div>
                            <div class="form-row">
                            <div class="form-group col-md-6">
                                <h5 class="text-muted">Security Question</h5>
                                <p><?php echo '<strong>Answer (Year of Birth): </strong>'. $seller['SECURITY_QUES']; ?></p>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                            <!-- Edit Profile Button -->
            <div class="text-center mb-4">
                <form action ="edit_profile.php" method="POST">
                <button type="submit" class="btn btn-dark" id="login_btn">Edit Profile</button>
                </form>
            </div>
            </div>

            <!-- Reviews Section -->
            <div class="card shadow-sm mb-5">
                <div class="card-body">
                    <div class="container">
                        <?php
                            $sql = "SELECT c.comment, c.rating, c.created_at
                                FROM `comment` c
                                JOIN `seller` s ON c.sellerId = s.sellerId
                                WHERE s.USERNAME = ?;
                            ";
                                    $stmt = $conn->prepare($sql);

                                    if (!$stmt) {
                                    die("SQL prepare failed: " . $conn->error);
                                    }

                                    $stmt->bind_param("s", $user);
                                    $stmt->execute();
                                    $result = $stmt->get_result();

                        if ($result === false || $result->num_rows == 0) {
                            ?>
                            <div class="alert alert-info text-center" role="alert">
                                No reviews yet. New seller!
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="alert alert-success text-center" role="alert">
                                Seller Reviews
                            </div>
                            <?php
                            while ($row = $result->fetch_assoc()) {
                                ?>
                                <div class="card mb-3 border-0 shadow-sm">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center mb-3">
                                            <img class="rounded-circle mr-3" src="images/user.png" alt="avatar" width="60" height="60">
                                            <div>
                                                <h5 class="mb-0"><?php echo "Verified User"; ?>&nbsp;<i class="fas fa-check-circle" style="color: green; font-size: 14px;"></i></h5>
                                                <small class="text-muted">Shared publicly - <?php echo $row['created_at']; ?></small>
                                            </div>
                                        </div>
                                        <p class="mb-0"><?php echo "Message: ". $row['comment']; ?></p>
                                    </div>
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

    <!-- Footer -->
    <?php include('static/footer.php'); ?>

    </body>
    </html>

    <?php
    $conn->close();
?>
