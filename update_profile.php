<?php
require 'php/ping_test.php';
session_start();

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

if ($_SESSION["status"] === "active") {
    include('auth/database.php');
    $userId = $_SESSION['userId'];

    // Collect and sanitize form inputs
    $fname = trim(mysqli_real_escape_string($conn, $_POST['fname']));
    $lname = trim(mysqli_real_escape_string($conn, $_POST['lname']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $state = trim(mysqli_real_escape_string($conn, $_POST['state']));
    $city = trim(mysqli_real_escape_string($conn, $_POST['city']));
    $pin = trim(mysqli_real_escape_string($conn, $_POST['pin']));
    $phone_number = trim(mysqli_real_escape_string($conn, $_POST['phone_number']));
    $security_ques = trim(mysqli_real_escape_string($conn, $_POST['security_ques']));
    
    // Check for empty fields and length conditions
    if (empty($fname) || empty($lname) ||
        empty($state) || empty($city) || empty($security_ques) || empty($pin) || 
        empty($phone_number) ||
        !ctype_digit($phone_number) || !ctype_digit($security_ques) ||
        !isValidPhoneNumber($phone_number) || !isValidPinCode($pin) ||
        !isValidEmail($email) || 
        strlen($fname) > 15 || strlen($lname) > 15 || strlen($state) > 100 || 
        strlen($city) > 100 || strlen($security_ques) != 4 || strlen($pin) != 6 || 
        strlen($phone_number) != 10 || !preg_match('/^[0-9]+$/', $pin) || 
        !preg_match('/^[0-9]+$/', $phone_number)) {
            
        header("Location: profile.php?status=failed");
        exit();
    }          

    // Update query
    $query = "UPDATE user 
              SET FNAME = ?, 
                  LNAME = ?,
                  EMAIL_ID = ?,
                  STATE = ?, 
                  CITY = ?, 
                  PIN = ?, 
                  PHONE_NUMBER = ?, 
                  SECURITY_QUES = ?
              WHERE userid = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssssssssi", $fname, $lname,
    $email, $state, $city, $pin, $phone_number, $security_ques, $userId);

    if ($stmt->execute()) {
        // Success: redirect to profile page
        header("Location: profile.php?status=success");
    } else {
        // Error: go back to edit page or show error
        echo "Error updating profile: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();

} else {
    // Not logged in
    header("Location: login.php");
    exit();
}
?>
