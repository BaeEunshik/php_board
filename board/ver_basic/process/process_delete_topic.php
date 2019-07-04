<?php
    require("../config/connection.php");
    
    settype($_POST['id'], 'integer');
    $filtered = array(
        'id' => mysqli_real_escape_string($conn,$_POST['id'])
    );
    
    // get img id, save_name, ext
    $sql = "SELECT I.id, I.save_name, I.ext
            FROM topic T, image I
            WHERE T.id = {$filtered['id']} and T.image_id = I.id";
    $result = mysqli_query($conn, $sql);
    $image_id;
    $image_save_name;
    $image_ext;
    if($row = mysqli_fetch_array($result)){
        $image_id = $row['id'];
        $image_save_name = $row['save_name'];
        $image_ext = $row['ext'];
    }

    // del img
    $sql = "DELETE FROM image 
            WHERE id = $image_id";
    $result_del_img = mysqli_query($conn, $sql);

    $dir = dirname(__DIR__).'/uploads/';
    unlink($dir.$image_save_name.".".$image_ext);

    //del topic
    $sql = "DELETE FROM topic
            WHERE id = {$filtered['id']} ";

    $result_del_topic = mysqli_query($conn,$sql);
    if(!$result_del_topic){    
        echo '게시물 데이터를 삭제하는 중 문제가 발생하였습니다.';
        // error_log(echo mysqli_error($conn)); // 에러로그 노출없이 따로 저장
        die(mysqli_error($conn));
    } else if (!$result_del_img){
        echo '이미지 데이터를 삭제하는 중 문제가 발생하였습니다.';        
        // error_log(echo mysqli_error($conn)); // 에러로그 노출없이 따로 저장
        die(mysqli_error($conn));
    } else {
        header("Location: ../topic.php");   
        // print_r($dir.$image_save_name.$image_ext);
    }
?>