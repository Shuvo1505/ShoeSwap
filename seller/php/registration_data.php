<?php
require 'ping_test.php';
session_start();
$loginname = $_SESSION['seller_username'];

if (!isset($loginname)){
    header("Location: ../login.php");
    exit;
}

include('../../auth/database.php');
$conn = mysqli_connect($host, $username, $password, "shoeswap");

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

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Extract data from form
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$address = $_POST['address'];
$city = $_POST['city'];
$pin = $_POST['pin'];
$phone_number = $_POST['phone_number'];
$govt_id_type = $_POST['govt_id_type'];
$govt_id_number = $_POST['govt_id_number'];

if (
    empty($fname) || strlen($fname) > 15 ||
    empty($lname) || strlen($lname) > 15 ||
    empty($address) || strlen($address) > 30 ||
    empty($city) || strlen($city) > 30 ||
    !isValidPhoneNumber($phone_number) || !isValidPinCode($pin) ||
    empty($pin) || strlen($pin) !== 6 || !ctype_digit($pin) ||
    empty($phone_number) || strlen($phone_number) != 10 || !ctype_digit($phone_number) ||
    empty($govt_id_type) || strlen($govt_id_type) > 50 ||
    empty($govt_id_number) || strlen($govt_id_number) > 12
){
    echo "<script>alert('Operation aborted!'); window.location.replace('../regis_form.php');</script>";
    exit;
}

// Update query
$sql = "UPDATE seller 
        SET FNAME='$fname', 
            LNAME='$lname', 
            ADDRESS='$address', 
            CITY='$city', 
            PIN='$pin', 
            PHONE_NUMBER='$phone_number',
            GOVT_ID_TYPE='$govt_id_type',
            ID_NUMBER='$govt_id_number'

        WHERE USERNAME='$loginname'";

if (mysqli_query($conn, $sql)) {
    header("Location: ../login.php?status=success");
    session_destroy();
    exit;
} else {
    header("Location: ../regis_form.php");
    exit;
}
?>
