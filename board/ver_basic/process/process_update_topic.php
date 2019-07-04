<?php
    require_once("../config/connection.php");

    settype($_POST['id'], 'integer');
    $filtered = array(
        'id' => mysqli_real_escape_string($conn,$_POST['id']),
        'title' => mysqli_real_escape_string($conn, $_POST['title']),
        'description' =>  mysqli_real_escape_string($conn, $_POST['description'])
    );
    $sql = "UPDATE topic 
                SET
                    title = '{$filtered['title']}',
                    description = '{$filtered['description']}'
                WHERE
                    id = {$filtered['id']} ";

    $result = mysqli_query($conn,$sql);

    if($result){
        header("Location: ../index.php?id={$filtered['id']}");
    } else {
        echo '데이터를 저장하는 중 문제가 발생하였습니다. 관리자에게 문의해주세요';
        // error_log(echo mysqli_error($conn)); // 에러로그 노출없이 따로 저장
        die(mysqli_error($conn));
    }
?>