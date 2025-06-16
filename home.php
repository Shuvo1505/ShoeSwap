<?php require 'php/ping_test.php'; session_start();?>
<!DOCTYPE html>
<html lang="en" style="scroll-padding-top:90px">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@1,700&display=swap" rel="stylesheet">
  <!--Swiperjs Link -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

  <!--BootStrap Link -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <title>Step Up Your Style</title>

  <link rel="icon" href="images\icons\webisite_logo.png" type="image/x">

  <style>
    .card {
      transition: transform 0.3s ease-in-out;
    }

    .card:hover {
      transform: scale(1.03);
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
    }

    .scrolling-wrapper {
      scrollbar-width: thin;
      /* Firefox */
      scrollbar-color: #ccc transparent;
      /* Firefox */
    }

    /* For WebKit browsers (Chrome, Safari) */
    .scrolling-wrapper::-webkit-scrollbar {
      height: 8px;
    }

    .scrolling-wrapper::-webkit-scrollbar-track {
      background: transparent;
    }

    .scrolling-wrapper::-webkit-scrollbar-thumb {
      background: #bbb;
      border-radius: 10px;
    }

    .product-image {
      width: 100%;
      height: 220px;
      /* Fixed height */
      object-fit: cover;
      /* Ensures images are uniformly cropped */
    }
    .product-image-sm {
    width: 100%;
    height: 150px; /* smaller image height */
    object-fit: cover;
    border-top-left-radius: 8px;
    border-top-right-radius: 8px;
}

  </style>
</head>

<body>
  <!-- -------------------------------Navbar-------------------------------->
  <?php require 'constants/navbar.php'; ?>

  <!-- -------------------------------Banner-------------------------------->
  <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img class="d-block w-100" src="images\banner\carosel (1).webp" alt="First slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="images\banner\carosel (2).webp" alt="Second slide">
      </div>
      <div class="carousel-item">
        <img class="d-block w-100" src="images\banner\carosel (3).webp" alt="Third slide">
      </div>
    </div>
  </div>
  <!-- -------------------------------Cart-------------------------------->
  <h4 class="m-3 mt-5">Shop By Popular Brand</h4>
<div class="row m-1">
  <div class="col-sm-3">
    <div class="card shadow-sm">
      <a href="categories.php?brand=Air jordan">
        <img src="images/brand_images/shop-by-brand-1.jpg" class="img-fluid rounded" alt="Nike">
      </a>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card shadow-sm">
      <a href="categories.php?brand=Adidas">
        <img src="images/brand_images/shop-by-brand-2.jpg" class="img-fluid rounded" alt="Adidas">
      </a>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card shadow-sm">
      <a href="categories.php?brand=Nike">
        <img src="images/brand_images/shop-by-brand-3.jpg" class="img-fluid rounded" alt="Puma">
      </a>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="card shadow-sm">
      <a href="categories.php?brand=New Balance">
        <img src="images/brand_images/shop-by-brand-4.jpeg" class="img-fluid rounded" alt="Reebok">
      </a>
    </div>
  </div>
</div>

<br><br id="spacer"><br><br>

  <!-- -------------------------------Product Section-------------------------------->
<div class="container" id="item_section">
    <div id="searchResults"></div> <!-- This will show the search results -->
    <div class="row" id="productSection"> <!-- This will hold the product items -->
        <?php 
            include('php/shoe.php');
        ?>
    </div>
</div>

  <!----------------------------------Our testimonials-------------------------------->
  <h2 class="mt-5 pt-4 mb-4 text-center fw-bold h-font">Testimonials</h2>
  <div class="container mt-5">
    <div class="swiper swiper-testimonials">
      <div class="swiper-wrapper mb-5">
        <div class="swiper-slide bg-white p-3">
          <div class="profile d-flex align-items-center mb-2">
            <i class="bi bi-quote fs-1"></i>

          </div>
          <h5 class="m-0 mb-2">Akshat</h5>
          <p>
            I had a great experience with these guys. Their team helped me find the
            perfect pair as per my liking, and they made my overall experience very smooth. Thanks!
          </p>

        </div>
        <div class="swiper-slide bg-white p-3">
          <div class="profile d-flex align-items-center mb-3">
            <i class="bi bi-quote fs-1"></i>
          </div>
          <h5 class="m-0 mb-2">Jay</h5>
          <p>
            I have been following these guys on Instagram, and have always wanted to buy a pair myself. They do these
            weekly drops and I highly suggest-you also follow them on Instagram.
            I copped my first ever Nike's at a very affordable price.
          </p>

        </div>
        <div class="swiper-slide bg-white p-3">
          <div class="profile d-flex align-items-center mb-3">
            <i class="bi bi-quote fs-1"></i>
          </div>
          <h5 class="m-0 ms-2">Rahul Gupta</h5>
          <p>
            Had a little rough experience, when they couldn't ship my pair due to
            seller operational issues. Their team called me and explained me the whole
            situation, asking for my patience and today, I finally got the pair that I
            wanted from so long. I appreciate the support. Would recommend 10/10.
          </p>

        </div>
        <div class="swiper-slide bg-white p-3">
          <div class="profile d-flex align-items-center mb-3">
            <i class="bi bi-quote fs-1"></i>
          </div>
          <h5 class="m-0 ms-2">Aaryan Singla </h5>
          <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Asperiores earum animi
            vel commodi odit voluptatem at voluptatibus laborum quis rem.
          </p>

        </div>
      </div>
      <div class="swiper-pagination"></div>
    </div>


  </div>
  <!--------------------------------Our testimonials------------------------------>

  <!-- -------------------------------footer-------------------------------->

  <?php require 'constants/footer.php'; ?>


            <!-- for proper working of dropdown -->
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
    crossorigin="anonymous"></script> -->

    <script>
        // Listen for input on the search field
  $('#liveSearch').on('keyup', function() {
    let query = $(this).val();
    
    // If search input is not empty, show the search results and hide the product section
    if (query.length > 0) {
      $('#productSection').hide(); // Hide the product section
      $.ajax({
        url: 'php/search_shoes.php',
        method: 'POST',
        data: { search: query },
        success: function(data) {
          $('#searchResults').html(data); // Update the search results
                  // Smooth scroll to the results
              document.getElementById('spacer').scrollIntoView({
              behavior: 'smooth',
              block: 'start'
          });
        }
      });
    } else {
      // If search input is empty, show the product section and clear search results
      $('#productSection').show(); // Show the product section
      $('#searchResults').html(''); // Clear the search results
    }
  });
</script>

  <script>
    var carousel = document.querySelector('#carouselExampleSlidesOnly');
    var carousel = new bootstrap.Carousel(carousel);
  </script>

  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <script>

    var swiper = new Swiper(".swiper-testimonials", {
      effect: "coverflow",
      grabCursor: true,
      centeredSlides: true,
      slidesPerView: "auto",
      slidesPerView: "3",
      loop: true,
      coverflowEffect: {
        rotate: 50,
        stretch: 0,
        depth: 100,
        modifier: 1,
        slideShadows: false,
      },
      pagination: {
        el: ".swiper-pagination",
      },
      breakpoints: {
        320: {
          slidesPerView: 1,
        },
        640: {
          slidesPerView: 1,
        },
        768: {
          slidesPerView: 2,
        },
        1024: {
          slidesPerView: 3,
        },
      }
    });
  </script>



</body>

</html>