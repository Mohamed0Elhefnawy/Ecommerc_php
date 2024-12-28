<?php
// الاتصال بقاعدة البيانات
// include('../conn.php');
// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
//     $first_name = $_POST['first_name'];
//     $last_name = $_POST['last_name'];
//     $email = $_POST['email'];
//     $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  // تشفير كلمة المرور
//     $phone = $_POST['phone'];
//     $address = $_POST['address'];
//     $city = $_POST['city'];
//     $country = $_POST['country'];


//     $check_query = "SELECT * FROM customers WHERE email='$email' LIMIT 1";
//     $result = mysqli_query($con, $check_query);
//     $user = mysqli_fetch_assoc($result);
//     if ($user) { // إذا كان البريد الإلكتروني موجود بالفعل
//         echo "<script>alert('Email already exists');</script>";
//     }
//     else{
//         $query = "INSERT INTO customers (first_name, last_name, email, password, phone, address, city, country, created_at)
//         VALUES ('$first_name', '$last_name', '$email', '$password', '$phone', '$address', '$city', '$country', NOW())";
//         $result=mysqli_query($con,$query);
//         //$id = mysqli_insert_id($con);
        

//         if ($result){
//         $_SESSION['email'] = $email;
//         echo 'Registration successful!';
//         header("Location: login.php");
//         } else {
//         echo 'Error: ' . $con->error;
//         }
//     }

    
    
// }

?>
<?php
include('../conn.php');
use PHPMailer\PHPMailer\PHPMailer;  

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);  
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $country = $_POST['country'];
    $verification_code = md5(uniqid(rand(), true));  

    // التحقق مما إذا كان البريد الإلكتروني موجودًا بالفعل
    $check_query = "SELECT * FROM customers WHERE email='$email' LIMIT 1";
    $result = mysqli_query($con, $check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { 
        echo "<script>alert('Email already exists');</script>";
    } else {
        
        $query = "INSERT INTO customers (first_name, last_name, email, password, phone, address, city, country, verification_code, is_verified, created_at)
                  VALUES ('$first_name', '$last_name', '$email', '$password', '$phone', '$address', '$city', '$country', '$verification_code', 0, NOW())";
        $result = mysqli_query($con, $query);

        if ($result) {
            
            require 'C:\xampp\htdocs\Ecommerc\layout\PHPMailer-master\src\Exception.php';
            require 'C:\xampp\htdocs\Ecommerc\layout\PHPMailer-master\src\PHPMailer.php';
            require 'C:\xampp\htdocs\Ecommerc\layout\PHPMailer-master\src\SMTP.php';

            $mail = new PHPMailer();
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';  
            $mail->SMTPAuth = true;
            $mail->Username = 'exampel@gmail.com';  
            $mail->Password = '000000000000000';  
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('hefnawy7122002@gmail.com', 'ALAMIN SHOPING');  
            $mail->addAddress($email);

            $mail->isHTML(true);
            $mail->Subject = 'Email Verification';
            $mail->Body    = "Hi $first_name, <br><br> Please verify your email by clicking the link below:<br><br>
            <a href='http://localhost/Ecommerc/layout/verify.php?code=$verification_code&email=$email'>Verify Email</a><br><br>Thanks!";

            if ($mail->send()) {
                header("Location: verify.php");
                echo "<script>alert('Registration successful! Please check your email for verification.');</script>";
            } else {
                echo "<script>alert('Error: Could not send verification email.');</script>";

            }
        } else {
            echo 'Error: ' . $con->error;
        }
    }
}
?>



<!-- <!DOCTYPE html>
<html lang="en"> -->
<!-- <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/logreg.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
</head> -->
<!-- <body>
    <div class="container">
        <h2><i class="fas fa-user-plus"></i> Register</h2>
        <form action="register.php" method="POST">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="first_name" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="last_name" placeholder="Last Name" required>
                <i class="fas fa-user"></i>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
                <i class="fas fa-envelope"></i>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
                <i class="fas fa-lock"></i>
            </div>
            <div class="form-group">
                <input type="text" name="phone" placeholder="Phone" required>
                <i class="fas fa-phone"></i>
            </div>
            <div class="form-group">
                <input type="text" name="address" placeholder="Address" required>
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="form-group">
                <input type="text" name="city" placeholder="City" required>
                <i class="fas fa-city"></i>
            </div>
            <div class="form-group">
                <input type="text" name="country" placeholder="Country" required>
                <i class="fas fa-flag"></i>
            </div>
            <button type="submit" name="register"><i class="fas fa-paper-plane"></i> Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html> -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/logreg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- ربط FontAwesome -->
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-user-plus"></i> Register</h2>
        <form action="register.php" method="POST">
            <div class="form-group">
                <i class="fas fa-user"></i>
                <input type="text" name="first_name" placeholder="First Name" required>
            </div>
            <div class="form-group">
                <input type="text" name="last_name" placeholder="Last Name" required>
                <i class="fas fa-user"></i>
            </div>
            <div class="form-group">
                <input type="email" name="email" placeholder="Email" required>
                <i class="fas fa-envelope"></i>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Password" required>
                <i class="fas fa-lock"></i>
            </div>
            <div class="form-group">
                <input type="text" name="phone" placeholder="Phone" required>
                <i class="fas fa-phone"></i>
            </div>
            <div class="form-group">
                <input type="text" name="address" placeholder="Address" required>
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="form-group">
                <input type="text" name="city" placeholder="City" required>
                <i class="fas fa-city"></i>
            </div>
            <div class="form-group">
                <input type="text" name="country" placeholder="Country" required>
                <i class="fas fa-flag"></i>
            </div>
            <button type="submit" name="register"><i class="fas fa-paper-plane"></i> Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a>.</p>
    </div>
</body>
</html>
