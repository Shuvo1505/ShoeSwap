<?php
require 'ping_test.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../constants/session_config.php';
// Connect to MySQL database
$host="localhost";
$username="root";
$password="";
$dbname = "shoeswap";

$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($current_user === ''){
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

// Construct the SQL query with a WHERE clause for searching
$seller = $_SESSION["s_user"];
$sql = "SELECT * FROM shoes
        WHERE seller_name = '$seller'
        AND status = 'Listed'";

if (!empty($searchTerm)) {
    $sql .= " AND (
        brand LIKE '%{$searchTerm}%'
    )";
}

$result = $conn->query($sql);

// Check if there are any rows returned
if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {

        //img src is using php because the data is falling on homepage_seller page and so we have to write the path from that location and hence we are mentioning the php before img url
        echo "<div class='card  p-3 m-5'>
                <div class='row g-0'>
                    <div class='col-md-4'>
                        <img src='php/".$row["image_url"]."' class='img-fluid rounded-start' alt='Shoe Image'>
                    </div>
                    <div class='col-md-8'>
                        <div class='card-body'>
                            <h5 class='card-title'>".$row["brand"]."</h5>
                            <h6 class='card-subtitle mb-2 text-muted'>".$row["type"]."</h6>
                            <p class='card-text'>".$row["description"]."</p>
                            <p class='card-text'><strong>Size:</strong> ".$row["size"]."</p>
                            <p class='card-text'><strong>Price:</strong> ".$row["selling_price"]."</p>
                            <div class='d-flex'>
                                <form action='' method='post' class='me-2'>
                                    <input type='hidden' name='product_id' value='".$row["id"]."'>
                                    <p class='card-text'><span class='badge bg-warning text-dark'>Listed</span></p>
                                </form>
                                <form action='php/remove_item.php' method='post' onsubmit='return confirm(\"Do you want to delete this item from your stock?\")'>
                                    <input type='hidden' name='product_id' value='".$row["id"]."'>
                                <button type='submit' class='btn btn-outline-danger btn-sm'>Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>";

    }

} else {
    echo "<img src='images/empty_cart.png' width='40%' class='d-block mx-auto'>";
}

$conn->close();
?>