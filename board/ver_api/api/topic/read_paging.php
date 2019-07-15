<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Typd: application/json; charset=UTF-8");

// include datavase and object files
include_once '../config/core.php';
include_once '../shared/utilities.php';
include_once '../config/database.php';
include_once '../objects/topic.php';

// utilities
$utilities = new Utilities();

// instantiate database and topic object
$databse = new Database();
$db = $databse->getConnection();

// initialize object
$topic = new Topic($db);

// query topic
$stmt = $topic->readPaging($from_record_num, $records_per_page); // 현재페이지 row idx, 페이지당 row 갯수
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // topic array
    $topic_arr = array();
    $topic_arr["records"] = array();
    $topic_arr["paging"] = array();

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
            "description" => $description,
            "created" => $created,
            "author_id" => $author_id
            // ,"image_id" => $image_id
        );

        array_push($topic_arr["records"], $topic_item);
    }
    // include paging
    $total_rows = $topic->count();
    $page_url = "{$home_url}topic/read_paging.php?";
    $paging = $utilities->getPaging($page, $total_rows, $records_per_page, $page_url);
    $topics_arr["paging"]=$paging;

    // set response code 200 ok
    http_response_code(200);

    // make it json foramt
    echo json_encode($topics_arr);
} else {

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user topics does not exist
    echo json_encode(
        array("message" => "No topics found")
    );
}




?>