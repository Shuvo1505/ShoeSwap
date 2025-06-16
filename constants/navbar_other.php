<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css">
 
</head>
<style>
          .navbar-nav .nav-link:hover {
            color: #EB5B00 !important; /* Orange color */
            font-weight: bold;
        }
</style>
<body>

    <!-- <nav class="navbar navbar-expand-lg bg-body-tertiary text-light" style="background-color: #213555; height:5rem;"> -->
    <nav class="navbar navbar-expand-lg sticky-top text-light" style="background-color: #213555; height:5rem; z-index: 1030;">

        <div class="container-fluid ms-4">
        <a class="navbar-brand d-block" style="color:#EB5B00; font-family: 'Arial'; font-weight: 600; font-size: 28px;">
                ShoeSwap
                <div style="font-size: 14px; color: #fff; font-weight: 400;">Step Up Your Style</div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav row justify-content-around ms-5">
                    <li class="nav-item col-auto">
                        <a class="nav-link text-white" aria-current="page" href="home.php">Home</a>
                    </li>
                    <li class="nav-item col-auto">
                        <a class="nav-link text-white" href="aboutus.php">About us</a>
                    </li>
                    <li class="nav-item col-auto">
                        <a class="nav-link text-white" href="home.php#item_section">Product</a>
                    </li>
                </ul>

                <form class="d-flex mt-1 ms-auto">
                </form>




                <ul class="list-inline ms-3 mt-3 fs-5">
                    <li class="list-inline-item">
                        <a href="wishlist.php" class="text-white">
                            <i class="bi bi-suit-heart">

                            </i>
                        </a>
                    </li>
                    <li class="list-inline-item">
                        <a href="cart.php" class="text-white" >
                            <i class="bi bi-cart3"></i>
                        </a>
                    </li>
                    <li class="list-inline-item dropdown">
                        <a href="" class="btn btn-outline-light rounded-pill px-3 dropdown-toggle" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Welcome, <?php echo $_SESSION['user'] ?> <i class="bi bi-person"></i>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="'userDropdown">
                            <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                            <li><a class="dropdown-item" href="myorder.php">My Order</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="php/logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>

            </div>
        </div>
    </nav>

    <!------------------------------------------------------ Login------------------------------------------------------------------ -->






</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</html>