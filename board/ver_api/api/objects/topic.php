<?php
class Topic{
 
    // database connection and table name
    private $conn;
    private $table_name = "topic";
 
    // object properties
    public $id;
    public $title;
    public $description;
    public $created;
    public $author_id;
    public $image_id;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // read topic
    function read(){
    
        // select all query
        $query = "SELECT
                    a.name as author_name, t.id, t.title, t.description, t.created, t.author_id
                FROM
                    $this->table_name  t
                    LEFT JOIN
                        author a
                            ON t.author_id = a.id
                ORDER BY
                    t.created DESC";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // execute query
        $stmt->execute();
    
        return $stmt;
    }

    // create topic
    function create(){
        
        // query to inser record
        $query = "INSERT INTO
                    $this->table_name
                SET
                    title=:title, description=:description,
                    created=:created,author_id=:author_id,
                    image_id=:image_id";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->created = htmlspecialchars(strip_tags($this->created));
        $this->author_id = htmlspecialchars(strip_tags($this->author_id));
        $this->image_id = htmlspecialchars(strip_tags($this->image_id));

        // bind values
        $stmt->bindParam(":title",$this->title);
        $stmt->bindParam(":description",$this->description);
        $stmt->bindParam(":created",$this->created);
        $stmt->bindParam(":author_id",$this->author_id);
        $stmt->bindParam(":image_id",$this->image_id);

        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}