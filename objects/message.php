<?php

require_once('dbconfig.php');

class message{

    // database connection and table name
    private $conn;
    private $table_name = "message";

    public $id;
    public $buyer_id;
    public $buyer_name;
    public $ma_id;
    public $content;
    public $date;

    public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    // create message
     function create(){
 
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    buyer_id=:buyer_id,
                    buyer_name=:buyer_name, 
                    ma_id=:ma_id, 
                    content=:content, 
                    date=:date";
 
        $stmt = $this->conn->prepare($query);


        // posted values      
        $this->buyer_id=htmlspecialchars(strip_tags($this->buyer_id));
        $this->buyer_name=htmlspecialchars(strip_tags($this->buyer_name));
        $this->ma_id=htmlspecialchars(strip_tags($this->ma_id));
        $this->content=htmlspecialchars(strip_tags($this->content));

        $this->date=date('Y-m-d H:i:s',time());


 
        // bind values 
        $stmt->bindParam(":buyer_id", $this->buyer_id);
        $stmt->bindParam(":buyer_name", $this->buyer_name);
        $stmt->bindParam(":ma_id", $this->ma_id);
        $stmt->bindParam(":content", $this->content);
        $stmt->bindParam(":date", $this->date);
 
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

 
    }

    function read(){
    $query = "SELECT*
                FROM
                    " . $this->table_name . "
                WHERE 
                   ma_id = ".$_GET['id']."
                ORDER BY
                    date";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;
    }

    function readAll($from_record_num, $records_per_page){
 
    $query = "SELECT
                id, ma_id, buyer_name, buyer_id, content, date
            FROM
                " . $this->table_name . "
            ORDER BY
                date ASC
            LIMIT
                {$from_record_num}, {$records_per_page}";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;
    }

    // used for paging products
    public function countAll(){
 
    $query = "SELECT id FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    $num = $stmt->rowCount();
 
    return $num;
    }



    function delete(){
    $query = "DELETE FROM
                " . $this->table_name . "
            WHERE
                id=".$_GET['message_id'];
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;

    }

    

}

?>