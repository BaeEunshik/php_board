<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

// include database and object files
include_once '../config/database.php';
include_once '../objects/topic.php';

// get database connection
$database = new Database();
$db = $database->getConnection();

// prepare topic object
$topic = new Topic($db);

// set ID property of record to read
$topic->id = isset($_GET['id']) ? $_GET['id'] : die();

// read the details of topic to be edited
$topic->readOne();

if($topic->title != null){
    // create array
    $topic_arr = array(
        "id" => $topic->id,
        "title" => $topic->title,
        "description" => $topic->description,
        "created" => $topic->created,
        "author_id" => $topic->author_id,
        "author_name" => $topic->author_name,
        "image_id" => $topic->image_id
    );

    // set response code - 200 ok
    http_response_code(200);

    // make it json format
    echo json_encode($topic_arr);
} else {

    // set response code - 404 not found
    http_response_code(404);

    // tell the user topic does not exist
    echo json_encode(array("message"=> "topic does not exist"));
}
?>