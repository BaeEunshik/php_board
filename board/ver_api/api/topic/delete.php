<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object file
include_once '../config/database.php';
include_once '../objects/topic.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare topic object
$topic = new Topic($db);

// get topic id
// json 형식의 경우 $_GET, $_POST 는 빈 결과를 리턴할 수 있다. 
$data = json_decode(file_get_contents("php://input"));

// set topic id to be deleted
$topic->id = $data->id;

// delete the topic
if($topic->delete()){

    // set response code - 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Topic was deleted."));

} else { // if unable to delete the topic
    
    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_decode(array("message" => "Unable to delete topic."));
}


?>