<?php
require 'ping_test.php';
include("../auth/database.php");
session_start();//--------Starting session to get user 
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
        
            // Product does not exist in the cart, so add it
            CancelOrder($product_id, $conn);
            // header("Location: ../Home.php");
            header("Refresh:0 ; url=../cart.php");
        exit();
        }
        

        
}


// function checkCart($product_id, $conn) {
//     // Check if the product is already in the cart

//     $sql = "SELECT * FROM cart WHERE id = $product_id AND user= '{$_SESSION['user']}'";
//     $result = mysqli_query($conn, $sql);
//     if (mysqli_num_rows($result) > 0) {
//         // Product already exists in the cart
//         return true;
//     } else {
//         // Product does not exist in the cart
//         return false;
//     }
// }

// Add the product to the cart
function CancelOrder($product_id, $conn) {
    // Add the product to the cart
    $sql = "SELECT * FROM cart WHERE shoes_id = $product_id";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        // Fetch the product data
        $row = mysqli_fetch_assoc($result);
        
        // Insert the product data into the cart table
        // $sql = "INSERT INTO shoes (id,brand, type, size, price, seller_name, seller_location, image_url, description)
        //         VALUES ('$product_id','".$row["brand"]."', '".$row["type"]."', '".$row["size"]."', '".$row["price"]."', '".$row["seller_name"]."', '".$row["seller_location"]."', '".$row["image_url"]."', '".$row["description"]."')";
        $sql="UPDATE shoes
        SET status = 'listed'
        WHERE id = $product_id";
        mysqli_query($conn, $sql);
        // Remove the product from the user's table
        $sql = "DELETE FROM cart WHERE shoes_id = $product_id ";
        mysqli_query($conn, $sql);
        // Redirect to the cart page
        header("Location: ../cart.php");
        exit;
    }
    
}
?>
