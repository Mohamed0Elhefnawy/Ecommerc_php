<?php
session_start();
include('../conn.php'); 
if (!isset($_SESSION['user_id'])) {
    header("Location: register.php"); // إعادة التوجيه لصفحة تسجيل الدخول إذا لم يكن المستخدم مسجل الدخول
    exit();
}


if (isset($_POST['checkout']) && isset($_SESSION['total'])) {
    $user_id = $_SESSION['user_id'];
    $total = $_SESSION['total'];
    $status = 'Pending';
    $order_date = date('Y-m-d H:i:s');

    // إدخال الطلب في جدول order
    $query_order = "INSERT INTO `orderes` (user_id, total, status, order_date) VALUES ('$user_id', '$total', '$status', '$order_date')";
    $result_order = mysqli_query($con, $query_order);
    $order_id = mysqli_insert_id($con); // الحصول على معرف الطلب

    // إدخال تفاصيل الطلب في جدول order_details
    foreach ($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];

        $query_order_details = "INSERT INTO order_detail (order_id, product_id, quantity) VALUES ('$order_id', '$product_id', '$quantity')";
        mysqli_query($con, $query_order_details);
    }

    // تفريغ سلة المشتريات
    unset($_SESSION['cart']);
    header("Location: invoice.php?order_id=$order_id");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" href="../css/checkout.css">
</head>
<body>
    <div class="checkout-container">
        <h2>Checkout</h2>
        <form action="checkout.php" method="POST">
            <p>Total Amount: <?php echo $total ; ?> </p>
            <button type="submit" name="checkout">Complete Purchase</button>
        </form>
    </div>
</body>
</html>

