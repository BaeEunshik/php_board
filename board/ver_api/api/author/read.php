<?php
// required header
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// include database and object files
include_once '../config/database.php';
include_once '../objects/author.php';

// instantiate database and author object
$database = new Database();
$db = $database->getConnection();

// initialize object
$author = new Author($db);

// query authors
$stmt = $author->read();
$num = $stmt->rowCount();

// check if more than 0 record found
if($num>0){

    // products array
    $authors_arr = array();
    $authors_arr["records"] = array();

    // retrieve our table countents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);

        $author_item = array(
            "id" => $id,
            "name" => $name,
            "profile" => html_entity_decode($profile)
        );
        
        array_push($authors_arr["records"], $author_item);
    }

    // set response code - 200 OK
    http_response_code(200);

    // show authors data in json format
    echo json_encode($authors_arr);
} else {

    // set response code - 404 Not found
    http_response_code(404);

    // tell the user no authors found
    echo json_encode(
        array("message" => "No authors found")
    );
}

?>