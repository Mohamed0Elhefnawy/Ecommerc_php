<?php 
session_start();
include('conn.php') ;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <link rel="stylesheet" href="./css/master.css">
    <link rel="stylesheet" href="./css/footer.css">
</head>
<style>
    .products_description a{
        margin: 5px;
        font-size: 12px;
        font-weight: 500;
        padding-top: 5px;
        padding-bottom: 5px;
        color: blue;
    }
</style>
<body>
    <header id="sjs" class="flex" >
        <!--start logo -->
        <a href="index.html" class="logo">
            <i class="fa-solid fa-bag-shopping"></i>
            <span class="span-img" style="font-weight: bold;">ALAMIN</span class="span-img">
            <P style="letter-spacing: 3.8px;font-weight: 500; ">Shopping</P>
        </a href="/">
        <!-- end logo -->
        
        <div class="name_user">
            <?php
            if (isset($_SESSION['first_name'])) {
                $first_name = $_SESSION['first_name'];
                echo " HI " .$first_name;
            } else {
                echo '<a href="layout/login.php" class="btn-login">Log in <i class="fas fa-sign-in-alt"></i></a>';
            }
            ?>
        </div>



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
            
            
                <?php
                $query ="SELECT * FROM sections";
                $result = mysqli_query($con,$query);
                while($row=mysqli_fetch_assoc($result)){
                ?>
                
                <li ><a href=""><?php echo $row['sec_name'] ?></a></li>

            

                <?php
                }
                ?>
                <li ><a href="index.php">HOME</a></li>
        </ul>

    </nav>
    <!-- end departments an social -->
    <!-- start part last-post -->
    <div class="last-post ">
        <h3>Most popular</h3>
        <ul>
            <?php
            $query = "SELECT * FROM products ORDER BY ID DESC LIMIT 2 ";
            $result = mysqli_query($con, $query);
            while($row = mysqli_fetch_assoc($result)){
            ?>
            
            <li><a href="layout/details.php? id=<?php echo $row['id'] ?>"><span class="span-img"><img src="uploads/img//<?php echo $row['pimg'] ?>" alt=""></span></a></li>
            
            <?php
            }
            ?>
        </ul>

        <!-- start-cart -->
        <div class="cart" >
            <ul>
                <li>
                    <a href="layout/register.php">
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
    <!-- end part last-post -->
    <!-- products -->
    <main>
        <?php
        $query = "SELECT * FROM products";
        $result = mysqli_query($con, $query);
        while($row = mysqli_fetch_assoc($result)){
            ?>
            
        
        <div class="product">
            <div class="product_img">
                <a href="layout/details.php?id=<?php echo $row['id']?>"><img width="200px" height="180px" src="uploads/img//<?php echo $row['pimg'] ?>" alt=""></a>
            </div>
            <div class="product_section">
                <a href=""><?php echo $row['psection'] ?></a>
            </div>
            <div class="product_name">
                <a href="layout/details.php? id=<?php echo $row['id']?>"><?php echo $row['pname'] ?></a>
            </div>
            <div class="product_price">
                <a href=""><?php echo $row['pprice'] ."$" ?></a>
            </div>
            <div class="products_description">
                <a href="layout/details.php? id=<?php echo $row['id']?>">Details Product</a>
            </div>
            <!-- n -->
            <form method="POST" action="layout/cart.php">
                <div class="quant">
                    <button class="qty_count_mins" >-</button>
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input type="number" id="quantity" name="quantity" value="1" min="0" max="10" >
                    <button class="qty_count_add" >+</button>
                </div>
                <div class="submit">
                    <a href="layout/cart.php">
                        <button class="addto_cart" type="submit" name="add_to_cart" >
                            <i class="fa-solid fa-cart-plus" ></i> Add to cart
                        </button>
                    </a>
                </div>
            </form>


        </div>
        <?php
        }
        ?>
        <!-- <div class="product">
            <div class="product_img">
                <a href=""><img width="250px" src="./image/3.webp" alt=""></a>
                <span class="unavailable" >unavailable</span>
            </div>
            <div class="product_section">
                <a href="">section</a>
            </div>
            <div class="product_name">
                <a href="">product name</a>
            </div>
            <div class="product_price">
                <a href="">100$</a>
            </div>
            <div class="product_description">
                <a href="">A product description is a piece of marketing copywriting that tells people what a product is
                    and why its worth buying
                </a>
            </div>
            <div class="quant">
                <button class="qty_count_mins" >-</button>
                <input type="number" id="quantity" name="" value="1" min="0" max="10" >
                <button class="qty_count_add" >+</button>
            </div>
            <div class="submit">
                <a href="">
                    <button class="addto_cart" type="submit" name="" >
                        <i class="fa-solid fa-cart-plus" ></i> Add to cart
                    </button>
                </a>
            </div>


        </div>
        <div class="product">
            <div class="product_img">
                <a href=""><img width="250px" src="./image/4.webp" alt=""></a>
            </div>
            <div class="product_section">
                <a href="">section</a>
            </div>
            <div class="product_name">
                <a href="">product name</a>
            </div>
            <div class="product_price">
                <a href="">100$</a>
            </div>
            <div class="product_description">
                <a href="">A product description is a piece of marketing copywriting that tells people what a product is
                    and why its worth buying
                </a>
            </div>
            <div class="quant">
                <button class="qty_count_mins" >-</button>
                <input type="number" id="quantity" name="" value="1" min="0" max="10" >
                <button class="qty_count_add" >+</button>
            </div>
            <div class="submit">
                <a href="">
                    <button class="addto_cart" type="submit" name="" >
                        <i class="fa-solid fa-cart-plus" ></i> Add to cart
                    </button>
                </a>
            </div>


        </div>
        <div class="product">
            <div class="product_img">
                <a href=""><img width="250px" src="./image/5.webp" alt=""></a>
            </div>
            <div class="product_section">
                <a href="">section</a>
            </div>
            <div class="product_name">
                <a href="">product name</a>
            </div>
            <div class="product_price">
                <a href="">100$</a>
            </div>
            <div class="product_description">
                <a href="">A product description is a piece of marketing copywriting that tells people what a product is
                    and why its worth buying
                </a>
            </div>
            <div class="quant">
                <button class="qty_count_mins" >-</button>
                <input type="number" id="quantity" name="" value="1" min="0" max="10" >
                <button class="qty_count_add" >+</button>
            </div>
            <div class="submit">
                <a href="">
                <button class="addto_cart" type="submit" name="" >
                    <i class="fa-solid fa-cart-plus" ></i> Add to cart
                </button>
            </a>
            </div>


        </div>
        <div class="product">
            <div class="product_img">
                <a href=""><img width="250px" src="./image/6.webp" alt=""></a>
            </div>
            <div class="product_section">
                <a href="">section</a>
            </div>
            <div class="product_name">
                <a href="">product name</a>
            </div>
            <div class="product_price">
                <a href="">100$</a>
            </div>
            <div class="product_description">
                <a href="">A product description is a piece of marketing copywriting that tells people what a product is
                    and why its worth buying
                </a>
            </div>
            <div class="quant">
                <button class="qty_count_mins" >-</button>
                <input type="number" id="quantity" name="" value="1" min="0" max="10" >
                <button class="qty_count_add" >+</button>
            </div>
            <div class="submit">
                <a href="">
                    <button class="addto_cart" type="submit" name="" >
                        <i class="fa-solid fa-cart-plus" ></i> Add to cart
                    </button>
                </a>
            </div>


        </div> -->
    </main>
    <footer>
        Designed and developed by
        <span> Mohamed Elhefnawy </span>
        © 2024.
        <a href="hefnawy7122002@gmail.com"> Contact Me </a>
    </footer>
</body>
</html>
