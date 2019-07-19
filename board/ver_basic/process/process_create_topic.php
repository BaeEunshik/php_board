<?php
    require_once("../config/connection.php");

    // IMAGE UPLOAD
    $uploads_dir = 'uploads';
    $uploads_dir_full = dirname(__DIR__).'/'.$uploads_dir;
    $allowed_ext = array('jpg','jpeg','png','gif');
    $error = $_FILES['myImage']['error'];

    $file = $_FILES['myImage']['name'];
    $file_name = explode('.', $file);

    $ext = array_pop($file_name);
    $origin_name = $file_name[0];
    $save_name = uniqid();

    if( $error != UPLOAD_ERR_OK ) {
        switch( $error ) {
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                echo "파일이 너무 큽니다. ($error)";
                break;
            case UPLOAD_ERR_NO_FILE:
                echo "파일이 첨부되지 않았습니다. ($error)";
                break;
            default:
                echo "파일이 제대로 업로드되지 않았습니다. ($error)";
        }
        exit;
    }
    if( !in_array($ext, $allowed_ext) ) {
        echo "허용되지 않는 확장자입니다.";
        exit;
    }
    
    move_uploaded_file( $_FILES['myImage']['tmp_name'], "$uploads_dir_full/$save_name.$ext");
    

    // INSERT IMAGE
    $sql_image = "INSERT INTO image 
                (origin_name, save_name, ext, dir)
                VALUE ( '$origin_name', '$save_name', '$ext', '$uploads_dir')";
    $result_image = mysqli_query($conn,$sql_image);
    if(!$result_image){
        echo '데이터를 저장하는 중 문제가 발생하였습니다. 관리자에게 문의해주세요';
        die(mysqli_error($conn));
    }
    $inserted_image_id = $conn->insert_id;


    // INSERT TOPIC 
    $filtered = array(
        'title' => mysqli_real_escape_string($conn, $_POST['title']),
        'description' => mysqli_real_escape_string($conn, $_POST['description']),
        'author_id' => mysqli_real_escape_string($conn, $_POST['author_id']),
        'image_id' => mysqli_real_escape_string($conn, $inserted_image_id)
    );
    $sql_topic = "INSERT INTO topic 
                (title, description, created, author_id, image_id) 
                VALUE ( '{$filtered['title']}', '{$filtered['description']}', NOW(), '{$filtered['author_id']}', '{$filtered['image_id']}' )";

    $result_topic = mysqli_query($conn,$sql_topic);

    if($result_topic){
        $inserted_topic_id = $conn->insert_id;
        header("Location: ../topic.php?id={$inserted_topic_id}");
    } else {
        echo '데이터를 저장하는 중 문제가 발생하였습니다. 관리자에게 문의해주세요';
        // error_log(echo mysqli_error($conn)); // 에러로그 노출없이 따로 저장
        die(mysqli_error($conn));
    }

?>