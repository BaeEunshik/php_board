<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Method: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers:Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/topic.php';
include_once '../objects/image.php';

$database = new Database();
$db = $database->getConnection();
$topic = new Topic($db);
$image = new Image($db);
$util = new Utilities();

// echo $_SERVER['DOCUMENT_ROOT'];
// echo '<br>';
// echo $_SERVER['REQUEST_URI'];
// echo '<br>';
// echo $_SERVER['HTTP_HOST'];
// var_dump($_SERVER);
// exit;

// IMAGE UPLOAD
$image_file = $_FILES['image'];
$file_name = explode('.', $image_file['name']);
$ext = array_pop($file_name);
$origin_name = $file_name[0];
$save_name = uniqid();
// image file check 
$fileChecked = $util->imageFileCheck($image_file, $ext);
if(!$fileChecked["bool"]){
    print_r($fileChecked["message"]);
    exit;
} 

// upload file
move_uploaded_file( $image_file['tmp_name'], "$uploads_dir/$save_name.$ext");

// MAKE SURE DATA IS NOT EMPTY
if(
    !empty($_POST['title']) &&
    !empty($_POST['description']) && 
    !empty($_POST['author_id']) 
){
    // INSERT IMAGE
    $image->save_name = $save_name;
    $image->origin_name = $origin_name;
    $image->ext = $ext;
    if(!$image->create()){
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create topic."));
        exit;
    }
    // INSERT TOPIC
    $topic->title = $_POST['title'];
    $topic->description = $_POST['description'];
    $topic->created = date('Y-m-d H:i:s'); //or NOW()?
    $topic->author_id = $_POST['author_id'];
    $topic->image_id= $image->getLastInsertedId();
    if(!$topic->create()){
        http_response_code(503);
        echo json_encode(array("message" => "Unable to create topic."));
        exit;
    }

    // set response code - 201 topic created
    http_response_code(201);
    // tell the user
    echo json_encode(array("message" => "Topic was created."));

    
} else {
    //  set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to create topic. Data is incomplete."));
}

?>