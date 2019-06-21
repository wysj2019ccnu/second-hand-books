<?php

require_once('dbconfig.php');
include_once('material.php');


class Orders{
 
    // database connection and table name
    private $conn;
    private $table_name = "orders";
 
    // object properties
    public $id;
    public $ma_id;
    public $ma_name;
    public $seller_id;
    public $seller_name;
    public $buyer_id;
    public $image;
    public $sell_price;
 
   public function __construct()
    {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }

    public function runQuery($sql)
    {
        $stmt = $this->conn->prepare($sql);
        return $stmt;
    }
 
    // create product
    function create(){
 
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                     
                    ma_id=:ma_id, 
                    ma_name=:ma_name, 
                    seller_id=:seller_id, 
                    seller_name=:seller_name, 
                    buyer_id=:buyer_id,
                    image=:image,
                    sell_price=:sell_price";
 
        $stmt = $this->conn->prepare($query);
 
        // posted values
       
        $this->ma_id=htmlspecialchars(strip_tags($this->ma_id));
        $this->ma_name=htmlspecialchars(strip_tags($this->ma_name));
        $this->seller_id=htmlspecialchars(strip_tags($this->seller_id));
        $this->seller_name=htmlspecialchars(strip_tags($this->seller_name));
        $this->buyer_id=htmlspecialchars(strip_tags($this->buyer_id));
         $this->image=htmlspecialchars(strip_tags($this->image));
         $this->sell_price=htmlspecialchars(strip_tags($this->sell_price));
        
        
 
        // bind values 
        
        $stmt->bindParam(":ma_id", $this->ma_id);
        $stmt->bindParam(":ma_name", $this->ma_name);
        $stmt->bindParam(":seller_id", $this->seller_id);
        $stmt->bindParam(":seller_name", $this->seller_name);
        $stmt->bindParam(":buyer_id", $this->buyer_id);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":sell_price", $this->sell_price);
 
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
 
    }
function readAll($from_record_num, $records_per_page){
 
    $query = "SELECT
                id, ma_id, ma_name, seller_id, seller_name, buyer_id, image, sell_price
            FROM
                " . $this->table_name . "
            ORDER BY
                id ASC
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



// delete the product
function delete(){
 
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
     
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(1, $this->id);
 
    if($result = $stmt->execute()){
        return true;
        $material->updateSold2($this->ma_id);
    }else{
        return false;
    }
}


    function read(){
    $query = "SELECT*
                FROM
                    " . $this->table_name . "
                WHERE 
                   id = " . $_POST['object_id'];
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;
    }


}
?>