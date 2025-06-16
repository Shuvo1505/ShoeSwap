<?php require '../php/ping_test.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Step Up Your Style</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
    <style>
       .nav-item:hover .nav-link {
        color: #EB5B00!important;
            font-weight: bold;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary text-light" style="background-color: #213555!important; height:5rem;">

        <div class="container-fluid ms-4">
        <a class="navbar-brand d-block" style="color:#EB5B00; font-family: 'Arial'; font-weight: 600; font-size: 28px;">
                ShoeSwap (Seller)
                <div style="font-size: 14px; color: #fff; font-weight: 400;">Step Up Your Style</div>
            </a>
            <div class="collapse navbar-collapse" id="navbarSupportedContent" style="margin-left: 35rem;">
                <ul class="navbar-nav row justify-content-around">
                    <li class="nav-item col-auto">
                        <a class="nav-link text-white" aria-current="page" href="homepage_seller.php">Home</a>
                    </li>
                    <li class="nav-item col-auto">
                        <a class="nav-link text-white " href="ordered_seller.php">Order</a>
                    </li>
                    <li class="nav-item col-auto">
                        <a class="nav-link text-white " href="dashboard.php">Profile</a>
                    </li>
                    <li class="nav-item col-auto">
                        <a class="nav-link text-white " href="Logout.php">Logout </a>
                    </li>
                </ul>              

            </div>
        </div>
    </nav>

    



</body>

</html>