<?php
session_start();
include('../conn.php');
// معالجة إضافة المنتج إلى سلة الشراء
if (isset($_POST['add_to_cart'])) {
    @$product_id = $_POST['product_id'];
    @$quantity = $_POST['quantity'];

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]['quantity'] += $quantity;
    } else {
        $_SESSION['cart'][$product_id] = array('product_id' => $product_id, 'quantity' => $quantity);
    }

    header("Location: cart.php");
    exit();
}

// معالجة حذف منتج من سلة الشراء
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];

    if (isset($_SESSION['cart'][$product_id])) {
        unset($_SESSION['cart'][$product_id]);
    }

    header("Location: cart.php");
    exit();
}

// دالة لاسترجاع تفاصيل المنتج من قاعدة البيانات
function getProductFromDB($conn, $product_id) {
    $query = "SELECT * FROM products WHERE id = " . intval($product_id); // استخدم intval لتجنب SQL Injection
    $result = mysqli_query($conn, $query);
    return mysqli_fetch_assoc($result);
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>سلة الشراء</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../css/header.css">
    <style>
        /* تنسيق عام للصفحة */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            
        }
        .cart-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            margin-bottom: 20px;
            color: #333;
        }
        .cart-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .cart-table th, .cart-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }
        .cart-table th {
            background-color: #f8f8f8;
            color: #555;
        }
        .cart-table td {
            color: #333;
        }
        .total {
            margin-bottom: 20px;
        }
        .total h3 {
            color: #444;
        }
        .remove-btn {
            background-color: #ff4d4d;
            color: #fff;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
        }
        .remove-btn:hover {
            background-color: #e60000;
        }
        .checkout-btn {
            background-color: #28a745;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .checkout-btn:hover {
            background-color: #218838;
        }
        .img_size{
            width: 50px;
            height: 50px;
        }
    </style>
</head>
<body>
    <header id="sjs" class="flex" >
        <!--start logo -->
        <a href="../index.php" class="logo">
            <i class="fa-solid fa-bag-shopping"></i>
            <span class="span-img" style="font-weight: bold;">ALAMIN</span class="span-img">
            <P style="letter-spacing: 3.8px;font-weight: 500; ">Shopping</P>
        </a href="/">
        <!-- end logo -->
        <!-- search bar -->
        <div class="search">
            <form action="">
                <input type="text" name="" class="search_input" placeholder="Search for ">
                <button class="button_search" name="btn_search">search</button>
            </form>
        </div>
    </header>
    <!-- start departments an social -->
    <nav class="flex"  >
        <div class="social">
            <ul>
                <li><a href="" target_blank ><i class="fa-brands fa-facebook"></i></a></li>
                <li><a href="" target_blank ><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="" target_blank ><i class="fa-brands fa-youtube"></i></a></li>
            </ul>
        </div>
        <ul class="department" >
            <li><a href="index.php">HOME</a></li>
                
                <?php
                $query ="SELECT * FROM sections";
                $result = mysqli_query($con,$query);
                while($row=mysqli_fetch_assoc($result)){
                ?>
                    
                <li><a href=""><?php echo $row['sec_name'] ?></a></li>

                

                <?php
                }
                ?>
        </ul>

    </nav>
    <!-- end departments an social -->
    <!-- start part last-post -->
    <div class="last-post ">
        <h3>Most popular</h3>
        <ul>
            <li><a href=""><span class="span-img"><img src="../image/4.webp" alt=""></span></a></li>
            <li><a href=""><span class="span-img"><img src="../image/2.webp" alt=""></span></a></li>
            <li><a href=""><span class="span-img"><img src="../image/3.webp" alt=""></span></a></li>
        </ul>

            <!-- start-cart -->
        <div class="cart" >
            <ul>
                <li>
                    <a href="sign_up.php">
                        <i class="fa-solid fa-user" ></i>
                    </a>
                </li>
                <li class="cart-num" >
                    <a href="layout/cart.php">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <span class="cart-count">2</span class="span-img">
                </li>
            </ul>
        </div>
    </div>

    <div class="cart-container">
        <h1>سلة الشراء</h1>

        <table class="cart-table">
            <thead>
                <tr>
                    <th>الصورة</th>
                    <th>المنتج</th>
                    <th>الكمية</th>
                    <th>السعر</th>
                    <th>الإجمالي</th>
                    <th>إزالة</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $total = 0;
                if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    foreach ($_SESSION['cart'] as $item) {
                        $product = getProductFromDB($con, $item['product_id']);
                        if ($product) { // تأكد من أن المنتج موجود
                            $subtotal = $product['pprice'] * $item['quantity'];
                            $total += $subtotal;
                            
                            $_SESSION['total'] = $total; // إجمالي المبلغ
                            echo "<tr>
                                    <td><img class='img_size' src='../uploads/img/{$product['pimg']}'></td>
                                    <td>{$product['pname']}</td>
                                    <td>{$item['quantity']}</td>
                                    <td>{$product['pprice']} دينار</td>
                                    <td>{$subtotal} دينار</td>
                                    <td>
                                        <form method='POST'>
                                            <input type='hidden' name='product_id' value='{$item['product_id']}'>
                                            <button type='submit' name='remove_from_cart' class='remove-btn'>إزالة</button>
                                        </form>
                                    </td>
                                </tr>";

                        }
                    }
                } else {
                    echo "<tr><td colspan='5'>سلة الشراء فارغة</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="total">
            <h3>المجموع الكلي: <?php echo $total; ?> دينار</h3>
        </div>

        <form action="cheekout.php" method="POST" >
            <button name="checkout" class="checkout-btn">إتمام الشراء</button>
        </form>
        
    </div>

</body>
</html>
