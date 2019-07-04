<?php
    require_once("../config/connection.php");

    $filtered = array(
        'name' => mysqli_real_escape_string($conn, $_POST['name']),
        'profile' => mysqli_real_escape_string($conn, $_POST['profile'])
    );
    $sql = "INSERT INTO author (name, profile) VALUES ('{$filtered['name']}', '{$filtered['profile']}' )";

    $result = mysqli_query($conn, $sql);

    if($result){
        header("Location: ../author.php");
    } else {
        echo "데이터를 저장하는 중 문제가 발생하였습니다. 관리자에게 문의해주세요";
        // error_log(echo mysqli_error($conn)); // 에러로그 노출없이 따로 저장
        die(mysqli_error($conn));
    }
?>