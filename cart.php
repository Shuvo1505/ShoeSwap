<?php
require 'php/ping_test.php';
//initiating session
session_start();

// checking if the user has logged in or not

if ($_SESSION["status"] === "active") {

  //storing user data
  // Calculate total price and offer price of selected items
  include('auth/database.php');
  $sql = "SELECT s.id ,s.gender,s.size, s.brand, s.selling_price, s.image_url,s.purchase_price FROM cart c JOIN shoes s ON c.shoes_id = s.id WHERE c.user ='{$_SESSION['username']}'";
  $result = $conn->query($sql);

  $totalItems = 0;

  ?>


  <!DOCTYPE html>
  <html lang="en">

  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
      integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">


    <title><?php echo ($result->num_rows < 1) ? "Cart" : "Cart (" . $result->num_rows . ")"; ?></title>

    <link rel="stylesheet" href="css/cart.css">
    <link rel="icon" href="images\icons\webisite_logo.png" type="image/x">
    <script src="js/cart.js"></script>
    <style>
      .gradient-custom {
        /* fallback for old browsers */
        background: #f9f9f9;

        /* Chrome 10-25, Safari 5.1-6 */
        background: #f9f9f9;

        /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
        background: #f9f9f9;
      }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>

  </head>

  <body>

    <!-- -------------------------------Navbar-------------------------------->
    <!-- --------------------navbar---------------------- -->
    <?php include('constants/navbar_other.php') ?>
    <!-- --------------------navbar---------------------- -->

    <section class="h-100 gradient-custom">
      <div class="container py-5">
        <div class="row my-4">
          <!-- Left Side: Cart Section -->
          <div class="col-md-7 order-md-1">
            <div class="card mb-4">
              <div class="card-header py-3">
                <h5 class="mb-0">Cart -
                  <?php $totalItemsResult = $conn->query("SELECT COUNT(*) AS total_items FROM cart WHERE user='{$_SESSION['username']}'");
                  $totalItems = ($totalItemsResult->num_rows > 0) ? $totalItemsResult->fetch_assoc()["total_items"] : 0;
                  echo $totalItems;
                  ?>
                  items
                </h5>
              </div>

              <div class="card-body">
                <?php

                echo "<div class='container'>";
                if ($result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                    ?>
                    <a href="product_page.php?id=<?php echo $row['id']; ?>" class="text-decoration-none text-dark">
                      <div class="row mb-3">
                        <div class="col-lg-3 col-md-12">
                          <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                            <img src="<?php echo "seller/php/" . $row["image_url"]; ?>" class="w-100" alt="Product_image" />
                          </div>
                        </div>
                        <div class="col-lg-5 col-md-6">
                          <p><strong><?php echo $row["brand"]; ?></strong></p>
                          <p><?php echo "Gender: " . $row["gender"]; ?></p>
                          <p><?php echo "Size: " . $row["size"]; ?></p>
                        </div>
                        <div class="col-lg-4 col-md-6 text-md-center">
                          <p><strong>₹ <?php echo $row["selling_price"]; ?></strong></p>
                          <form action='php/cancel_order.php' method='post' style='display:inline-block; margin-top: 10px;'>
                            <input type='hidden' name='product_id' value="<?php echo $row["id"]; ?>">
                            <button type='submit' class='btn btn-outline-danger btn-sm'>Remove</button>
                          </form>
                        </div>
                      </div>
                    </a>

                    <hr>
                  <?php }
                } else {
                  echo "<img src='images/no_data.jpg' class='img-fluid'>";
                }
                echo "</div>"; ?>
              </div>
            </div>


            <?php
            // Assuming a user is logged in and the userId is available in session
            $userId = $_SESSION['userId'];

            // Fetch the default address and other addresses from the database
            $query = "SELECT * FROM addresses WHERE userId = ? ORDER BY is_default DESC";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("i", $userId);
            $stmt->execute();
            $result = $stmt->get_result();

            // Initialize variables to store the default address and other addresses
            $defaultAddress = null;
            $addresses = [];

            // Loop through the results
            while ($row = $result->fetch_assoc()) {
              if ($row['is_default'] == "yes") {
                // Set the default address
                $defaultAddress = $row;
              } else {
                // Store other addresses
                $addresses[] = $row;
              }
            }

            $stmt->close();
            ?>









          </div>

          <!-- Right Side: Payment Section -->
          <div class="col-md-5 order-md-2">
            <div class="card text-black rounded-3" style="background-color: #f9f9f6;">
              <div class="card-body">
              <?php if ($totalItems > 0): ?>
                      <h5 class="mb-4" style="color: black">Cart Details</h5>
                  <?php else: ?>
                      <h5 class="mb-4" style="color: black">Your ShoeSwap Cart is empty</h5>
                      <h6 class="text-muted">
                          Your shopping cart is waiting. Give it purpose – Continue shopping on the 
                          <a href="home.php" style="text-decoration: none;">ShoeSwap</a> homepage, or visit your Wish List.
                      </h6>
                  <?php endif; ?>

                <?php if($totalItems > 0): ?>
                <form action="choose_address.php" class="mt-4" method="POST" id="paymentform">
                  <!-- ---------- Delivery Option -------------- -->
                  <div class="card mb-4">
                    <div class="card-body">
                      <p><strong style="color: green">Free Delivery</strong></p>

                      <!-- Standard Delivery (pre-selected and on top) -->
                       <?php
                       echo '
                      <div class="form-check mb-2 p-3 border rounded">
                        <input class="form-check-input" type="radio" name="delivery_option" id="standardDelivery"
                          value="standard" checked>
                        <label class="form-check-label" for="standardDelivery">
                          <strong>Standard Delivery</strong> | 4-6 working days
                        </label>
                      </div>
                      ';
                    ?>
                    </div>
                  </div>

                  <hr class="my-4">
                    <div class="d-flex justify-content-between">
                      <p>Expected Delivery</p>
                      <p class="mb-0" id="shippingDate">
                        <?php
                        $deliveryStartDate = date('d.m.Y', strtotime('+4 days'));
                        $deliveryEndDate = date('d.m.Y', strtotime('+6 days'));
                        echo $deliveryStartDate . ' - ' . $deliveryEndDate;
                        ?>
                      </p>
                    </div>

                  <div class="d-flex justify-content-between">
                    <p>Subtotal</p>
                    <p>
                      ₹<?php
                      echo ($conn->query("SELECT SUM(s.purchase_price) AS total FROM cart c 
              JOIN shoes s ON c.shoes_id = s.id 
              WHERE c.user = '{$_SESSION['username']}'")->fetch_assoc()["total"] ?? 0);
                      ?>
                    </p>
                  </div>

                  <div class="d-flex justify-content-between">
                    <p>Discount</p>
                    <p>
                      ₹<?php
                      $row = $conn->query("SELECT SUM(s.purchase_price) AS total_purchase, SUM(s.selling_price) AS total_selling 
              FROM cart c JOIN shoes s ON c.shoes_id = s.id 
              WHERE c.user = '{$_SESSION['username']}'")->fetch_assoc();
                      echo ($row["total_purchase"] - $row["total_selling"]);
                      ?>
                    </p>
                  </div>

                  <div class="d-flex justify-content-between mb-4">
                    <p>Total (Incl. taxes)</p>
                    <p>
                      ₹<?php
                      echo ($conn->query("SELECT SUM(s.selling_price) AS total FROM cart c 
              JOIN shoes s ON c.shoes_id = s.id 
              WHERE c.user = '{$_SESSION['username']}'")->fetch_assoc()["total"] ?? 0);
                      ?>
                    </p>
                  </div>
                  <button type="submit" class="btn btn-primary btn-block btn-lg">
                    <div class="d-flex justify-content-between">
                      <span>
                        ₹<?php
                        echo ($conn->query("SELECT SUM(s.selling_price) AS total FROM cart c 
                JOIN shoes s ON c.shoes_id = s.id 
                WHERE c.user = '{$_SESSION['username']}'")->fetch_assoc()["total"] ?? 0);
                        ?>
                      </span>
                      <span>Proceed to Buy</span>
                    </div>
                  </button>
                </form>
                <?php endif; ?>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
  </body>

  <script>
    // -------------------------delivery option date configuration-------------
    document.addEventListener('DOMContentLoaded', function () {
      const shippingDateElement = document.getElementById('shippingDate');
      const expressRadio = document.getElementById('expressDelivery');
      const standardRadio = document.getElementById('standardDelivery');

      function updateShippingDates(startOffset, endOffset) {
        const now = new Date();
        const startDate = new Date(now);
        const endDate = new Date(now);
        startDate.setDate(now.getDate() + startOffset);
        endDate.setDate(now.getDate() + endOffset);

        const format = (date) => {
          const day = String(date.getDate()).padStart(2, '0');
          const month = String(date.getMonth() + 1).padStart(2, '0');
          const year = date.getFullYear();
          return `${day}.${month}.${year}`;
        };

        shippingDateElement.textContent = `${format(startDate)} - ${format(endDate)}`;
      }

      expressRadio.addEventListener('change', () => {
        if (expressRadio.checked) {
          updateShippingDates(4, 6); // Express: 4–6 days
        }
      });

      standardRadio.addEventListener('change', () => {
        if (standardRadio.checked) {
          updateShippingDates(9, 12); // Standard: 9–12 days
        }
      });

      // Trigger once on load in case standard is checked by default
      if (standardRadio.checked) {
        updateShippingDates(9, 12);
      }
    });


    // -----------------------Address Change Option---------------

    const addressDropdown = document.getElementById('addressDropdown');
    const selectedAddress = document.getElementById('selectedAddress');
    const addAddressModal = new bootstrap.Modal(document.getElementById('addAddressModal'));
    const toastElement = new bootstrap.Toast(document.getElementById('addressToast'));

    addressDropdown.addEventListener('change', function () {
      hiddenAddressInput.value = this.value;
      if (this.value === 'new') {
        addAddressModal.show();
      } else {
        // Find the selected option using the value (addressId)
        const selectedOption = this.options[this.selectedIndex];
        // Get the full address stored in the data attribute
        const address = selectedOption.getAttribute('data-address');
        selectedAddress.textContent = address;
      }
    });





    // document.getElementById('addAddressForm').addEventListener('submit', function (e) {
    //   e.preventDefault();

    //   const form = this;
    //   const formData = new FormData(form);

    //   fetch('php/add_Address.php', {
    //     method: 'POST',
    //     body: formData
    //   })
    //     .then(response => response.text())
    //     .then(result => {
    //       if (result.trim() === 'success') {
    //         // Get address parts
    //         const name = formData.get('full_name');
    //         const phone = formData.get('phone_number');
    //         const pincode = formData.get('pincode');
    //         const state = formData.get('state');
    //         const city = formData.get('city');
    //         const house = formData.get('house');
    //         const area = formData.get('area');
    //         const landmark = formData.get('landmark');

    //         // Construct address string
    //         let address = `${name}, ${house}, ${area}, ${city}, ${state}, ${pincode}, Ph: ${phone}`;
    //         if (landmark) address += `, Landmark: ${landmark}`;

    //         // Add to dropdown
    //         const newOption = new Option(address, address);
    //         addressDropdown.add(newOption, addressDropdown.options[1]);
    //         addressDropdown.value = address;
    //         selectedAddress.textContent = address;

    //         form.reset();
    //         addAddressModal.hide();
    //         toastElement.show();
    //       } else {
    //         alert('Failed to add address. Please try again.');
    //       }
    //     })
    //     .catch(error => {
    //       console.error('Error:', error);
    //       alert('Something went wrong!');
    //     });
    // });
  </script>

  </html>



  <?php
} else {
  // if not logged then redirecting to login page
  header("Location: login.php");
  exit();

}

?>

<!-- --------------------footer---------------------- -->
<?php include('constants/footer.php') ?>
<!-- --------------------footer---------------------- -->