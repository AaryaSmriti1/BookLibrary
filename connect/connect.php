<?php

$conn = mysqli_connect("localhost","root","","books");

    if(!$conn){
        die("Connection Failed : ".mysqli_connect_error());
    }

    if($conn){
        echo "Connection Successful";
    }

?>