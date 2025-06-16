<?php
require 'ping_test.php';
include("../auth/database.php");
session_start();//--------Starting session to get user 
// Establish database connection
include('session_check.php');

// Check connection
if (!$conn) { 
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the product ID was sent
    if (isset($_POST["product_id"])) {
        $product_id = $_POST["product_id"];
        // Do something with the product ID, like add it to the cart
        // Check if the product is already in the cart
        if (!checkWishlist($product_id, $conn)) {
            // Product does not exist in the cart, so add it
            addToWishList($product_id, $conn);
        } else {
            echo '<script>alert("Already Exist.")</script>';
            // header("Location: ../Home.php");
            header("Refresh:0 ; url=../wishlist.php");
        exit();
        }
        

        
}
}
function checkWishlist($product_id, $conn) {
    // Check if the product is already in the cart
    $sql = "SELECT * FROM wishlist WHERE shoes_id = $product_id AND user= '{$_SESSION['username']}'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // Product already exists in the cart
        return true;
    } else {
        // Product does not exist in the cart
        return false;
    }
}

// Add the product to the cart
// function addToWishList($product_id, $conn) {
//     // Add the product to the cart
//     $sql = "SELECT * FROM shoes WHERE id = $product_id";
//     $result = mysqli_query($conn, $sql);
//     if (mysqli_num_rows($result) > 0) {
//         // Fetch the product data
//         $row = mysqli_fetch_assoc($result);
        
//         // Insert the product data into the cart table

//         // ------------------old---------------
//         // $sql = "INSERT INTO wishlist (id,brand, type,category,shoe_usage,gender, size,status,purchase_price,selling_price,user, seller_name, seller_location, image_url, description)
//         //         VALUES ('$product_id','".$row["brand"]."', '".$row["type"]."', '".$row["category"]."', '".$row["shoe_usage"]."', '".$row["gender"]."', '".$row["size"]."', '".$row["status"]."', '".$row["purchase_price"]."','".$row["selling_price"]."', '".$_SESSION['user']."', '".$row["seller_name"]."', '".$row["seller_location"]."', '".$row["image_url"]."', '".$row["description"]."')";
//         // ------------------------New---------
//         $sql = "INSERT INTO wishlist (user, shoes_id)
//         VALUES ( '".$_SESSION['user']."','$product_id',)";
//         mysqli_query($conn, $sql);
//         // Redirect to the back page
//         header("Location:  ../wishlist.php");
//         exit;
//     }
    
// }
function addToWishList($product_id, $conn) {
  
        $sql = "INSERT INTO wishlist (user, shoes_id)
        VALUES ( '".$_SESSION['username']."','$product_id')";
        mysqli_query($conn, $sql);
        // Redirect to the back page
        header("Location:  ../wishlist.php");
        exit;
    
    
}
?>
