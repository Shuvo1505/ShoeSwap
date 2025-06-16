<?php
require 'ping_test.php';
// Connect to MySQL database
$host = "localhost";
$username = "root";
$password = "";
$dbname = "shoeswap";

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) { 
    die("Connection failed: " . $conn->connect_error);
}

// Start Session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION["s_user"])){
    http_response_code(403);
    echo '
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>403 Forbidden</title>
<style>
body {
  margin: 0;
  padding: 0;
  background-color: #fff3f3;
  font-family: "Segoe UI", sans-serif;
  display: flex;
  justify-content: center;
  align-items: center;
  height: 100vh;
  color: #e74c3c;
}
.container {
  text-align: center;
  border: 2px dashed #e74c3c;
  border-radius: 16px;
  padding: 40px;
  background-color: #ffffff;
  box-shadow: 0 0 15px rgba(0,0,0,0.05);
}
h1 {
  font-size: 48px;
  margin-bottom: 10px;
}
p {
  font-size: 20px;
}
</style>
</head>
<body>
<div class="container">
<h1>403 Forbidden</h1>
<p>Kangaroos can\'t jump here!</p>
</div>
</body>
</html>
';
exit;
}

// Retrieve the search term from the POST request
$searchTerm = isset($_POST['search']) ? mysqli_real_escape_string($conn, $_POST['search']) : '';


// Retrieve shoe data from database
$sql = "SELECT * FROM shoes
        WHERE seller_name = '{$_SESSION["s_user"]}'
        AND status = 'sold'";

if (!empty($searchTerm)) {
    $sql .= " AND (
        brand LIKE '%{$searchTerm}%'
    )";
}
$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {

    while ($row = $result->fetch_assoc()) {
        echo "<div class='card p-3 m-5'>
                <div class='row g-0'>
                    <div class='col-md-4'>
                        <img src='php/" . $row["image_url"] . "' class='img-fluid rounded-start' alt='Shoe Image'>
                    </div>
                    <div class='col-md-8'>
                        <div class='card-body'>
                            <h5 class='card-title'>" . $row["brand"] . "</h5>
                            <h6 class='card-subtitle mb-2 text-muted'>" . $row["type"] . "</h6>
                            <p class='card-text'>" . $row["description"] . "</p>
                            <p class='card-text'><strong>Size:</strong> " . $row["size"] . "</p>
                            <p class='card-text'><strong>Price:</strong> " . $row["selling_price"] . "</p>";

        // Fetch the created_date for the shoes_id from the order table
        $orderSql = "SELECT created_date FROM `order` WHERE shoes_id = '" . $row["id"] . "'";
        $orderResult = $conn->query($orderSql);

        if ($orderResult->num_rows > 0) {
            $orderRow = $orderResult->fetch_assoc();
            $createdDate = strtotime($orderRow['created_date']);
            $currentDate = time();
            $daysDifference = floor(($currentDate - $createdDate) / (60 * 60 * 24));

            if ($daysDifference > 2) {
                echo "<p class='card-text'><span class='badge bg-success'>Sold</span></p>";
            } else {
                echo "<p class='card-text'><span class='badge bg-warning text-dark'>Item will be picked soon</span></p>";
            }
        } else {
            echo "<p class='card-text'><span class='badge bg-secondary'>Sold</span></p>";
        }

        echo "<form action='pdf.php' method='post'>
                            <input type='hidden' name='product_id' value='" . $row["id"] . "'>
                            <button type='submit' class='btn btn-outline-primary btn-sm mt-2'>Invoice</button>
                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>";
    }

} else {
    echo "<script>alert('No order to display!'); window.location.replace('../seller/homepage_seller.php');</script>";
    exit;
}
?>
