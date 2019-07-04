<?php
    require("../config/connection.php");

    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $profile = mysqli_real_escape_string($conn, $_POST['profile']);
 
    settype($id, 'integer');
    $sql = "UPDATE author 
                SET 
                    name = '{$name}', 
                    profile = '{$profile}'
                WHERE 
                    id = {$id}";
    $result = mysqli_query($conn,$sql);
    if($result){
        header("Location: ../author.php");
    } else {
        echo mysqli_error($conn);
        die("업데이트 중 문제");
    }
?>