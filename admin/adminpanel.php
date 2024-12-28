<?php 
session_start();
include('../conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>admin panel</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" 
    />
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- start add section -->
    <?php
    if(!isset($_SESSION['email'])){
        header('location:../index.php');
    }
    else{
    ?>
    <?php
    @$sec_name = $_POST['sec_name'];
    @$sec_add = $_POST['sec_add'];
    @$id=$_GET['id'];
    if(isset($sec_add)){
        if(empty($sec_name)){
            echo '<script> alert ("The field is empty. Fill in the field"); </script>';
        }
        elseif($sec_name < 50){
            echo '<script> alert ("section name is a very larg"); </script>';
        }
        else {
            $query = "INSERT INTO sections (sec_name)VALUES('$sec_name') ";
            $result = mysqli_query($con,$query);
            echo '<script> alert ("The section has been added successfully"); </script>';
        }
    }
    ?>
    <!-- end add section -->
    <!-- delet section -->

    <?php
    if(isset($id)){
        $query="DELETE FROM sections WHERE id='$id'";
        @$delet = mysqli_query($con,$query);
        if(isset($delet)){
            echo'<script> alert("dleted successfully"); </script>';
        }
        else{
            echo '<script> alert("Not deleted"); </script>';
        }
    }

    ?>
    <!-- end delet sections -->
    
    <!-- sidebar -->
    <div class="sidebar_container">
        <div class="sidebar">
            <h1>control panel </h1>
            <ul>
                <li><a href="../index.php" target="_blank"  >Home page <i class="fa-solid fa-house"></i> </a></li>
                <li><a href="product.php" target="_blank" >Products page <i class="fa-solid fa-shirt"></i></a></li>
                <li><a href="" target="_blank" >Order page <i class="fa-solid fa-folder-open"></i></a></li>
                <li><a href="" target="_blank" >Membre info <i class="fa-sharp fa-solid fa-users"></i></a></li>
                <li><a href="addproduct.php" target="_blank" >Add product <i class="fa-solid fa-folder-plus"></i></a></li>
                <li><a href="logout.php" target="_blank" >Log out <i class="fa-solid fa-right-from-bracket"></i></a></li>
            </ul>
        </div>
        <!-- end sidebar -->
        <!-- start section -->
        <div class="content_sec">
            <form action="adminpanel.php" method="post" >
                <label for="sec">Add new section</label>
                <input type="text" name="sec_name" id="sec" >
                <br>
                <button class="add" type="submit" name="sec_add">confirm</button>
            </form>
            <br>
            <!-- S table -->
            <table dir="rtl" >
                <tr>
                    <th>serial number</th>
                    <th>section name</th>
                    <th>section delete</th>
                </tr>
                <tr>
                    <?php
                    $query ="SELECT * FROM sections";
                    $result = mysqli_query($con,$query);
                    while($row=mysqli_fetch_assoc($result)){
                    ?>
                    
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['sec_name'] ?></td>
                    <td><a href="adminpanel.php?id=<?php echo $row['id'] ?>"><button type="submit" class="delet" >section delete</button></a></td>
                </tr>
                    <?php
                    }
                    ?>
            </table>


        </div>
    </div>



    <?php 
    }
    ?>
</body>
</html>
