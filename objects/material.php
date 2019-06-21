<?php
require_once('dbconfig.php');


class Material{
 
    // database connection and table name
    private $conn;
    private $table_name = "materials";
 
    public $id;
    public $ma_name;
    public $image;
    public $sell_price;
    public $seller_id;
    public $type;
    public $remark;
    public $sold;
 
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
 
    // create material
    function create(){
 
        //write query
        $query = "INSERT INTO
                    " . $this->table_name . "
                SET
                    seller_id=:seller_id,
                    ma_name=:ma_name,  
                    image=:image, 
                    sell_price=:sell_price,
                    type=:type,
                    remark=:remark,
                    sold=0";
 
        $stmt = $this->conn->prepare($query);
 
        // posted values
        $this->seller_id=htmlspecialchars(strip_tags($this->seller_id));
        $this->ma_name=htmlspecialchars(strip_tags($this->ma_name));
        $this->image=htmlspecialchars(strip_tags($this->image));
        $this->sell_price=htmlspecialchars(strip_tags($this->sell_price));
        $this->type=htmlspecialchars(strip_tags($this->type));
        $this->remark=htmlspecialchars(strip_tags($this->remark));
 
 
        // bind values 
        $stmt->bindParam(":seller_id", $this->seller_id);
        $stmt->bindParam(":ma_name", $this->ma_name);
        $stmt->bindParam(":image", $this->image);
        $stmt->bindParam(":sell_price", $this->sell_price);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":remark", $this->remark);
 
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }
 
    }

    

    function readOne(){
 
    $query = "SELECT
                ma_name, image, sell_price, seller_id, type, remark, sold
            FROM
                " . $this->table_name . "
            WHERE
                id = ?
            LIMIT
                0,1";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->bindParam(1, $this->id);
    $stmt->execute();
 
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
 
    $this->ma_name = $row['ma_name']; 
    $this->image = $row['image'];
    $this->sell_price = $row['sell_price'];
    $this->seller_id = $row['seller_id'];
    $this->remark = $row['remark'];
    $this->type = $row['type'];
    $this->sold = $row['sold'];

    }

    function update(){
    $query = "UPDATE
                " . $this->table_name . "
            SET
                ma_name=:ma_name,  
                image=:image, 
                sell_price=:sell_price,
                remark=:remark,
                sold=0
            WHERE
                id = :id";
    $stmt = $this->conn->prepare($query);

    // posted values
    $this->ma_name=htmlspecialchars(strip_tags($this->ma_name));
    $this->image=htmlspecialchars(strip_tags($this->image));
    $this->sell_price=htmlspecialchars(strip_tags($this->sell_price));
    $this->remark=htmlspecialchars(strip_tags($this->remark));
    


    $this->id=htmlspecialchars(strip_tags($_GET['id']));

    // bind parameters
    $stmt->bindParam(':ma_name', $this->ma_name);
    $stmt->bindParam(':image', $this->image);
    $stmt->bindParam(':sell_price', $this->sell_price);
    $stmt->bindParam(':remark', $this->remark);
    

    $stmt->bindParam(':id', $this->id);
    // execute the query
    if($stmt->execute()){
            return true;
        }else{
            return false;
        }
    }

   
    /*// delete the product
    function delete(){

        $query = "DELETE FROM
                " . $this->table_name . "
            WHERE
                id=".$this->id;
        $stmt = $this->conn->prepare( $query );
        $stmt->execute();
    
        return $stmt;
    
    }  */



    function read(){
    $query = "SELECT*
    FROM
        " . $this->table_name;
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;
    }

    function readAll($from_record_num, $records_per_page){
 
    $query = "SELECT
                id, ma_name, image, remark, sell_price, type 
            FROM
                " . $this->table_name . "
            ORDER BY
                id DESC
            LIMIT
                {$from_record_num}, {$records_per_page}";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    return $stmt;
    }

    public function countAll(){
 
    $query = "SELECT id FROM " . $this->table_name . "";
 
    $stmt = $this->conn->prepare( $query );
    $stmt->execute();
 
    $num = $stmt->rowCount();
 
    return $num;
    }

    function updateSold(){
    $query = "UPDATE
                " . $this->table_name . "
            SET
                sold=1  
                
            WHERE
                id = :id";
    $stmt = $this->conn->prepare($query);

    // posted values
    $this->id=htmlspecialchars(strip_tags($_GET['id']));

    // bind parameters
    $stmt->bindParam(':id', $this->id);

    // execute the query
    $stmt->execute();
 
    return $stmt;

    }

    

    function search($keyword){
    $query = "SELECT *
    FROM
        " . $this->table_name. "
    WHERE ma_name LIKE '%".$keyword."%'";
 
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
 
    return $stmt;
    }

    


}






?>