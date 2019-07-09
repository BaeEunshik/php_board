<?php
//에러 출력 설정
error_reporting(E_ALL);
ini_set("display_errors", 1);

// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Method: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers:Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';
// instantidat topic object
include_once '../objects/topic.php';

$database = new Database();
$db = $database->getConnection();
$topic = new Topic($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if (
    !empty($data->title) &&
    !empty($data->description) &&
    !empty($data->author_id) && 
    !empty($data->image_id)
){
    // set topic property values
    $topic->title = $data->title;
    $topic->description = $data->description;
    $topic->created = date('Y-m-d H:i:s'); //or NOW()?
    $topic->author_id = $data->author_id;
    $topic->image_id= $data->image_id;

    // create the topic
    if($topic->create()){

        // set response code - 201 created
        http_response_code(201);
        // tell the user
        echo json_encode(array("message" => "Topic was created."));

    } else { // if unable to create the topic, tell the user

        // set response code = 503 service unavailable
        http_response_code(503);
        // tell the user
        echo json_encode(array("message" => "Unable to create topic."));
    }

} else { // tell the user data is incomplete
    print_r($data);
    // print_r($data->title);
    // print_r($data->description);
    // print_r($data->author_id);
    // print_r($data->image_id);
    
    //  set response code - 400 bad request
    http_response_code(400);
    // tell the user
    echo json_encode(array("message" => "Unable to create topic. Data is incomplete."));
}

// mysql_insert_id() // insert 한 row 의 id 값 가져오는 함수
?>