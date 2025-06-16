<?php

//initiating session
require 'php/ping_test.php';
session_start();

// checking if the user has logged in or not

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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step Up Your Style</title>

    <link rel="icon" href="images\webisite_logo.png" type="image/x">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('images/shoe.avif')!important;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            min-height: 100vh;
        }

        .search-container {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        #searchInput {
            padding: 10px 20px;
            font-size: 1.1em;
            height: auto;
            width: 300px;
        }

        #cards {
            margin-left: 10px;
            margin-right: 10px;
        }
    </style>
</head>
<body>
    <?php include('static/navbar.php'); ?>
    <div class="card m-4 p-2 text-white" style="background-color: #213555;">
        <h2><center>Items sold</center> </h2>
    </div>

    <div class="search-container">
        <form class="form-inline" action="" method="POST">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search Brands..." aria-label="Search" id="searchInput" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
        <button class="btn btn-dark my-2 my-sm-0 mr-2" type="button" onclick="filterCards()">Search</button>
        <button class="btn btn-dark my-2 my-sm-0" type="button" onclick="location.reload(true)">Reset</button>
        </form>
    </div>

    <section id="cards" >


    <?php include('php/shoe_seller_ordered.php'); ?>


    </section>


    <?php include('static/footer.php'); ?>

    <script>
        function filterCards() {
            const searchInput = document.getElementById('searchInput').value.toLowerCase();
            const cardContainer = document.getElementById('cards');
            const cards = cardContainer.getElementsByClassName('card');

            Array.from(cards).forEach(card => {
                const titleElement = card.querySelector('.card-title');
                const descriptionElement = card.querySelector('.card-text');

                let textContent = '';
                if (titleElement) {
                    textContent += titleElement.textContent.toLowerCase() + ' ';
                }
                if (descriptionElement) {
                    textContent += descriptionElement.textContent.toLowerCase();
                }

                if (textContent.includes(searchInput)) {
                    card.style.display = ''; // Show the card
                } else {
                    card.style.display = 'none'; // Hide the card
                }
            });
        }
    </script>
</body>
</html>