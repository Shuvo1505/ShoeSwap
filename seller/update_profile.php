<?php
require 'php/ping_test.php';
session_start();

include 'constants/session_config.php';
if (!$is_logged_in){
    header("Location: login.php");
    exit;
}
include('../auth/database.php');

$conn = new mysqli($host, $username, $password, "shoeswap");

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

function isValidEmail(string $email): bool {
    // Use PHP's built-in filter
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

function validateGovtId($type, $number) {
    switch ($type) {
        case 'Aadhar Card':
            return preg_match('/^\d{12}$/', $number); // 12 digits
        case 'Voter Card':
            return preg_match('/^[A-Z]{3}\d{7}$/i', $number); // e.g., ABC1234567
        case 'PAN Card':
            return preg_match('/^[A-Z]{5}\d{4}[A-Z]$/i', $number); // e.g., ABCDE1234F
        case 'Passport':
            return preg_match('/^[A-Z]\d{7}$/i', $number); // e.g., A1234567
        default:
            return false;
    }
}

$user = $_SESSION['s_user'];

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$fname = trim(mysqli_real_escape_string($conn, $_POST['fname']));
$lname = trim(mysqli_real_escape_string($conn, $_POST['lname']));
$email = trim(mysqli_real_escape_string($conn, $_POST['email']));
$phone = trim(mysqli_real_escape_string($conn, $_POST['phone']));
$address = trim(mysqli_real_escape_string($conn, $_POST['address']));
$city = trim(mysqli_real_escape_string($conn, $_POST['city']));
$pin = trim(mysqli_real_escape_string($conn, $_POST['pin']));
$security = trim(mysqli_real_escape_string($conn, $_POST['security']));
$govt_id = trim(mysqli_real_escape_string($conn, $_POST['govt_id_type']));
$govt_num = trim(mysqli_real_escape_string($conn, $_POST['govt_id_num']));

if (
    // Empty checks
    empty($fname) ||
    empty($lname) ||
    empty($email) ||
    empty($phone) ||
    empty($address) ||
    empty($city) ||
    empty($pin) ||
    empty($security) ||
    empty($govt_id) || empty($govt_num) ||

    // Length checks 
    strlen($fname) > 15 ||
    strlen($lname) > 15 ||
    strlen($email) > 50 ||
    strlen($phone) != 10 ||
    strlen($address) > 30 ||
    strlen($city) > 30 ||
    strlen($pin) != 6 ||
    strlen($govt_id) > 50 || strlen($govt_num) > 12 ||
    strlen($security) != 4 ||

    // PIN and phone number: only digits check
    !ctype_digit($pin) ||
    !validateGovtId($govt_id, $govt_num) ||
    !ctype_digit($phone) || !isValidEmail($email) || !isValidPhoneNumber($phone)
    || !isValidPinCode($pin)
){
    echo "<script>alert('Profile updation failed!'); window.location.replace('dashboard.php');</script>";
    exit;
}

$sql = "UPDATE seller 
        SET 
            FNAME = ?, 
            LNAME = ?, 
            EMAIL_ID = ?, 
            PHONE_NUMBER = ?, 
            ADDRESS = ?, 
            CITY = ?, 
            PIN = ?, 
            SECURITY_QUES = ?,
            GOVT_ID_TYPE = ?,
            ID_NUMBER = ?
        WHERE 
            USERNAME = ?";
            $updateStmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param(
                $updateStmt,
                "sssssssssss",
                $fname,
                $lname,
                $email,
                $phone,
                $address,
                $city,
                $pin,
                $security,
                $govt_id,
                $govt_num,
                $user
            );

            if (mysqli_stmt_execute($updateStmt)) {
                echo "<script>alert('Profile updated successfully!'); window.location.href='dashboard.php';</script>";
                exit;
            } else {
                echo "<script>alert('Profile updation failed!'); window.location.href='dashboard.php';</script>";
            }
        
            mysqli_stmt_close($updateStmt);

$conn->close();
?>
