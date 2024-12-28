<?php
include('../conn.php'); 

?>
<?php
@$pname = $_POST['pname'] ;
@$pprice= $_POST['pprice'];
@$psection = $_POST['psection'];
@$pdescrip =$_POST['pdescrip'];
@$psize= $_POST['psize'];
@$punavail = $_POST['punavail'];
@$padd=$_POST['padd'];
// img
@$imgname = $_FILES['pimg']['name'];
@$imgtmp= $_FILES['pimg']['tmp_name'];

if (isset($padd)){
    if (empty($pname) || empty($pprice) || empty($psection) || empty($psize) || empty($punavail) || empty($pdescrip) ){
        echo '<script> alert ("Please, Enter data in all fields"); </script>';
    }
    else{
        @$pimg = rand(0,15000). "_" .$imgname;
        move_uploaded_file($imgtmp,"../uploads/img//" .$pimg);
    
        $query = "INSERT INTO products(pname,pimg,pprice,psection,pdescrip,psize,punavail)
        VALUE('$pname','$pimg','$pprice','$psection','$pdescrip','$psize','$punavail')";
        $result = mysqli_query($con,$query);
        if(isset($result)){
            echo '<script> alert ("The product has been added successfully"); </script>';
        }
        else{
            echo '<script> alert ("erorr, The product has not been added"); </script>';   
        }
    }

}

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Products</title>
    <link rel="stylesheet" href="style.css">
</head>
<style>
    .border{
        border: #e41d43;
    }
</style>
<body>
    <center>
        <main>
            <div class="form_product">
                <h1>Add Product</h1>
                <form action="addproduct.php"  method="post"  enctype="multipart/form-data" >
                    <label for="name">product titel</label>
                    <input type="text" name="pname" id="name" >
                    <br>

                    <label for="img">image</label>
                    <input type="file" name="pimg" id="img" >
                    <br>

                    <label for="price">price</label>
                    <input type="text" name="pprice" id="price" >
                    <br>

                    <label for="disc">description</label>
                    <input type="text" name="pdescrip" id="disc" >
                    <br>

                    <label for="size">size</label>
                    <input type="text" name="psize" id="size" >
                    <br>

                    <label for="ava">available</label>
                    <input type="text" name="punavail" id="ava" >
                    <br>

                    <div>
                        <label for="asec">sectoin name</label>
                        <select name="psection" id="asec">
                            <?php 
                            $query="SELECT * FROM sections";
                            $result=mysqli_query($con,$query);
                            while($row=mysqli_fetch_assoc($result)){
                                //echo '<option name="sections">'.$row['sec_name']'</option>'
                                ?>
                                <option name="sections"><?php echo $row['sec_name'] ?></option>
                            
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <br>

                    <button class="button" type="submit" name="padd" >Confirme</button>

                </form>
            </div>
        </main>
    </center>
</body>
</html>