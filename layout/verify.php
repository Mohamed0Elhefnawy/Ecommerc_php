<?php
include('../conn.php');

$isVerified = false;
$message = '';

if (isset($_GET['code']) && isset($_GET['email'])) {
    $verification_code = $_GET['code'];
    $email = $_GET['email'];

    
    $stmt = $con->prepare("SELECT * FROM customers WHERE email = ? AND verification_code = ? AND is_verified = 0");
    $stmt->bind_param('ss', $email, $verification_code);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        
        $stmt = $con->prepare("UPDATE customers SET is_verified = 1 WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $isVerified = true;
        $message = "Email verified successfully. You can now login.";
    } else {
        $message = "Invalid verification link or your account is already verified.";
    }
} else {
    // $message = "Invalid request. No verification code found.";
    $message = "No verification code found, Please check your email for the verification link to go to login";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link rel="stylesheet" href="../css/verify.css"> 
    <script src="../js/verify.js"></script> 
</head>
<body>
    <div class="container">
        <div class="card">
            <h2 id="status-title"><?php echo $isVerified ? "Success!" : "Error"; ?></h2>
            <p id="status-message"><?php echo $message; ?></p>
            <button id="redirect-button">Go to Login</button>
        </div>
    </div>
</body>
</html>
