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

    // read products
    function read(){
    
        // select all query
        $query = "SELECT
                    a.name as author_name, t.id, t.title, t.description, t.created, t.author_id
                FROM
                    " . $this->table_name . " t
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
}