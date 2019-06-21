<?php
// get ID of the material to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');

// include database and object files
include_once 'dbconfig.php';
include_once 'objects/material.php';
include_once 'objects/message.php';
include_once 'objects/class.user.php';
require_once 'session.php';

// prepare objects
$material = new Material();
$auth_user = new User();
$seller = new User();


 
// set ID property of material to be read
$seller->id = $_GET['id'];
$auth_user->id = $_SESSION['user_session'];

// read the details of material to be read
$material_stmt = $material->readOne();


$stmt1 = $auth_user->runQuery("SELECT * FROM user WHERE id=:user_id");
$stmt1->execute(array(":user_id"=>$auth_user->id));    
$userRow=$stmt1->fetch(PDO::FETCH_ASSOC);

$stmt2 = $seller->runQuery("SELECT * FROM user WHERE id=:user_id");
$stmt2->execute(array(":user_id"=>$seller->id));    
$sellerRow=$stmt2->fetch(PDO::FETCH_ASSOC);

$stmt3 = $material->runQuery("SELECT * FROM materials WHERE seller_id=:seller_id");
$stmt3->execute(array(":seller_id"=>$seller->id));    
//$maRow=$stmt3->fetch(PDO::FETCH_ASSOC);
//var_dump($maRow);
$num = $stmt3->rowCount();


// set page headers
$page_title = $sellerRow['user_name'];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>研料丨<?php echo $page_title; ?>的主页</title>
	
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>





</head>
<body>

	<header>

    <nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <img src="image/logo.png" width="50">
          <a class="navbar-brand" >研料</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="home.php">首页</a></li>
            <li><a href="shopping_cart.php?id=<?php echo $id;  ?>">购物车</a></li>
            <li><a href="material_add.php">卖书</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
              <span class="glyphicon glyphicon-user"></span>&nbsp;Hi' <?php echo $userRow['user_email']; ?>&nbsp;<span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="seller.php?id=<?php echo $id;  ?>"><span class="glyphicon glyphicon-user"></span>&nbsp;我的主页</a></li>
                <li><a href="logout.php?logout=true"><span class="glyphicon glyphicon-log-out"></span>&nbsp;Sign Out</a></li>
              </ul>
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </nav>
    </header>

    <div class="clearfix"></div>



    <div class="container-fluid" style="margin-top:88px;">
	<div class="container">	

		<div class="seller" style="background-image: url(image/sellerback.jpg);height: 150px;padding-top: 25px;">
			<h2 style="margin-left: auto;margin-right: auto;padding: 0 45%;"><?php echo $sellerRow['user_name']; ?></h2>
			<h4 style="padding: 0 43%;;margin-bottom: 60px;">上架商品（<?php echo $num; ?>）</h4>
			<?php

            if ($num>0) {
              //print_r($stmt3->fetch(PDO::FETCH_ASSOC));
                while ($maRow=$stmt3->fetch(PDO::FETCH_ASSOC)) {
                    extract($maRow);
                    //var_dump($maRow);
                    echo '<div class="panel"><div class="panel-body">';
                    echo '<div>' . $maRow['ma_name'];
                    echo "<br><img width='175' height='240' src='images/" . $maRow['image'] . "'><br>";
                    echo '售价：' . $maRow['sell_price'] ;

                    if ($auth_user->id = $seller->id) {
                        $material_id = $maRow['id'];
                        echo '<br><a href="material_read.php?id=' . $material_id . '">商品详情</a></div>';
                    }else{
                        echo '<br><a href="shopping_cart.php">加入购物车</a></div>';
                    }
                    
                    echo '</div></div>';
                 } 
            }else{
                echo "还没有商品上架。";
            }
			

			?>

		

		</div>

		<div>


</div>
</div>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>