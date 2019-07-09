<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/topic.php';

// instantiate database and topic object
$database = new Database();
$db = $database->getConnection(); 

// initialize object
$topic = new Topic($db);

// query topic
$stmt = $topic->read();
$num = $stmt->rowCount();    

// check if more than 0 record found
if($num>0){
    // topics array
    $topic_arr = array();
    $topic_arr["records"] = array();

    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop

    // 방법 2
    // $arr = array();
    // while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    //     $arr[] = $row;
    // }
    // echo json_encode($arr);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to 
        // just $name only

        extract($row);

        $topic_item = array(
            "id" => $id,
            "title" => $title,
            "description" => html_entity_decode($description),
            "created" => $created,
            "author_name" => $author_name,
            "author_id" => $author_id
        );
        array_push($topic_arr["records"],$topic_item);
    }

    // set response code - 200 OK
    http_response_code(200);
    
    // show topic data in json format
    echo json_encode($topic_arr);

} else {
    // set response code - 404 not found
    http_response_code(404);
    
    // tell the user no topics found
    echo json_encode(
        array("message" => "no topics found.")
    );
}
?>
