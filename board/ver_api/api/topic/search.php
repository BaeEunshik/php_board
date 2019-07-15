<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database adn object files
include_once '../config/core.php';
include_once '../config/database.php';
include_once '../objects/topic.php';

// instantiate database and topic object
$database = new Database();
$db = $database->getConnection();

// initialize object
$topic = new Topic($db);

// get keyowrd
$keywords = isset($_GET['s']) ? isset($_GET['s']) : "";

// query topics
$stmt = $topic->search($keywords);
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // topic array
    $topics_arr = array();
    $topics_arr["records"]=array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        $topic_item = array(
            "id" => $id,
            "title" => $title,
            "description" => html_entity_decode($description),
            "created" => $created,
            "author_id" => $author_id,
            "author_name" => $author_name
            // ,"image_id" => $image_id
        );
        array_push($topics_arr["records"], $topic_item);
    }
    // set response code - 200 ok
    http_response_code(200);

    // show topic data
    echo json_encode($topics_arr);
    
} else {
    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no topic found
    echo json_encode(
        array("message" => "No topic found.")
    );
}

?>