<?php
session_start();
include('../conn.php');

$order_id = $_GET['order_id'];

$query_invoice = "SELECT o.id, o.order_date, o.total, c.first_name, c.last_name, c.email, c.address, c.city, c.country
                  FROM orderes o
                  JOIN customers c ON o.user_id = c.id
                  WHERE o.id = '$order_id'";
$result_invoice = mysqli_query($con, $query_invoice);
$order = mysqli_fetch_assoc($result_invoice);

// إحضار تفاصيل المنتجات
$query_products = "SELECT p.pname, p.pprice, p.pimg, od.quantity FROM order_detail od
                   JOIN products p ON od.product_id = p.id
                   WHERE od.order_id = '$order_id'";
$result_products = mysqli_query($con, $query_products);


// send email for customer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'C:\xampp\htdocs\Ecommerc\layout\PHPMailer-master\src\Exception.php';
require 'C:\xampp\htdocs\Ecommerc\layout\PHPMailer-master\src\PHPMailer.php';
require 'C:\xampp\htdocs\Ecommerc\layout\PHPMailer-master\src\SMTP.php';


$customer_email = $order['email']; 
$total = $order['total']; 


$mail = new PHPMailer(true);

try {
    
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'example@gmail.com'; 
    $mail->Password = ''; 
    $mail->SMTPSecure = 'tls'; 
    $mail->Port = 587; 

    
    $mail->setFrom('hefnawy7122002@gmail.com', 'ALAMIN SHOPING');
    $mail->addAddress($customer_email); 

  
    $mail->isHTML(true);
    $mail->Subject = 'Order Confirmation - Invoice #'.$order_id;
    $mail->Body    = '
    <h1>Thank you for your order!</h1>
    <p>Your order has been received and is being processed.</p>
    <p>Order ID: ' . $order_id . '</p>
    <p>Total Amount: ' . $total . ' دينار</p>
    <p>We will notify you when your order has been shipped.</p>
    ';

   
    $mail->send();
    echo 'Message has been sent to ' . $customer_email;
    echo "<script>alert('Message has been sent to : {$customer_email}');</script>";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

//  end sed email for custormer

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <link rel="stylesheet" href="../css/checkout.css">
</head>
<body>
    <div class="invoice-container">
        <h2>Invoice</h2>
        <p>Order ID: <?php echo $order['id']; ?></p>
        <p>Date: <?php echo $order['order_date']; ?></p>
        <p>Customer: <?php echo $order['first_name'] . " " . $order['last_name']; ?></p>
        <p>Email: <?php echo $order['email']; ?></p>
        <p>Address: <?php echo $order['address'] . ", " . $order['city'] . ", " . $order['country']; ?></p>

        <h3>Products</h3>
        <table>
            <tr><th>image</th><th>Product</th><th>Price</th><th>Quantity</th><th>Total</th></tr>
            <?php while ($product = mysqli_fetch_assoc($result_products)) { 
                $subtotal = $product['pprice'] * $product['quantity'];
            ?>
            <tr>
                <td><img class="img_size" src="../uploads/img/<?php echo $product['pimg']; ?>"></td>
                <td><?php echo $product['pname']; ?></td>
                <td><?php echo $product['pprice']; ?></td>
                <td><?php echo $product['quantity']; ?></td>
                <td><?php echo $subtotal; ?></td>
            </tr>
            <?php } ?>
        </table>

        <h3>Total: <?php echo $order['total']; ?></h3>
    </div>
</body>
</html>
