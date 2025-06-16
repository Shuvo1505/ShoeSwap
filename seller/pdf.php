<?php
session_start();

include 'constants/session_config.php';
if (!$is_logged_in){
    header("Location: login.php");
    exit;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../auth/database.php');
    $conn=mysqli_connect($host,$username,$password,'shoeswap');
    $product_id = $_POST['product_id'];
    $seller_uname = $_SESSION['s_user'];

    $sql = "SELECT s.*, o.created_date FROM shoes s JOIN `order` o ON s.id = o.shoes_id  WHERE s.id = '$product_id'";
    $sql_seller_data = "SELECT FNAME, LNAME, EMAIL_ID, PHONE_NUMBER, ADDRESS, CITY, PIN FROM seller WHERE USERNAME = '$seller_uname' ";
    $sql_pickup_address = "SELECT fullName, phoneNumber, pincode, state, city, house, area, landmark FROM `addresses` WHERE addressId = (SELECT addressId FROM `order` WHERE shoes_id = '$product_id')";
    
    $result = $conn->query($sql);
    $result_seller_info = $conn->query($sql_seller_data);
    $result_pickup_address = $conn->query($sql_pickup_address);

    $seller_fname = '';
    $seller_lname = '';
    $seller_email = '';
    $seller_phone = '';
    $seller_address = '';

    $pickup_address = '';
    
   
    if ($result->num_rows > 0 && $result_seller_info->num_rows > 0 && $result_pickup_address->num_rows > 0) {
        $row = $result->fetch_assoc();
        $row_seller_info = $result_seller_info->fetch_assoc();
        $row_pickup_address = $result_pickup_address->fetch_assoc();
    
        // Access the details

        //SELLER DETAILS
        $seller_fname = $row_seller_info['FNAME'];
        $seller_lname = $row_seller_info['LNAME'];
        $seller_email = $row_seller_info['EMAIL_ID'];
        $seller_phone = '+91 '. $row_seller_info['PHONE_NUMBER'];
        $seller_address = $row_seller_info['ADDRESS'].', '.$row_seller_info['CITY'].': '.$row_seller_info['PIN'];

        $_SESSION['sellerfname'] = $seller_fname;
        $_SESSION['sellerlname'] = $seller_lname;
        $_SESSION['selleremail'] = $seller_email;
        $_SESSION['sellerphone'] = $seller_phone;
        $_SESSION['selleraddress'] = $seller_address;
        
        //PICKUP DETAILS
        $order_created = $row['created_date'];
        $user_pickup = $row_pickup_address['house'].' '.$row_pickup_address['area'].', '.$row_pickup_address['landmark'].' - '.$row_pickup_address['state'].', '.$row_pickup_address['city'].': '.$row_pickup_address['pincode'];
        $pickup_name = $row_pickup_address['fullName'];
        $pickup_contact = '+91 '.$row_pickup_address['phoneNumber'];
        
        $_SESSION['deliveryaddress'] = $user_pickup;
        $_SESSION['pickupname'] = $pickup_name;
        $_SESSION['pickupcontact'] = $pickup_contact;
        
        

// Use the increased date as needed
// ...

        
        //shoe_details
        $brand = $row['brand'];
        $type = $row['type'];
        $category = $row['category'];
        $shoeUsage = $row['shoe_usage'];
        $gender = $row['gender'];
        $size=$row['size'];
        $selling_price=$row['selling_price'];
    
        // Use the fetched details as needed
        // ...

if (empty($seller_fname) || empty($seller_lname) || empty($seller_email) || empty($seller_phone) || empty($seller_address) ||
    empty($order_created) || empty($user_pickup) || empty($pickup_name) || empty($pickup_contact) ||
    empty($brand) || empty($type) || empty($category) || empty($shoeUsage) || empty($gender) || empty($size) || empty($selling_price)) {
    
    echo "<script>alert('Required details are missing!'); window.location.replace('ordered_seller.php');</script>";
    exit;
}
   
    
    

    require('fpdf/fpdf.php');

    class PDF extends FPDF
    {
        // Header
        function Header()
        {
            $this->Image('images/website_logo.png', 10, 10, 10);
            $this->SetFont('Arial', 'B', 16);
            $this->Cell(0, 10, 'ShoeSwap [Seller Receipt]', 0, 0, 'C');
            // width, height, text, border, line break, alignment
            $this->Ln(20);
        }

        // Footer
        function Footer()
        {
            $this->SetY(-15);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(0, 10, 'ShoeSwap | Shipping Logistics | INDIA', 0, 0, 'L');
        }

        // Generate PDF
        function generatePDF($brand, $type, $category, $shoe_usage, $gender,$order_created, $size, $selling_price)
        {
            $this->AddPage();
            $this->SetFont('Arial', '', 12);

            // Customer Information
            $this->Cell(0, 10, 'Seller Information', 1, 1, 'C');
            $this->Cell(0, 10, 'Name: '.$_SESSION['sellerfname'].' '.$_SESSION['sellerlname'].'', 0, 1);
            $this->Cell(0, 10, 'Email: '.$_SESSION['selleremail'].'', 0, 1);
            $this->Cell(0, 10, 'Phone Number: '.$_SESSION['sellerphone'].'', 0, 1);
            $this->MultiCell(0, 8, 'Address: '.$_SESSION['selleraddress'].'', 0, 'L');
            $this->Ln(10);
            // Delivery Details
            $this->Cell(0, 10, 'Delivery Details', 1, 1, 'C');
            $this->Cell(0, 10, 'Order Placed: '.$order_created, 0, 1);
            $createdDate = $order_created;
            $pickupDate = date('Y-m-d', strtotime($createdDate . ' +1 day'));
        
            // Add seven days to the order date
            $this->Cell(0, 10, 'Delivery Date: '.$pickupDate, 0, 1);
            $this->Cell(0, 10, 'Person Name: '.$_SESSION['pickupname'].'', 0, 1);
            $this->Cell(0, 10, 'Person Contact: '.$_SESSION['pickupcontact'].'', 0, 1);
            $this->MultiCell(0, 8, 'Shipping Address: '.$_SESSION['deliveryaddress'], 0, 'L');
            $this->Ln(10);
            // Order Details
            $this->Cell(0, 10, 'Order Details', 1, 1, 'C');
            $this->Ln(10); // Add a line space of 10 units
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(30, 10, 'Brand', 1, 0);
            $this->Cell(30, 10, 'Type', 1, 0);
            $this->Cell(30, 10, 'Category', 1, 0);
            $this->Cell(40, 10, 'Duration', 1, 0);
            $this->Cell(30, 10, 'Gender', 1, 0);
            $this->Cell(20, 10, 'Size', 1, 1);
           
            
            

            $this->SetFont('Arial', '', 12);
            $this->Cell(30, 10, $brand ,1, 0);
            $this->Cell(30, 10, $type, 1, 0);
            $this->Cell(30, 10, $category, 1, 0);
            $this->Cell(40, 10, $shoe_usage, 1, 0);
            $this->Cell(30, 10, $gender, 1, 0);
            $this->Cell(20, 10, $size, 1, 1);
            

            // Total
            $this->Ln(10);
            $this->SetFont('Arial', 'B', 12);
            $this->Cell(0, 10, 'Total', 0, 1);
            $this->SetFont('Arial', '', 12);
            $this->Cell(0, 10, 'Sub Total: Rs ' .$selling_price.' /- ', 0, 1);
            $this->Cell(0, 10, 'Total Amount: Rs '.$selling_price.' /- ', 0, 1);
        }
    }
    $pdf = new PDF();
    $pdf->generatePDF($brand, $type, $category, $shoeUsage, $gender, $order_created, $size, $selling_price);
    $file=time().'.pdf';
    $pdf->Output($file,'D');
    unset($_SESSION['sellerfname'], $_SESSION['sellerlname'], $_SESSION['selleremail'], $_SESSION['sellerphone'], $_SESSION['selleraddress'], $_SESSION['deliveryaddress'], $_SESSION['pickupname'], $_SESSION['pickupcontact']);
    } else {
        echo "<script>alert('Something went wrong!'); window.location.replace('ordered_seller.php');</script>";
        unset($_SESSION['sellerfname'], $_SESSION['sellerlname'], $_SESSION['selleremail'], $_SESSION['sellerphone'], $_SESSION['selleraddress'], $_SESSION['deliveryaddress'], $_SESSION['pickupname'], $_SESSION['pickupcontact']);
        exit;
    }
} else {
    echo "<script>alert('Something went wrong!'); window.location.replace('ordered_seller.php');</script>";
    exit;
}
$conn->close();
?>
