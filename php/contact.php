<?php
// DB credentials
$servername = "localhost";
$username = "root";
$password = ""; // update if your MySQL has a password
$dbname = "shoeswap";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data safely
$name = mysqli_real_escape_string($conn, $_POST['name']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$phno = mysqli_real_escape_string($conn, $_POST['phno']);
$msg = mysqli_real_escape_string($conn, $_POST['msg']);

// Insert query
$sql = "INSERT INTO contact (name, email, phno, msg) VALUES ('$name', '$email', '$phno', '$msg')";

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Message sent successfully!'); window.location.href='../index.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
