<?php
include('../conn.php')
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    .UPDATE{
    color: var(--white);
    font-size: 15px;
    background-color: rgb(3, 228, 100);
    padding: 6px 14px;
    border-radius: 2px;
    /* border: 1px solid ; */
    margin-right: 5px;
    border: none;
    cursor: pointer;
    }
    .UPDATE:hover{
        background-color:  rgb(8, 100, 20);
    }
    .img_size{
    width: 50px;
    height: 50px;
    }
</style>
<body>
    <!-- delete product -->
     
    <?php
    @$id = $_GET['id'];
    if(isset($id)){
        $query = "DELETE FROM products WHERE id='$id'";
        $delet = mysqli_query($con,$query);
        if(isset($delet)){
            echo'<script> alert("dleted successfully"); </script>';
        }
        else{
            echo '<script> alert("Not deleted"); </script>';
        }
    }
    
    ?>

    <!-- delete product -->
    <div class="sidebar_container">
        <table dir="rtl" >
            <tr>
                <th>serial num</th>
                <th>image</th>
                <th>titel</th>
                <th>price</th>
                <th>size</th>
                <th>available</th>
                <th>section</th>
                <th>description</th>
                <th>delete</th>
                <th>update</th>
                

            </tr>

            <?php 
            $query = "SELECT * FROM products";
            $result = mysqli_query($con,$query);
            while($row=mysqli_fetch_assoc($result)){
            ?>
            <tr>
                <td><?php echo $row['id'] ?></td>
                <td><img class="img_size" src="../uploads/img//<?php echo $row['pimg'] ?>"></td>
                <td><?php echo $row['pname'] ?></td>
                <td><?php echo $row['pprice'] ?></td>
                <td><?php echo $row['psize'] ?></td>
                <td><?php echo $row['punavail'] ?></td>
                <td><?php echo $row['psection'] ?></td>
                <td><?php echo $row['pdescrip'] ?></td>
                <td><a href="product.php? id=<?php echo $row['id'] ?>"><button type="submit" class="delet" >DELETE</button></td>
                <td><a href="updatpro.php? id=<?php echo $row['id'] ?>"><button type="submit" class="UPDATE" >UPDATE</button></td>

            </tr>
            <?php
            }
            ?>
        </table>    
    </div>
    
</body>
</html>