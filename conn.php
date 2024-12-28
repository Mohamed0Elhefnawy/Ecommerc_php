<?php
    $con = new mysqli("localhost","root","","ecommerce");
    if($con){
        echo "con suc";
    }
    else{
        echo "con falaid";
    }