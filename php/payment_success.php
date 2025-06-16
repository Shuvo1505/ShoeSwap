<?php
require 'ping_test.php';
include("../auth/database.php");

require '../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
session_start();
include('session_check.php');
function sendOrderConfirmation($email){
        
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'system.vacation.rental@gmail.com';
            $mail->Password = 'aafiydmizxllcysy'; // App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            $mail->setFrom('system.vacation.rental@gmail.com', 'ShoeSwap');
            $mail->addAddress($email ?? '');
    
            $mail->isHTML(true);
            $mail->Subject = 'Order placed successfully';
            $mail->Body = '
            <!DOCTYPE html>
<html>
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dddddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }
        .details {
            margin: 20px 0;
        }
        .details p {
            font-size: 16px;
            line-height: 1.5;
            color: #333333;
        }
        .details b {
            color: #007bff;
        }
        .call-to-action {
            background-color: #007bff;
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 4px;
            margin-top: 20px;
            font-size: 18px;
        }
        .call-to-action p {
            margin: 0;
        }
        .footer {
            text-align: center;
            color: #666666;
            font-size: 14px;
            margin-top: 30px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2>Excitement on the way!</h2>
    </div>
    
    <p>Dear User,</p>
    
    <p>We’re excited to let you know that your order has been successfully placed with <b>ShoeSwap</b>. 
    Your stylish shoes are being packed with care and will be shipped to you shortly!</p>

    <!-- Call to Action Section -->
    <div class="call-to-action">
        <p>🛍️ We’ll deliver your order within 4-6 working days. Stay tuned!</p>
    </div>

    <p>For any queries, feel free to reach us at <a href="mailto:system.vacation.rental@gmail.com">support@shoeswap.com</a>.</p>
    
    <p>Thanks again for shopping with us. We can’t wait for you to enjoy your new kicks!</p>
    
    <div class="footer">
        <p>Best regards,<br>The ShoeSwap Team</p>
    </div>
</div>
</body>
</html>
            ';
            $mail->send();
        } catch (Exception $e) {
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
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (
        isset($_POST['card_name'], $_POST['card_number'], $_POST['card_expiry'], $_POST['card_cvv'], $_POST['address_id']) &&
        isset($_SESSION['user'], $_SESSION['userId'])
    ) {
        $cardname = $_POST['card_name'];
        $cardnumber = $_POST['card_number'];
        $cardexpiry = $_POST['card_expiry'];
        $cardcvv = $_POST['card_cvv'];
        $addressId = $_POST['address_id'];
        $user = $_SESSION['username'];
        $userId = $_SESSION['userId'];

        if (
            empty($cardnumber) || strlen($cardnumber) != 16 || !ctype_digit($cardnumber) ||
            empty($cardexpiry) || strlen($cardexpiry) != 4 || !ctype_digit($cardexpiry) ||
            empty($cardcvv) || strlen($cardcvv) != 3 || !ctype_digit($cardcvv) ||
            empty($cardname) || strlen($cardname) > 50
        ) {
            echo "<script>alert('Operation aborted!'); window.location.replace('../make_payment.php');</script>";
            exit;
        }        

        $sql = "SELECT * FROM cart WHERE user='$user'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $lastOrderId = null;

            while ($row = $result->fetch_assoc()) {
                $shoesId = $row['shoes_id'];

                // Insert into orders with userId and delivery_option
                $insertOrder = "INSERT INTO `order` (shoes_id, user, userId, addressId)
                                VALUES ('$shoesId', '$user', '$userId','$addressId')";
                $conn->query($insertOrder);
                $lastOrderId = $conn->insert_id;

                // Mark shoe as sold
                $conn->query("UPDATE shoes SET status = 'Sold' WHERE id = $shoesId");
                $conn->query("DELETE FROM wishlist WHERE shoes_id = $shoesId AND user = '$user'");
            }

            if ($lastOrderId) {
                // Delete only current user's cart items
                $conn->multi_query("DELETE FROM cart WHERE user = '$user'");

                // Store payment
                $insertPayment = "INSERT INTO payment (card_name, card_number, card_expiry, card_cvv, order_id)
                                  VALUES ('$cardname', '$cardnumber', '$cardexpiry', '$cardcvv', $lastOrderId)";
                $conn->query($insertPayment);
             
                sendOrderConfirmation($_SESSION["user_email"]);
                    $_SESSION['message'] = [
                        'type' => 'success', // Bootstrap color: success, danger, warning, etc.
                        'text' => 'Payment successful. Order placed!'
                    ];
                    header("Location: ../myorder.php");
                    exit;
                    
                
                
            } else {
               
                $_SESSION['message'] = [
                    'type' => 'danger',
                    'text' => 'Order failed. Please try again.'
                ];
                header("Location: ../myorder.php");
                exit;
            }
        } else {
            $_SESSION['message'] = [
                'type' => 'warning',
                'text' => 'Your cart is empty.'
            ];
            header("Location: ../myorder.php");
            exit;
        }
    } else {
        $_SESSION['message'] = [
            'type' => 'warning',
            'text' => 'Missing payment or session details.'
        ];
        header("Location: ../myorder.php");
        exit;
    }
}
?>