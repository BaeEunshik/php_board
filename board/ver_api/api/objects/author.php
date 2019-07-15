<?php
class Author{

    // database connection and table name
    private $conn;
    private $table_name = "author";

    // object properties
    public $id;
    public $name;
    public $profile;

    public function __construct($db){
        $this->conn = $db;
    }

    // used by select drop-down list
    public function readAll(){
        // select all data
        $query = "SELECT
                    id, name, profile
                FROM $this->table_name
                ORDER BY
                    name";
                    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

}
?>