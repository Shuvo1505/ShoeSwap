<?php
require 'php/ping_test.php';
session_start();

if ($_SESSION["status"] === "active"){

include('auth/database.php');

if ($_SESSION["status"] !== "active") {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['userId'];

// Fetch all addresses
$query = "SELECT * FROM addresses WHERE userId = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Initialize variables
$addresses = [];

while ($row = $result->fetch_assoc()) {
    $addresses[] = $row;
}
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['address_id'])) {
    $_SESSION['selected_address_id'] = $_POST['address_id'];
    header("Location: make_payment.php");
    exit();
    }
} else {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Choose Address</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <?php include('constants/navbar_other.php'); ?>

    <div class="container mt-5">
        <h3>Select Delivery Address</h3>
        <hr>
        <?php if (!empty($addresses)): ?>
            <div class="d-flex justify-content-start">
            <p><strong style="color: green;">Default permanent address</strong></p>
            </div>
        <?php endif; ?>

        <form method="POST" action="make_payment.php" onsubmit="return validateSelection()">
            <?php if (!empty($addresses)): ?>
                <?php foreach ($addresses as $row): ?>
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="address_id"
                                    value="<?= $row['addressId'] ?>" id="address_<?= $row['addressId'] ?>"
                                    <?php if (isset($_SESSION['selected_address_id']) && $_SESSION['selected_address_id'] == $row['addressId']) echo 'checked'; ?>>
                                <label class="form-check-label" for="address_<?= $row['addressId'] ?>">
                                    <strong><?= htmlspecialchars($row['fullName']) ?></strong>
                                    (Phone: +91 <?= htmlspecialchars($row['phoneNumber']) ?>)<br>
                                    <?= htmlspecialchars($row['house']) ?>, <?= htmlspecialchars($row['area']) ?>,
                                    <?= htmlspecialchars($row['landmark']) ?><br>
                                    <?= htmlspecialchars($row['city']) ?>, <?= htmlspecialchars($row['state']) ?> -
                                    <?= htmlspecialchars($row['pincode']) ?>
                                </label>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No addresses found. Please add an address to continue.</p>
            <?php endif; ?>

            <div class="d-flex justify-content-between align-items-center m-3">
                <?php if (empty($addresses)): ?>
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                        data-bs-target="#addAddressModal" onclick='return confirm("This will be your fixed delivery address. For now, adding multiple addresses are not supported. Please enter your address carefully.")'>
                        + Add New Address
                    </button>
                <?php endif; ?>

                <?php if (!empty($addresses)): ?>
                    <button type="submit" class="btn btn-success">Proceed to Payment</button>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="php/add_Address.php" method="post" id="addAddressForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-2">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" name="full_name" required maxlength="31">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">House No. / Building Name</label>
                                <input type="text" class="form-control" name="house" required maxlength="100">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Road Name / Area / Colony</label>
                                <input type="text" class="form-control" name="area" required maxlength="100">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <label class="form-label">Landmark (Nearby)</label>
                                <input type="text" class="form-control" name="landmark" maxlength="100">
                            </div>

                            <?php require 'constants/city_states_section.php'; ?>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save Address</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <?php if (isset($_SESSION['address_success'])): ?>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
            <div id="addressToast" class="toast align-items-center text-white bg-success border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $_SESSION['address_success'];
                        unset($_SESSION['address_success']); ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
        <script>
            // Show success toast
            var successToast = new bootstrap.Toast(document.getElementById('addressToast'));
            successToast.show();
        </script>
    <?php elseif (isset($_SESSION['address_error'])): ?>
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
            <div id="addressErrorToast" class="toast align-items-center text-white bg-danger border-0" role="alert"
                aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $_SESSION['address_error'];
                        unset($_SESSION['address_error']); ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        </div>
        <script>
            // Show error toast
            var errorToast = new bootstrap.Toast(document.getElementById('addressErrorToast'));
            errorToast.show();
        </script>
    <?php endif; ?>

    <script>
        function validateSelection() {
            const radios = document.getElementsByName('address_id');
            for (let i = 0; i < radios.length; i++) {
                if (radios[i].checked) return true;
            }
            alert("Please select an address before proceeding.");
            return false;
        }
    </script>
    <?php include('constants/footer.php'); ?>
</body>

</html>