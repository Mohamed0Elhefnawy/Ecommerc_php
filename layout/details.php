<?php
// الاتصال بقاعدة البيانات
include('../conn.php');

// استرجاع تفاصيل المنتج بناءً على المعرف (id)
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);
    $query = "SELECT * FROM products WHERE id = $product_id";
    $result = mysqli_query($con, $query);

    if ($result) {
        $product = mysqli_fetch_assoc($result);
    } else {
        echo "Product not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفاصيل المنتج</title>
    <link rel="stylesheet" href="../css/details.css">
    <!-- ربط مكتبة Font Awesome للأيقونات -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>

<div class="container">
    <?php if (isset($product)) { ?>
    <div class="product-details">
        <div class="product-image">
            <img src="../uploads/img/<?php echo $product['pimg']; ?>" alt="صورة المنتج">
        </div>
        <div class="product-info">
            <h1 class="product-title"><?php echo $product['pname']; ?></h1>
            <p class="product-description"><?php echo $product['pdescrip']; ?></p>
            <div class="product-section"> section: <?php echo $product['psection']; ?></div>
            <div class="product-price"> price: $<?php echo $product['pprice']; ?></div>
            <div class="product-size">
                size: <?php echo $product['psize']; ?>
            </div>
            <div class="product-availability">
                <?php echo ($product['punavail'] == 1) ? ' <i class="fa-solid fa-x"></i> unavailable' : ' <i class="fa-solid fa-check"></i> available'; ?>
            </div>
            <form method="POST" action="cart.php">
                <div class="quant">
                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                    <input type="number" id="quantity" name="quantity" value="1" min="0" max="10" >
                </div>
                <a href="cart.php">
                    <button class="add-to-cart-btn" name="add_to_cart"  type="submit" ><i class="fas fa-shopping-cart"></i>add to cart</button>
                </a>
            </form>
        </div>
    </div>
    <?php } else { ?>
    <p>المنتج غير موجود.</p>
    <?php } ?>
</div>

</body>
</html>
