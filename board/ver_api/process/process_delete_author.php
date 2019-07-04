<?php
    require("../config/connection.php");

    $id = mysqli_real_escape_string($conn,$_POST['id']);
    settype($id, 'integer');

    // 작성자의 글 삭제
    $sql = "DELETE FROM topic where author_id = $id";
    mysqli_query($conn,$sql);

    // 작성자 삭제
    $sql = "DELETE FROM author WHERE id = $id";
    $result = mysqli_query($conn,$sql);

    if($result){
        header("Location: ../author.php");
    } else {
        echo mysqli_error($conn);
        die("삭제하는 중 문제 발생");
    }
?>