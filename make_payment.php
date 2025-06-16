<?php
require 'php/ping_test.php';
session_start();
include('auth/database.php');

if ($_SESSION["status"] !== "active") {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId']; // Numeric userId for address
$username = $_SESSION['username'];


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['address_id'])) {
        $addressId = $_POST['address_id'];


        // ✅ Now you can use $addressId to proceed with payment logic
        // Example:
        // - Retrieve address details from DB if needed
        // - Save order with selected address
        // - Redirect to payment gateway or confirmation page

        // echo "Selected Address ID: " . htmlspecialchars($addressId);
        // Proceed with your payment logic here...
    } else {
        // ⚠️ No address selected
        echo "Please select a delivery address.";
    }
}


// Fetch user address
$addressQuery = $conn->prepare("SELECT fullName, house, area, landmark, city, state, pincode, phoneNumber
                                     FROM addresses
                                     WHERE addressId = ?");

// Assuming $addressId is set from the previous page's POST request
if (isset($addressId)) {
    $addressQuery->bind_param("i", $addressId);
    $addressQuery->execute();
    $addressResult = $addressQuery->get_result();
    $addressData = $addressResult->fetch_assoc();
    $addressQuery->close();
} else {
    $addressData = null; // Or handle the case where no address is selected
}


// Fetch cart items
$cartQuery = "SELECT s.brand, s.selling_price
                  FROM cart c
                  JOIN shoes s ON c.shoes_id = s.id
                  WHERE c.user = '$username'";
$cartResult = $conn->query($cartQuery);

$cartItems = [];
$totalAmount = 0;

while ($row = $cartResult->fetch_assoc()) {
    $cartItems[] = $row;
    $totalAmount += $row['selling_price'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Make Payment</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<style>
    body {
        background-image: url('images/shoe.avif');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        min-height: 100vh;
    }

    .payment-card {
        background: linear-gradient(135deg, #F7F7F7 0%, rgb(230, 214, 173) 100%);
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
        padding: 35px;
    }


    .payment-card .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, .25);
    }

    .card-icons i {
        font-size: 1.8rem;
        margin-right: 10px;
    }
</style>
<script>
    function formatCardNumber(input) {
        const value = input.value.replace(/\s/g, '');
        let formattedValue = '';
        for (let i = 0; i < value.length; i++) {
            if (i > 0 && i % 4 === 0) {
                formattedValue += ' ';
            }
            formattedValue += value[i];
        }
        input.value = formattedValue;
    }

  function formatExpiry(input) {
    const value = input.value.replace(/\D/g, '');
    if (value.length > 0) {
        let formattedValue = value.substring(0, 2);
        if (value.length > 2) {
            formattedValue += '/' + value.substring(2, 4);
        }
        input.value = formattedValue;
    } else {
        input.value = ''; // Clear if no digits are entered
    }
}

    function validateForm(event) {
        const name = document.getElementById('card_name').value.trim();
        const number = document.getElementById('card_number').value.trim().replace(/\s/g, ''); // Remove spaces before validation
        const expiry = document.getElementById('card_expiry').value.trim().replace('/', ''); // Remove slash before validation
        const cvv = document.getElementById('card_cvv').value.trim();

        if (!name || !number || !expiry || !cvv) {
            alert("Please fill in all payment details.");
            return false;
        }

        const onlyDigits = /^\d+$/;

        if (!onlyDigits.test(number) || !onlyDigits.test(expiry) || !onlyDigits.test(cvv)) {
            alert("Card details must contain only numbers.");
            return false;
        }

        if (number.length !== 16) {
            alert("Card number must be 16 digits.");
            return false;
        }

        if (expiry.length !== 4) {
            alert("Expiry must be 4 digits (MMYY).");
            return false;
        } else {
            const month = parseInt(expiry.substring(0, 2));
            if (month < 1 || month > 12) {
                alert("Please enter a valid month (01-12).");
                return false;
            }
        }

        if (cvv.length !== 3) {
            alert("CVV must be 3 digits.");
            return false;
        }
        document.getElementById('loader-overlay').style.display = 'flex';

        // Before submitting, set the raw values back to the input fields (without formatting)
        document.getElementById('card_number').value = number;
        document.getElementById('card_expiry').value = expiry;

        setTimeout(() => {
            document.getElementById('paymentForm').submit(); // manually submit
        }, 7000); // adjust timing as needed

        return false;
    }
</script>

<body>

    <?php include('constants/navbar_other.php'); ?>

    <div class="container mt-5">
        <h3>Confirm Your Order & Payment</h3>
        <hr>

        <div class="row">
            <div class="col-md-6 mb-4">
                <h5>Shipping Address:</h5>
                <p>
                    <?php
                    if (!empty($addressData)) {
                        echo "{$addressData['fullName']}, {$addressData['phoneNumber']}<br>" .
                            "{$addressData['house']}, {$addressData['area']}, {$addressData['landmark']}<br>" .
                            "{$addressData['city']}, {$addressData['state']} - {$addressData['pincode']}<br>" .
                            "Phone: {$addressData['phoneNumber']}";
                    } else {
                        echo "No address found.";
                    }
                    ?>
                </p>

                <h5>Your Cart:</h5>
                <ul class="list-group mb-3">
                    <?php if (!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $item): ?>
                            <li class="list-group-item d-flex justify-content-between">
                                <?php echo htmlspecialchars($item['brand']); ?>
                                <span>₹<?php echo number_format($item['selling_price'], 2); ?></span>
                            </li>
                        <?php endforeach; ?>
                        <li class="list-group-item d-flex justify-content-between font-weight-bold">
                            Total
                            <span>₹<?php echo number_format($totalAmount, 2); ?></span>
                        </li>
                    <?php else: ?>
                        <li class="list-group-item">Your cart is empty.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="col-md-6">
                <div class="payment-card m-5 mt-2">
                    <h4 class="mb-4 text-center">Secure Payment</h4>
                    <div class="card-icons text-center mb-3">
                        <i class="fab fa-cc-visa" style="color: #1434CB;"></i>
                        <i class="fab fa-cc-mastercard" style="color:#FF5F00"></i>
                        <i class="fab fa-cc-amex" style="color:#9bd4f5;"></i>
                        <i class="fab fa-cc-discover" style="color:back;"></i>
                    </div>

                    <form id="paymentForm" action="php/payment_success.php" method="POST" onsubmit="return validateForm();">
                        <div class="form-group mb-3">
                            <?php if (isset($_POST['address_id'])): ?>
                                <input type="hidden" name="address_id" value="<?= htmlspecialchars($_POST['address_id']) ?>">
                            <?php endif; ?>

                            <?php if (isset($_SESSION['delivery_option'])): ?>
                                <input type="hidden" name="delivery_option" value="<?= $_SESSION['delivery_option'] ?>">
                            <?php endif; ?>
                            <label for="card_name" class="form-label">Cardholder Name</label>
                            <input type="text" class="form-control" id="card_name" name="card_name"
                                   required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="card_number_raw" class="form-label">Card Number</label>
                            <input type="text" class="form-control" id="card_number" name="card_number"
                                   maxlength="19" pattern="\d{4} \d{4} \d{4} \d{4}"
                                   oninput="formatCardNumber(this)" required>
                            <input type="hidden" id="card_number_raw" name="card_number_raw">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="card_expiry_raw" class="form-label">Expiry (MM/YY)</label>
                                <input type="text" class="form-control" id="card_expiry" name="card_expiry"
                                       maxlength="5" pattern="\d{2}/\d{2}" oninput="formatExpiry(this)" required>
                                <input type="hidden" id="card_expiry_raw" name="card_expiry_raw">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="card_cvv" class="form-label">CVV</label>
                                <input type="password" class="form-control" id="card_cvv" name="card_cvv"
                                       maxlength="3" pattern="\d{3}" required>
                            </div>
                        </div>
                        <?php require 'loader.php'; ?>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success btn-lg w-100" id="pay_btn">
                                <i class="fas fa-lock"></i> Pay ₹<?php echo number_format($totalAmount, 2); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php include('constants/footer.php'); ?>

    <script>
        function formatCardNumber(input) {
            const value = input.value.replace(/\s/g, '');
            let formattedValue = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) {
                    formattedValue += ' ';
                }
                formattedValue += value[i];
            }
            input.value = formattedValue;
        }

        function formatExpiry(input) {
            const value = input.value.replace(/\D/g, '');
            if (value.length <= 2) {
                input.value = value;
            } else if (value.length === 3) {
                input.value = value.substring(0, 2) + '/' + value.substring(2);
            } else if (value.length === 4) {
                input.value = value.substring(0, 2) + '/' + value.substring(2);
            } else if (value.length > 4) {
                input.value = value.substring(0, 2) + '/' + value.substring(2, 4);
            }
        }

        function validateForm(event) {
            const name = document.getElementById('card_name').value.trim();
            const formattedNumber = document.getElementById('card_number').value.trim();
            const formattedExpiry = document.getElementById('card_expiry').value.trim();
            const number = formattedNumber.replace(/\s/g, ''); // Remove spaces for validation and submission
            const expiry = formattedExpiry.replace('/', ''); // Remove slash for validation and submission
            const cvv = document.getElementById('card_cvv').value.trim();

            if (!name || !number || !expiry || !cvv) {
                alert("Please fill in all payment details.");
                return false;
            }

            const onlyDigits = /^\d+$/;

            if (!onlyDigits.test(number) || !onlyDigits.test(expiry) || !onlyDigits.test(cvv)) {
                alert("Card details must contain only numbers.");
                return false;
            }

            if (number.length !== 16) {
                alert("Card number must be 16 digits.");
                return false;
            }

            if (expiry.length !== 4) {
                alert("Expiry must be 4 digits (MMYY).");
                return false;
            } else {
                const month = parseInt(expiry.substring(0, 2));
                if (month < 1 || month > 12) {
                    alert("Please enter a valid month (01-12).");
                    return false;
                }
            }

            if (cvv.length !== 3) {
                alert("CVV must be 3 digits.");
                return false;
            }
            document.getElementById('loader-overlay').style.display = 'flex';

            // Set the raw values to the *hidden* input fields for submission
            document.getElementById('card_number').value = number;
            document.getElementById('card_expiry').value = expiry;

            setTimeout(() => {
                document.getElementById('paymentForm').submit(); // manually submit
            }, 7000); // adjust timing as needed

            return false;
        }
    </script>


</body>

</html>