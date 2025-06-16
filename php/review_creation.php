<?php
require 'ping_test.php';
session_start();
include('session_check.php');
include('../auth/database.php');
if (isset($_POST['product_id'], $_POST['comment'], $_POST['rating'])) {
    // Retrieve the form input values
    $product_id = $_POST['product_id'];
    $userId = $_SESSION['userId'];  // Assuming session stores userId
    echo $product_id." ".$userId;
    
    // Retrieve the sellerId using seller_name from the shoes table
    $sql_seller = "SELECT sellerId FROM seller WHERE USERNAME = (SELECT seller_name FROM shoes WHERE id = '$product_id')";
    $result_seller = mysqli_query($conn, $sql_seller);
    
    if ($result_seller && mysqli_num_rows($result_seller) > 0) {
        $row_seller = mysqli_fetch_assoc($result_seller);
        $sellerId = $row_seller['sellerId'];
    } else {
        echo "Error retrieving seller: " . mysqli_error($conn);
        exit;
    }

    // Retrieve the comment and rating values
    $comment = trim($_POST['comment']);
    $rating = $_POST['rating'];

    // Validate the comment
    if (empty($comment)) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Please enter a comment!'];
        header('Location: ../myorder.php');
        exit;
    }

        // This regex allows letters (a-z, A-Z), numbers (0-9), spaces, and common punctuation.
        // Adjust the pattern as needed for your specific allowed characters.
        $pattern = "/^[a-zA-Z0-9\s.,!?'\"()&\-]+$/"; // Example: alphanumeric, space, .,!?'"()&-
        if (!preg_match($pattern, $comment)) {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Comment contains invalid characters. Please use only letters, numbers, and common punctuation.'];
            header('Location: ../myorder.php');
            exit;
        }

    // Validate the rating
    if (!is_numeric($rating) || $rating < 1 || $rating > 5) {
        $_SESSION['message'] = ['type' => 'danger', 'text' => 'Invalid rating. Please select a rating between 1 and 5.'];
        header('Location: ../myorder.php');
        exit;
    }

    // Check if a review already exists for the product and user
    $checkReviewSql = "SELECT * FROM comment WHERE shoes_id = '$product_id' AND userId = '$userId'";
    $checkReviewResult = mysqli_query($conn, $checkReviewSql);

    if (mysqli_num_rows($checkReviewResult) > 0) {
        // If the review exists, update the existing review
        $updateSql = "UPDATE comment 
                      SET comment = '$comment', rating = '$rating', created_at = CURRENT_TIMESTAMP 
                      WHERE shoes_id = '$product_id' AND userId = '$userId'";

        if (mysqli_query($conn, $updateSql)) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Review updated successfully.'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Error updating review.'];
        }
    } else {
        // If the review doesn't exist, insert a new review
        $insertSql = "INSERT INTO comment (userId, sellerId, shoes_id, comment, rating) 
                      VALUES ('$userId', '$sellerId', '$product_id', '$comment', '$rating')";

        if (mysqli_query($conn, $insertSql)) {
            $_SESSION['message'] = ['type' => 'success', 'text' => 'Review submitted successfully.'];
        } else {
            $_SESSION['message'] = ['type' => 'danger', 'text' => 'Error submitting review.'];
        }
    }

    // Close the database connection
    mysqli_close($conn);

    // Redirect to myorder.php
    header('Location: ../myorder.php');
    exit;
} else {
    echo "Invalid request.";
}
?>
