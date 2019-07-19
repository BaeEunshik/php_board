<?php
class Image{

    // database connection and table name
    private $conn;
    private $table_name = "image";

    // object properties
    public $id;
    public $save_name;
    public $origin_name;
    public $ext;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    public function getLastInsertedId(){
        return $this->conn->lastInsertId();
    }

    // create image
    public function create(){

        // query to insert record
        $query = "INSERT INTO
                    $this->table_name
                SET
                    save_name=:save_name,
                    origin_name=:origin_name,
                    ext=:ext";
        
        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->save_name = htmlspecialchars(strip_tags($this->save_name));
        $this->origin_name = htmlspecialchars(strip_tags($this->origin_name));
        $this->ext = htmlspecialchars(strip_tags($this->ext));

        // bind values
        $stmt->bindParam(":save_name",$this->save_name);
        $stmt->bindParam(":origin_name",$this->origin_name);
        $stmt->bindParam(":ext",$this->ext);
        
        // execute query
        if($stmt->execute()){
            return true;
        }
        return false;
    }
}
?>