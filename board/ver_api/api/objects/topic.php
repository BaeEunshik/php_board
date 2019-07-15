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

    // create topic
    public function create(){
            
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

    // read topic
    public function read(){
    
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

    // used when filling up the update topic form
    public function readOne(){
        // query to read single record
        $query = "SELECT 
                    a.name as author_name, t.id, t.title, t.description, t.created, t.author_id, t.image_id
                FROM
                    $this->table_name t
                    LEFT JOIN 
                        author a
                            ON t.author_id = a.id
                WHERE 
                    t.id = :topic_id
                LIMIT 
                    0,1";

        // prepare query statement
        $stmt = $this->conn->prepare($query);
        
        // bind id of topic to be updated
        $stmt->bindParam(':topic_id', $this->id);
        
        // execute query 
        $stmt->execute();

        // get retrieved row
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // set values to object properties
        $this->title = $row['title'];
        $this->description = $row['description'];
        $this->created = $row['created'];
        $this->author_id = $row['author_id'];
        $this->image_id = $row['image_id'];
    }

    // update the topic
    public function update(){

        // update query
        $query = "UPDATE
                    $this->table_name
                SET
                    title = :title,
                    description = :description
                WHERE
                    id = :id";

        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // sanitize
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind new values
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':id', $this->id);
        
        // execute the query
        if($stmt->execute()){
            return ture;
        }
        return false;
    }

    // delete the topic
    public function delete(){
        // 해당 게시물이 없을 경우의 예외처리 필요**

        // delete query 
        $query = "DELETE FROM $this->table_name WHERE id = :id";

        // prepare query
        $stmt = $this->conn->prepare($query);

        // sanitize
        // stript_tags : 문자열에서 [ html, php ] 태그 제거
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind id of record to delete
        $stmt->bindParam(':id', $this->id);
        
        // execute query
        if($stmt->execute()){
            return true;
        }

        return false;
    }

    // search topics
    public function search($keywords){
        // select all query
        $query = "SELECT
                    a.name as author_name, t.id, t.title, t.description, t.created, t.author_id
                FROM 
                    $this->table_name t
                    LEFT JOIN 
                        author a ON t.author_id = a.id
                WHERE 
                    t.title LIKE :title OR t.description LIKE :description OR a.name LIKE :name
                ORDER BY
                    t.created DESC";

        // prepare query statment
        $stmt = $this->conn->prepare($query);

        // sanitize
        $keywords = htmlspecialchars(strip_tags($keywords));

        $keywords = "%{$keywords}%"; // 쿼리문에 적용하려면 %로 감싸야 함 

        // bind
        $stmt->bindParam(":title", $keywords);
        $stmt->bindParam(":description", $keywords);
        $stmt->bindParam(":name", $keywords);

        // execute query
        $stmt->execute();

        return $stmt;
    }

    // read topics with pagination
    // public? 
    public function readPaging($from_record_num, $records_per_page){

        // select query
        $query = "SELECT
                    a.name as author_name, t.id, t.title, t.description, t.created, t.author_id
                    FROM 
                        $this->table_name t
                        LEFT JOIN
                            author a
                                ON t.author_id = a.id
                    ORDER BY t.created DESC
                    LIMIT ?,?"; 
        
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        // bind variable values
        $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT); // ? 째 row 부터 가져온다.
        $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT); // ? 개를 가져온다.

        // execute query
        $stmt->execute();

        // return values from database
        return $stmt;
    }

    // public? 
    public function count(){
        $query = "SELECT COUNT(*) as total_rows FROM 
                    $this->table_name";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        return $row['total_rows'];
    }

    
}