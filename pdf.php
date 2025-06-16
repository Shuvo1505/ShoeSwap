<?php
session_start();
if ($_SESSION["status"] === "active"){

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user'])) {
    $userId = $_SESSION['userId'];
    $product_id = $_POST['product_id'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $category = $_POST['category'];
    $shoe_usage = $_POST['shoe_usage'];
    $order_created = $_POST['order_created'];
    $gender = $_POST['gender'];
    $size = $_POST['size'];
    $purchasing_price = $_POST['purchasing_price'];
    $selling_price = $_POST['selling_price'];

    if (empty($userId) || empty($product_id) || empty($brand) || empty($type) || empty($category) ||
    empty($shoe_usage) || empty($order_created) || empty($gender) || empty($size) ||
    empty($purchasing_price) || empty($selling_price)) {
    
    echo "<script>alert('Required fields are missing.'); window.location.replace('myorder.php');</script>";
    exit;
}

    // Fetch user details from DB
    require('auth/database.php');
    $userQuery = "SELECT *  FROM user WHERE userId = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $userResult = $stmt->get_result();
    $userData = $userResult->fetch_assoc();

    $addressQuery = "SELECT *  FROM addresses WHERE userId = ?";
    $stmt_addr = $conn->prepare($addressQuery);
    $stmt_addr->bind_param("i", $userId);
    $stmt_addr->execute();
    $other_address_Result = $stmt_addr->get_result();
    $other_address_Data = $other_address_Result->fetch_assoc();

    if (!$userData) {
        echo "<script>alert('User data not found!'); window.location.replace('myorder.php');</script>";
        //session_destroy();
        //exit;
    }
    if (!$other_address_Data) {
        echo "<script>alert('Address data not found!'); window.location.replace('myorder.php');</script>";
        //session_destroy();
        //exit;
    }

    require('fpdf/fpdf.php');

    class PDF extends FPDF
    {
        function Header()
        {
            $this->Image('images/icons/website_logo.png', 10, 10, 10);
            $this->SetFont('Arial', 'B', 16);
            $this->Cell(0, 10, 'ShoeSwap [Buyer Receipt]', 0, 0, 'C');
            $this->Ln(20);
        }

        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(0, 10, 'ShoeSwap | INDIA', 0, 0, 'L');
        }

        function generatePDF($user, $address, $order_created, $brand, $type, $category, $shoe_usage, $gender, $size, $selling_price)
        {
            $this->AddPage();
            $this->SetFont('Arial', '', 12);

            // Customer Info
            $this->Cell(0, 10, 'Customer Information', 1, 1, align: 'C');
            $this->Cell(0, 10, 'Name: ' . $user['FNAME'] . ' ' . $user['LNAME'], 0, 1);
            $this->Cell(0, 10, 'Email: ' . $user['EMAIL_ID'], 0, 1);
            $this->Cell(0, 10, 'Phone Number: +91 ' . $user['PHONE_NUMBER'], 0, 1);
            $this->MultiCell(0, 8, 'Location: '.$user['STATE']. ', '. $user['CITY'].': '.$user['PIN'], 0, 'L');
            $this->Ln(10);
            
            // Delivery Details
            $this->Cell(0, 10, 'Delivery Details', 1, 1, 'C');
            $this->Cell(0, 10, 'Order Placed: ' . $order_created, 0, 1);
            $delivery_date = date('Y-m-d', strtotime('+7 days', strtotime($order_created)));
            $this->Cell(0, 10, 'Delivery Date: ' . $delivery_date, 0, 1);
            $this->MultiCell(0, 8, 'Delivery Address: ' . $address['fullName']. ' | '. '+91 '. $address['phoneNumber']."\n".$address['house'].', '.$address['area'].' - '.$address['landmark'].', '.$address['state']. ', '. $address['city'].': '.$address['pincode'], 0, 'L');
            $this->Ln(10);
            
            // Order Details
            $this->Cell(0, 10, 'Order Details', 1, 1, 'C');
            $this->Ln(10);

            $this->SetFont('Arial', 'B', 12);
            $this->Cell(30, 10, 'Brand', 1, 0);
            $this->Cell(30, 10, 'Type', 1, 0);
            $this->Cell(30, 10, 'Category', 1, 0);
            $this->Cell(40, 10, 'Duration', 1, 0);
            $this->Cell(30, 10, 'Gender', 1, 0);
            $this->Cell(20, 10, 'Size', 1, 1);

            $this->SetFont('Arial', '', 12);
            $this->Cell(30, 10, $brand, 1, 0);
            $this->Cell(30, 10, $type, 1, 0);
            $this->Cell(30, 10, $category, 1, 0);
            $this->Cell(40, 10, $shoe_usage, 1, 0);
            $this->Cell(30, 10, $gender, 1, 0);
            $this->Cell(20, 10, $size, 1, 1);

            // Totals
            $this->Ln(10);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Total', 0, 1);
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, 'Sub Total: Rs ' . $selling_price . ' /- ', 0, 1);
            $this->Cell(0, 10, 'Total Amount: Rs ' . $selling_price . ' /- ', 0, 1);
        }
    }

    $pdf = new PDF();
    $pdf->generatePDF($userData, $other_address_Data, $order_created, $brand, $type, $category, $shoe_usage, $gender, $size, $selling_price);
    $file = time() . '.pdf';
    $pdf->Output($file, 'D');
    exit;

} else {
    echo "<script>alert('Something went wrong!'); window.location.replace('myorder.php');</script>";
    exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>
