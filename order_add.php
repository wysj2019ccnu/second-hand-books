<?php

// include database and object files

include_once 'objects/material.php';
include_once 'objects/orders.php';
include_once 'class.user.php';
require_once 'session.php';
 
// pass connection to objects
$order = new orders();
$material = new Material();
$auth_user = new User();
$seller = new User();

$auth_user->id = $_SESSION['user_session'];
$material->id = $_GET['id'];
$order->ma_id = $material->id;

$stmt1 = $auth_user->runQuery("SELECT * FROM user WHERE id=:user_id");
$stmt1->execute(array(":user_id"=>$auth_user->id));    
$userRow=$stmt1->fetch(PDO::FETCH_ASSOC);

$stmt2 = $material->runQuery("SELECT * FROM materials WHERE id=:id");
$stmt2->execute(array(":id"=>$material->id));    
$maRow=$stmt2->fetch(PDO::FETCH_ASSOC);

$seller_id = $maRow['seller_id'];
$seller->id = $seller_id;

$stmt3 = $seller->runQuery("SELECT * FROM user WHERE id=:seller_id");
$stmt3->execute(array(":seller_id"=>$seller_id));    
$sellerRow=$stmt3->fetch(PDO::FETCH_ASSOC);
 
$seller_name = $sellerRow['user_name'];
$order->image = $maRow['image'];

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
    <link rel="stylesheet" href="css/style3.css" type="text/css"  />

</head>
<body>

<div class="gram">
<form method="post"  action="<?php echo 'order_add.php?id=' . $material->id ;?>'" class="form-group" enctype="multipart/form-data">

    <table class='table table-hover table-responsive table-bordered'>
    <h2>确认订单</h2>
        <tr>
            <td>名称</td>
            <td><input type='text' name='ma_name' class='form-control' value="<?php echo  $order->ma_name = $maRow['ma_name']; ?>" /></td>
        </tr>

 
        <tr>
            <td>售价</td>
            <td><input name='sell_price' class='form-control' value="<?php echo $order->sell_price = $maRow['sell_price'];?>"></td>
        </tr>
 
        <tr>
            <td>卖家</td>
            <td><input name='sell_price' class='form-control' type="text" value="<?php echo $seller_name;?>"></td>
        </tr>

        
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">提交</button>
            </td>
        </tr>
 
    </table>




</form>
<?php
// if the form was submitted 
if($_POST){
 
    // set property values
    $order->ma_id = $material->id;
    $order->ma_nanme = $maRow['ma_name'];
    $order->seller_id = $seller_id;
    $order->seller_name = $seller_name;
    $order->buyer_id = $auth_user->id;
    $order->image = $maRow['image'];
    $order->sell_price = $maRow['sell_price'];

    // create the product
    if($order->create()){
        header('location:' . 'shopping_cart.php?id=' . $auth_user->id) ;
       $material->updateSold();
        
    }
 
    // if unable to create, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create a order.</div>";
    }
}
?>
</div>
</body>
</html>