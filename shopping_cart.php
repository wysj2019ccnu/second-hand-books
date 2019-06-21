<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>我的购物车</title>
</head>
<body>


<?php
// get ID to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// include database and object files

include_once 'objects/material.php';
include_once 'objects/orders.php';
include_once 'objects/class.user.php';
require_once 'session.php';

 
// prepare objects
$orders = new Orders();
$auth_user = new User();


// set ID property 

$auth_user->id = $_SESSION['user_session'];

 
// read the details of product to be read
$stmt = $orders->runQuery("SELECT * FROM orders WHERE buyer_id=:user_id");
$stmt->execute(array(":user_id"=>$auth_user->id));
$num = $stmt->rowCount();

$stmt1 = $auth_user->runQuery("SELECT * FROM user WHERE id=:user_id");
$stmt1->execute(array(":user_id"=>$auth_user->id));    
$userRow=$stmt1->fetch(PDO::FETCH_ASSOC);


$page_title = "购物车";

echo '<div class="container-fluid" style="margin-top:88px;"></div>';

include_once "layout_header.php";

echo '共有' . $num . '件商品';
if ($num>0) {
    echo "<table class='table table-hover table-responsive table-bordered'>";
          

                   echo "<tr>";
            echo "<th>资料名称</th>";
            echo "<th>卖家</th>";
            echo "<th>价格</th>";
            echo "<th>图片</th>";
            echo "<th>操作</th>";
                   echo "</tr>";
 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
 
            extract($row);
 
            echo "<tr>";
                echo "<td><a href='material_read.php?id={$ma_id}'>{$ma_name}</a></td>";
                echo "<td><a href='seller.php?id={$seller_id}'>{$seller_name}</a></td>";
                echo "<td>{$sell_price}</td>";
                echo "<td><img width='30' height='30' src='images/{$image}'></td>";

                echo "<td>";
                    // delete buttons
                echo "

                <a delete-id={$id} class='btn btn-danger delete-object'>
                <span class='glyphicon glyphicon-remove'></span> Delete
                </a>";
                echo "</td>";



                 } 
            
        }else{
            echo "还没有订单。";
        }

?>


<?php
// footer
include_once "layout_footer.php";
?>

</body>
</html>