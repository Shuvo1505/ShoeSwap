<?php
require 'php/ping_test.php';
session_start();
if ($_SESSION["status"] === "active") {
    include('auth/database.php');
    $userId = $_SESSION['userId'];

    $query = "SELECT * FROM user WHERE userid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo "<script>alert('User not found!'); window.location.replace('login.php');</script>";
        session_destroy();
        exit();
    }

    $requiredFields = [
        'FNAME', 'LNAME', 'USERNAME', 'EMAIL_ID', 'PASSWORD',
        'STATE', 'CITY', 'PIN', 'PHONE_NUMBER',
        'SECURITY_QUES'
    ];

    $missing = false;
    foreach ($requiredFields as $field) {
        if (!isset($user[$field]) || trim($user[$field]) === '') {
            $missing = true;
            break;
        }
    }
    
    if ($missing) {
        echo "<script>alert('Data integrity error!'); window.location.replace('home.php');</script>";
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step Up Your Style</title>

  <link rel="icon" href="images\icons\webisite_logo.png" type="image/x">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <style>
        .profile-card {
            background: #fff;
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .profile-img img {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid #f8f9fa;
        }

        .profile-heading {
            color: #213555;
            font-weight: bold;
        }

        .info-section h5 {
            font-weight: 600;
            color: #EB5B00;
        }

        .info-section p {
            margin-bottom: 0.5rem;
        }

        body {
        background-image: url('images/shoe.avif'); 
        background-size: cover;
        background-repeat: no-repeat;
        min-height: 100vh;
    }
    </style>
</head>

<body>

    <!-- Navbar -->
    <?php include('constants/navbar_other.php'); ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Profile Section -->
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="profile-card text-center">
                    <div class="profile-img mb-3">
                        <img src="images/members.png" alt="Profile Image">
                    </div>
                    <h2 class="profile-heading"><?php echo htmlspecialchars($user['FNAME'] . ' ' . $user['LNAME']); ?></h2>
                    <h6 class="text-muted"><?php echo htmlspecialchars($user['USERNAME']); ?></h6>
                    <br>
                    <div class="row text-left">
                        <!-- Information -->
                        <div class="col-md-6 info-section mb-4">
                            <h5>Location Details</h5>
                            <p><strong>State:</strong> <?php echo htmlspecialchars($user['STATE']); ?></p>
                            <p><strong>City:</strong> <?php echo htmlspecialchars($user['CITY']); ?></p>
                            <p><strong>Pin Code:</strong> <?php echo htmlspecialchars($user['PIN']); ?></p>
                        </div>

                        <!-- Contact -->
                        <div class="col-md-6 info-section mb-4">
                            <h5>Contact Details</h5>
                            <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['PHONE_NUMBER']); ?></p>
                            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['EMAIL_ID']); ?></p>
                        </div>

                        <!-- Security Question -->
                        <div class="col-12 info-section">
                            <h5>Security Question</h5>
                            <p><strong>Answer (Year of Birth):</strong> <?php echo htmlspecialchars($user['SECURITY_QUES']); ?></p>
                        </div>
                    </div>
                    <br>
                    <form action="edit_profile.php" method="POST">
                    <button type="submit" class="btn btn-dark" id="login_btn">Edit Profile</button>
                    </form>
                    <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                        <script>
                        Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Profile updated successfully",
                        showConfirmButton: false,
                        timer: 1500
                        });                   
                    </script>
                    <?php endif; ?>
                    <?php if (isset($_GET['status']) && $_GET['status'] === 'failed'): ?>
                        <script>
                        Swal.fire({
                        icon: "error",
                        title: "Profile updation failed",
                        showConfirmButton: false
                        });                 
                    </script>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include('constants/footer.php'); ?>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/custom.js"></script>

</body>
</html>

<?php
} else {
    header("Location: login.php");
    exit();
}
?>
