<?php
    // get id and display data
    include('../conn.php');
    @$ID = $_GET['id'] ;
    $query = "SELECT * FROM products WHERE id='$ID' ";
    $up=mysqli_query($con,$query) ;  
    $data = mysqli_fetch_assoc($up);
    

    //insert data for updating 
    @$pname = $_POST['pname'] ;
    @$pprice= $_POST['pprice'];
    @$psection = $_POST['psection'];
    @$pdescrip =$_POST['pdescrip'];
    @$psize= $_POST['psize'];
    @$punavail = $_POST['punavail'];
    @$padd=$_POST['pupt'];
    // img
    @$imgname = $_FILES['pimg']['name'];
    @$imgtmp= $_FILES['pimg']['tmp_name'];
    


    if(isset($padd)){
        @$pimg = rand(0,15000). "_" .$imgname;
        move_uploaded_file($imgtmp,"../uploads/img//" .$pimg);
        $query="UPDATE products SET pname='$pname', pprice ='$pprice' , pimg ='$pimg' , psection ='$psection' , pdescrip ='$pdescrip' , psize ='$psize' , punavail ='$punavail' WHERE id='$ID'";
        $result =mysqli_query($con,$query);
        if(isset($result)){
            echo '<script> alert ("The product has been Updated successfully"); </script>';
        }
        else{
            echo '<script> alert ("The product not Updating"); </script>';
        }
        
    }







    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update product</title>
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
                <form action="updatpro.php"  method="post"  enctype="multipart/form-data" >
                    <label for="name">product titel</label>
                    <input type="text" name="pname" id="name" value="<?php echo $data['pname'] ?>" >
                    <br>

                    <label for="img">image</label>
                    <input type="file" name="pimg" id="img" value="<?php echo $data['pimg'] ?>" >
                    <br>

                    <label for="price">price</label>
                    <input type="text" name="pprice" id="price" value="<?php echo $data['pprice'] ?>" >
                    <br>

                    <label for="disc">description</label>
                    <input type="text" name="pdescrip" id="disc" value="<?php echo $data['pdescrip'] ?> ">
                    <br>

                    <label for="size">size</label>
                    <input type="text" name="psize" id="size" value="<?php echo $data['psize'] ?>" >
                    <br>

                    <label for="ava">available</label>
                    <input type="text" name="punavail" id="ava" value="<?php echo $data['punavail'] ?>" >
                    <br>

                    <div>
                        <label for="asec">sectoin name</label>
                        <select name="psection" id="asec"  >
                            <?php 
                            $query="SELECT * FROM sections";
                            $result=mysqli_query($con,$query);
                            while($row=mysqli_fetch_assoc($result)){
                                //echo '<option name="sections">'.$row['sec_name']'</option>'
                                ?>
                                <option name="sections"><?php echo $row['sec_name'] ?></option>
                            
                            
                        </select>
                    </div>
                    <br>

                    <button class="button" type="submit" name="pupt" >UPDATE</button>

                </form>
                <?PHP
            }   
                ?>
            </div>
           

            
            
        </main>
    </center>
    
</body>

</html>