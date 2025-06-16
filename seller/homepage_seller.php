<?php

//initiating session

//storing user data

//include("session_storage.php");
require 'php/ping_test.php';
session_start();
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-image: url('images/shoe.avif');
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

        #cards {
            /* Keeping the original styling or lack thereof */
            margin-left: 10px; /* Example: Add some left margin if needed */
            margin-right: 10px; /* Example: Add some right margin if needed */
            /* Add any other specific styling you had for the cards section */
        }
    </style>
</head>

<body>
    <?php include('static/navbar.php'); ?>
    <div class="card m-4 p-2 text-white shadow-lg" style="background-color: #213555;">
        <h2><center>Items Listed</center> </h2>
    </div>
    <center>
        <a href="choice_seller.php"><button class="adding-item btn btn-dark">Add Item</button></a>

        <div class="search-container">
        <form class="form-inline" action="" method="POST">
        <input class="form-control mr-sm-2" type="search" name="search" placeholder="Search Brands..." aria-label="Search" id="searchInput" value="<?php echo isset($_POST['search']) ? htmlspecialchars($_POST['search']) : ''; ?>">
            <button class="btn btn-dark my-2 my-sm-0 mr-2" type="button" onclick="filterCards()">Search</button>
            <button class="btn btn-dark my-2 my-sm-0" type="button" onclick="location.reload(true)">Reset</button>
        </form>
    </div>
    </center>

    <section id="cards">
        <?php include('php/shoe_seller.php'); ?>
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
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

<?php

?>