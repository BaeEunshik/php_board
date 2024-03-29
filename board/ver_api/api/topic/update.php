<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


// include database and object files
include_once '../config/database.php';
include_once '../objects/topic.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare topic object
$topic = new Topic($db);

// get id of topic to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of topic to be edited
$topic->id = $data->id;


// set topic property values
$topic->title = $data->title;
$topic->description = $data->description;


// update the topic
if($topic->update()){

    // set response code = 200 ok
    http_response_code(200);

    // tell the user
    echo json_encode(array("message" => "Topic was updated."));

} else { // if unable to update the topic, tell the user
    
    // set response code - 503 service unavailable
    http_response_code(503);

    // tell the user
    echo json_encode(array("message"=> "Unable to update topic."));
}
?>
