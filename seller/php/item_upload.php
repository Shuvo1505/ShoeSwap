<?php
// Database connection details
require 'ping_test.php';
include("../../auth/database.php");
session_start();

// Create a new database connection
$conn = mysqli_connect($host, $username, $password, "shoeswap");
if (!$conn) {
    die("<script>Connection failed: </script>" . mysqli_connect_errno());
}

function hasSQLInjectionChars($input) {
    return !preg_match("/^[a-zA-Z0-9 ,.\-]+$/", $input);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Retrieve form data and escape special characters
    $gender = trim(isset($_POST["gender"]) && !empty($_POST["gender"]) ? mysqli_real_escape_string($conn, $_POST["gender"]) : null);
    $brand = trim(isset($_POST["brand-name"]) && !empty($_POST["brand-name"]) ? mysqli_real_escape_string($conn, $_POST["brand-name"]) : null);
    $type = trim(isset($_POST["type"]) && !empty($_POST["type"]) ? mysqli_real_escape_string($conn, $_POST["type"]) : null);
    $category = trim(isset($_POST["category"]) && !empty($_POST["category"]) ? mysqli_real_escape_string($conn, $_POST["category"]) : null);
    $usage = trim(isset($_POST["usage"]) && !empty($_POST["usage"]) ? mysqli_real_escape_string($conn, $_POST["usage"]) : null);
    $size = trim(isset($_POST["shoe-size"]) && !empty($_POST["shoe-size"]) ? mysqli_real_escape_string($conn, $_POST["shoe-size"]) : null);
    $purchase_price = trim(isset($_POST["pur_price"]) && !empty($_POST["pur_price"]) ? mysqli_real_escape_string($conn, $_POST["pur_price"]) : null);
    $sell_price = trim(isset($_POST["sell_price"]) && !empty($_POST["sell_price"]) ? mysqli_real_escape_string($conn, $_POST["sell_price"]) : null);
    $sellerName = trim(isset($_SESSION['s_user']) && !empty($_SESSION['s_user']) ? $_SESSION['s_user'] : null);
    $description = trim(isset($_POST["desc"]) && !empty($_POST["desc"]) ? mysqli_real_escape_string($conn, $_POST["desc"]) : null);
    
if (strlen($gender) > 50 || strlen($brand) > 30 || strlen($type) > 50 || strlen($category) > 50 || strlen($usage) > 50 || 
    strlen($size) > 10 || strlen($purchase_price) > 10 || strlen($sell_price) > 10 || strlen($sellerName) > 50 ||
    !is_numeric($purchase_price) || !is_numeric($sell_price) || 
    strlen($description) > 255) {
    echo "<script>alert('Operation aborted!'); window.location.replace('../homepage_seller.php');</script>";
    exit();
}

if (hasSQLInjectionChars($description)){
    echo "<script>alert('Description shouldn\'t contain any bad character or neither be empty!'); window.location.replace('../homepage_seller.php');</script>";
    exit();
}

if ($description == null){
    echo "<script>alert('Description shouldn\'t be empty!'); window.location.replace('../homepage_seller.php');</script>";
    exit();
}
// Price validations (must be decimal with 2 digits after decimal)
if (!preg_match('/^\d{1,8}(\.\d{1,2})?$/', $purchase_price) || 
    !preg_match('/^\d{1,8}(\.\d{1,2})?$/', $sell_price)) {
        echo "<script>alert('Wrong price formatting, It should be 3210.76 or 3211 like this.'); window.location.replace('../homepage_seller.php');</script>";
        exit();
}

if ($sell_price > $purchase_price){
    echo "<script>alert('Selling price should be lower than purchase price!'); window.location.replace('../homepage_seller.php');</script>";
    exit();
}

// Content moderation API credentials. Replace with your own credentials
$api_user = '';
$api_secret = '';

$allowedExtensions = ['jpg', 'jpeg', 'png'];
$allowedMimeTypes = ['image/jpeg', 'image/png', 'image/jpg'];
$maxFileSize = 5 * 1024 * 1024; // max 5MB limit of shoe image

function validateImage($file, $allowedExtensions, $allowedMimeTypes, $maxFileSize) {
    if ($file['error'] !== UPLOAD_ERR_OK || $file['size'] > $maxFileSize) return false;
    
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, $allowedExtensions)) return false;
    
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    
    finfo_close($finfo);
    
    if (!in_array($mime, $allowedMimeTypes)) return false;
    if (getimagesize($file['tmp_name']) === false) return false;
    return true;
}

function generateUniqueFileName($extension) {
    return bin2hex(random_bytes(16)) . '.' . $extension;
}

function moderateImage($filePath, $api_user, $api_secret) {
    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://api.sightengine.com/1.0/check.json',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'media' => new CURLFile($filePath),
            'models' => 'nudity,wad,offensive,face-attributes,gore',
            'api_user' => $api_user,
            'api_secret' => $api_secret
        ],
    ]);
    $response = curl_exec($ch);
    curl_close($ch);
    $result = json_decode($response, true);

    // Log API response for debugging
    //file_put_contents('debug_result.json', json_encode($result, JSON_PRETTY_PRINT));

    if (isset($result['error'])) return false;

    return (
        ($result['nudity']['raw'] ?? 0) <= 0.1 &&
        ($result['nudity']['partial'] ?? 0) <= 0.1 &&
        ($result['weapon'] ?? 0) <= 0.1 &&
        ($result['drugs'] ?? 0) <= 0.1 &&
        ($result['offensive']['prob'] ?? 0) <= 0.1 &&
        ($result['alcohol'] ?? 0) <= 0.1 &&
        ($result['gore']['prob'] ?? 0) <= 0.1 &&
        (empty($result['faces'])) &&
        ($result['minors'] ?? 0) <= 0.1
    );    
}

$uploadDir = __DIR__ . '/uploads/';
$images = ['main_image', 'first_image', 'second_image'];
$storedFiles = [];

foreach ($images as $imageField) {
    $file = $_FILES[$imageField];
    if (!validateImage($file, $allowedExtensions, $allowedMimeTypes, $maxFileSize)) {
        echo "<script>alert('Only allowed extrnsions are (.jpg .jpeg .png) and maximum file size 5MB!'); window.location.replace('../homepage_seller.php');</script>";
        exit;
    }
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $uniqueName = generateUniqueFileName($ext);
    $destination = $uploadDir . $uniqueName;

    if (!move_uploaded_file($file['tmp_name'], $destination)) {
        echo "<script>alert('Failed to upload!'); window.location.replace('../homepage_seller.php');</script>";
        exit;
    }
        
    if (!moderateImage($destination, $api_user, $api_secret)) {
        unlink($destination);
        echo "<script>alert('We will not allow to upload any illegal images!'); window.location.replace('../homepage_seller.php');</script>";
        exit;
    }

    $storedFiles[$imageField] = 'uploads/' . $uniqueName;
}

$stmt = $conn->prepare("INSERT INTO shoes (brand, type, category, shoe_usage, gender, size, purchase_price, selling_price, seller_name, image_url, image_url_f, image_url_s, description)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssssssssss", $brand, $type, $category, $usage, $gender, $size, $purchase_price, $sell_price, $sellerName, $storedFiles['main_image'], $storedFiles['first_image'], $storedFiles['second_image'], $description);

if ($stmt->execute()) {
    echo "<script>alert('Data uploaded successfully!'); window.location.replace('../homepage_seller.php');</script>";
} else {
    echo "<script>alert('Database insertion failed!'); window.location.replace('../homepage_seller.php');</script>";
    }
} else {
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
}

// Close the database connection
mysqli_close($conn);
?>
