<?php
require 'ping_test.php';
session_start();
include '../auth/database.php'; // adjust the path as needed
include('session_check.php');
function isValidPhoneNumber(string $phoneNumber): bool {

    // Check if all digits are the same
    if (preg_match('/^(\d)\1{9}$/', $phoneNumber) === 1) {
        return false;
    }

    // Reject known sequential patterns
    $invalidPatterns = ['1234567890', '0123456789', '1234567899','0123456788'];
    if (in_array($phoneNumber, $invalidPatterns)) {
        return false;
    }

    return true;
}

function isValidPinCode(string $pinCode): bool {

    // Check if all digits are the same (e.g., 111111)
    if (preg_match('/^(\d)\1{5}$/', $pinCode) === 1) {
        return false;
    }

    // Reject known sequential patterns
    $invalidPatterns = ['123456', '012345'];
    if (in_array($pinCode, $invalidPatterns)) {
        return false;
    }

    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch and sanitize input
    $userId = $_SESSION['userId']; // assuming user is logged in and userId is stored in session

    $fullName = trim($_POST['full_name']);
    $phoneNumber = trim($_POST['phone']);
    $pincode = trim($_POST['pin']);
    $state = trim($_POST['state']);
    $city = trim($_POST['city']);
    $house = trim($_POST['house']);
    $area = trim($_POST['area']);
    $landmark = trim($_POST['landmark']);

// Basic validation
if (
    empty($fullName) || empty($phoneNumber) || empty($pincode) || empty($state) ||
    empty($city) || empty($house) || empty($area) || !isValidPhoneNumber($phoneNumber)
    || !isValidPinCode($pincode)
) {
    echo "
        <script>alert('Invalid input!'); window.location.replace('../choose_address.php');</script>
    ";
    exit;
}

// Length validation
if (
    empty($fullName) || strlen($fullName) > 31 ||
    empty($house) || strlen($house) > 100 ||
    empty($area) || strlen($area) > 100 ||
    empty($landmark) || strlen($landmark) > 100 ||
    empty($state) || strlen($state) > 100 ||
    empty($city) || strlen($city) > 100 ||
    empty($phoneNumber) || strlen($phoneNumber) != 10 || !ctype_digit($phoneNumber) ||
    empty($pincode) || strlen($pincode) != 6 || !ctype_digit($pincode) ||
    !isValidPhoneNumber($phoneNumber) || !isValidPinCode($pincode)
) {
    echo "
        <script>alert('Invalid input!'); window.location.replace('../choose_address.php');</script>
    ";
    exit;
}

    // Insert address
    $insertQuery = "INSERT INTO addresses 
        ( userId, fullName, phoneNumber, pincode, state, city, house, area, landmark) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("issssssss",  $userId, $fullName, $phoneNumber, $pincode, $state, $city, $house, $area, $landmark);

    if ($stmt->execute()) {
        // Success: Show success message and redirect
        $_SESSION['address_success'] = "Address added successfully!";
        header("Location: ../choose_address.php"); // Redirect after success
        exit;
    } else {
        // Error: Show error message
        $_SESSION['address_error'] = "Failed to add address. Please try again.";
        header("Location: ../choose_address.php"); // Redirect after success
        exit;
    }
}
?>
