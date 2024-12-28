<?php 
session_start();
include('../conn.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>log-in</title>
</head>
<style>
    body{
        text-shadow: 0 0.05rem 0.1rem rgba(0, 0, 0, 0.5);
        margin: 0;
        padding: 0;
    }

    .container{
        width: 400px;
        margin: 80px auto;
        padding: 30px;
        background-color: #fff;
        box-shadow: inset 0 0 5rem rgba(0, 0, 0, 0.5); 
        
        & h1{
            text-align: center;
            margin-bottom: 20px;
        }

        & form{
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        & label{
            display: block;
            margin-bottom: 5px;
        }

        & input[type="text"]{
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
        }

        & input[type="email"]{
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            margin-bottom: 15px;
        }
        
        & button{
            width: 100%;
            padding: 10px 20px;
            background-color: #1976d2;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    }



</style>
<body>
    <main>
        <?php
        @$ADemail=$_POST['email'];
        @$ADpassword = $_POST['password'];
        @$ADadd = $_POST['add'];

        if(isset($ADadd)){
            if(empty($ADemail) || empty($ADpassword)){
                echo '<script>alert("please enter email and password");</script>';
            }
            else{
                $query = "SELECT *FROM `admin-log` WHERE email='$ADemail' AND password='$ADpassword' ";
                $result = mysqli_query($con,$query);
                if(mysqli_num_rows($result) ==1){
                    $_SESSION['email'] = $ADemail;
                    echo '<script>alert("Hello, You will be transferred to the admin panel");</script>';
                    header("REFRESH:2; URL = adminpanel.php ");
                }
                else{
                    echo '<script>alert("You are not allowed to sin in this page, You will be transferred to shopping");</script>';
                    header("REFRESH:2; URL = ../index.php ");
                }

            }
        }

        
        
        ?>
        <div class="container">
            <h1>Log in</h1>
            <form action="login.php" method="post" >
                <label for="email">Email</label>
                <input type="email" name="email" id="email" >
                <br>
                <label for="pass">Password</label>
                <input type="text" name="password" id="pass" >
                <br>
                <button type="submit" name="add" > Log in </button>
            </form>
        </div>
    </main>
</body>
</html>

