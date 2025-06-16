<?php require '../php/ping_test.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
    rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC"
    crossorigin="anonymous">

    <title>Step Up Your Style</title>

    <link rel="icon" href="images\icons\webisite_logo.png" type="image/x">
</head>

<body>
    <?php require 'aboutus_nav.php'; ?>
    <div class="cards m-3 justify-content-center" style="width: 77rem; background-color: #213555;">
        <div class="card-header">
            <h5 class="card-subtitle m-2 text-light">How We Work</h5>
        </div>
        <div class="card-body bg-light">
            <div class="card-group">
            <div class="card m-4">
                <img class="card-img-top" src="../images/card1.jpg" alt="Card image cap">
                <div class="card-body">
                <h5 class="card-title">Step 1</h5>
                <p class="card-text">Enter your shoe preferences. Find your perfect pair or list your kicks for sale.</p>
                </div>
            </div>
            <div class="card m-4">
                <img class="card-img-top" src="../images/card2.jpg" alt="Card image cap">
                <div class="card-body">
                <h5 class="card-title">Step 2</h5>
                <p class="card-text">Explore listings and select your desired kicks. Get one step closer to owning your dream sneakers.</p>
                </div>
            </div>
            <div class="card m-4">
                <img class="card-img-top" src="../images/card3.jpg" alt="Card image cap">
                <div class="card-body">
                <h5 class="card-title">Step 3</h5>
                <p class="card-text">Complete your purchase. Sit back and relax as we connect you with the seller!</p>
                </div>
            </div>
            </div>
        </div>
    </div>
    <div class="cards m-3" style="width: 77rem; background-color: #213555;">
    <div class="card-header">
        <h5 class="text-light m-2">Join Our Community</h5>
    </div>
    <div class="card-body mb-3 bg-light">
        <div class="row g-0 border border-1 border-muted" style="border-radius: 5px;">
        <div class="col-md-6">
            <img src="../images/seller.jpg" style="height: 200px; width:300px; margin-left: 150px;" class="img-fluid rounded" alt="...">
        </div>
        <div class="col-md-6">
            <div class="card-body">
            <h5 class="card-title" style=" margin-top:2rem;">As a Seller</h5>
            <p class="card-text">Earn by selling premium sneakers online. All you need is your collection and a device.</p>
            </div>
        </div>
        </div>
        <div class="row g-0 mt-5 border border-1 border-muted" style="border-radius: 5px;">
        <div class="col-md-6">
            <h5 class="card-title" style="margin-left: 100px; margin-top:4rem;">As a Buyer</h5>
            <p class="card-text" style="margin-left: 100px;">Find your dream sneakers from our vast collection. Get the best deals and connect with trusted sellers.</p>
        </div>
        <div class="col-md-6">
            <div class="card-body">
            <img src="../images/buyer.jpg" style="height: 200px; width:300px; margin-left: 150px;" class="img-fluid rounded-start" alt="...">
            </div>
        </div>
        </div>
        <div class="row g-0 mt-4 border border-1 border-mute" style="border-radius: 5px;">
        <div class="col-md-6">
            <img src="../images/partner.jpg" style="height: 200px; width:300px; margin-left: 150px;" class="img-fluid rounded-start" alt="...">
        </div>
        <div class="col-md-6">
            <div class="card-body">
            <h5 class="card-title" style=" margin-top:3rem;">As a partner</h5>
            <p class="card-text">Join a team dedicated to revolutionizing the sneaker reselling industry</p>
            </div>
        </div>
        </div>
    </div>
    </div>

    <?php require 'footer.php'; ?>


</body>
</html>