<?php
require 'php/ping_test.php';
require 'vendor/autoload.php';
include('auth/database.php');

session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SESSION["status"] === "active"){

if (isset($_POST['cancel']) && isset($_POST['your_order_id'])) {
    $shoeId = $_POST['product_id'];
    $orderId = $_POST['your_order_id'];

    $sql = "UPDATE `shoes` SET `status` = 'Listed' WHERE `id` = '" . $_POST["product_id"] . "'";
    $result = $conn->query($sql);

    if ($result) {
        // Delete the item from the order table

        $deleteSql_payment = "DELETE FROM `payment` WHERE `order_id` = $orderId";
        $deleteResult_payment = $conn->query($deleteSql_payment);

        $deleteSql = "DELETE FROM `order` WHERE `order_id` = $orderId";
        $deleteResult = $conn->query($deleteSql);

        if ($deleteResult && $deleteResult_payment) {
            sendOrderCancellation();
        } else {
            echo "<script>alert('Failed to cancel this order!'); window.location.replace('myorder.php');</script>";
        }
    } else {
        echo "<script>alert('Failed to update the order status!'); window.location.replace('myorder.php');</script>";
    }
    }
} else {
    header("Location: login.php");
    exit;
}

function sendOrderCancellation(){
    $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'system.vacation.rental@gmail.com';
            $mail->Password = ''; // App password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('system.vacation.rental@gmail.com', 'ShoeSwap');
            $mail->addAddress($_SESSION["user_email"] ?? '');

            $mail->isHTML(true);
            $mail->Subject = 'Order cancellation';
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
        <h2 style="color: red;">Oops, Maybe you\'re not happy!</h2>
        </div>

        <p>Dear User,</p>

        <p>We’re sorry to inform you that your order with <b>ShoeSwap</b> has been successfully <b>cancelled</b>. 
        If this was unintentional or you have any questions, please feel free to reach out to our support team.</p>
        <p>We hope to serve you again soon with the latest and trendiest footwear!</p>

        <!-- Call to Action Section -->
        <div class="call-to-action">
        <p>Goodbye, Stay safe and healthy!</p>
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
?>

<html>
    <head>
        <title>Processing</title>
    </head>
    <body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
            Swal.fire({
              title: 'Order Cancellation Processing',
              html: 'Don\'t close or refresh this window',
              timer: 6000,
              timerProgressBar: true,
              showConfirmButton: false,
              allowOutsideClick: false,
              allowEscapeKey: false,
              didOpen: () => {
                Swal.showLoading();
              }
            }).then((result) => {
              if (result.dismiss === Swal.DismissReason.timer) {
                window.location.replace('myorder.php');
              }
            });
        </script>
    </body>
</html>
