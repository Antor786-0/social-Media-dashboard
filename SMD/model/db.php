<?php

    $con= mysqli_connect('127.0.0.1', 'root', '', 'webtech');
    //$sql = "select * from users";
    //$result = mysqli_query($con, $sql);
    
    // for($i=0; $i<mysqli_num_rows($result); $i++){
    //     $row  = mysqli_fetch_assoc($result);
    //     print_r($row);
    //     echo "<br>";
    // }

    // while ($row  = mysqli_fetch_assoc($result)){
    //     print_r($row);
    //     echo "<br>";
    // }

    $sql = "insert into users values(null, 'ABC', '124', 'abc@gmail.com')";
    if(mysqli_query($con, $sql)){
        echo "Success!";
    }else{
        echo "DB error";
    }
?>