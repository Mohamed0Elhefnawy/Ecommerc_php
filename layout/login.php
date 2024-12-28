<!-- <?php
// الاتصال بقاعدة البيانات
// include('../conn.php');
// session_start();


// if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
//     $email = $_POST['email'];
//     $password = $_POST['password'];

//     // البحث عن المستخدم بناءً على البريد الإلكتروني
//     $query = "SELECT * FROM customers WHERE email = ?";
//     $stmt = $con->prepare($query);
//     $stmt->bind_param("s", $email);
//     $stmt->execute();
//     $result = $stmt->get_result();

//     if ($result->num_rows > 0) {
//         $user = $result->fetch_assoc();
//         $_SESSION['first_name'] = $user['first_name'];

//         // التحقق من كلمة المرور
//         if (password_verify($password, $user['password'])) {
//             // تسجيل الدخول ناجح
//             $_SESSION['user_id'] = $user['id'];
//             echo 'Login successful! Welcome ' . $user['first_name'];

//             header("Location: ../index.php?");
//         } else {
//             echo 'Invalid password!';
//         }
//     } else {
//         echo 'No user found with this email!';
//     }
// }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/logreg.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> 
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-sign-in-alt"></i> Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login"><i class="fas fa-sign-in-alt"></i> Login</button>
            <p>For registration? <a href="register.php">register here</a>.</p>
        </form>
    </div>
</body>
</html> -->

<?php

include('../conn.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    
    $query = "SELECT * FROM customers WHERE email = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['first_name'] = $user['first_name'];

        // التحقق من حالة التفعيل
        if ($user['is_verified'] == 0) {
            echo '<script>alert("Your account has not been verified. Please check your email for the verification link.");</script>';
        } 
        else {
          
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                echo 'Login successful! Welcome ' . $user['first_name'];
                header("Location: ../index.php");  
                exit(); // تأكد من إيقاف تنفيذ الكود بعد التوجيه
            } else {
                echo '<script>alert("Invalid password!");</script>';
            }
        }
    } else {
        echo '<script>alert("No user found with this email!");</script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/logreg.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- ربط FontAwesome -->
</head>
<body>
    <div class="container">
        <h2><i class="fas fa-sign-in-alt"></i> Login</h2>
        <form action="login.php" method="POST">
            <div class="form-group">
                <i class="fas fa-envelope"></i>
                <input type="email" name="email" placeholder="Email" required>
            </div>
            <div class="form-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" name="login"><i class="fas fa-sign-in-alt"></i> Login</button>
            <p>Don't have an account? <a href="register.php">Register here</a>.</p>
        </form>
    </div>
</body>
</html>
