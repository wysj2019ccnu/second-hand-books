<?php
// get ID of the material to be read
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
// page given in URL parameter, default page is one
$page = isset($_GET['page']) ? $_GET['page'] : 1;
 
// set number of records per page
$records_per_page = 5;
 
// calculate for the query LIMIT clause
$from_record_num = ($records_per_page * $page) - $records_per_page;
// include database and object files
include_once 'dbconfig.php';
include_once 'objects/material.php';
include_once 'objects/message.php';
include_once 'objects/orders.php';
include_once 'objects/class.user.php';
require_once 'session.php';

// prepare objects
$material = new Material();
$message = new Message();
$auth_user = new User();
$seller = new User();
$order = new orders();


 
// set ID property of material to be read
$material->id = $_GET['id'];
$message->ma_id = $material->id;
$seller->id = $material->seller_id;
$auth_user->id = $_SESSION['user_session'];
$order->ma_id = $material->id;


$stmt = $message->readAll($from_record_num, $records_per_page);
$num = $stmt->rowCount();

// read the details of material to be read
$material_stmt = $material->readOne();
// set page headers
$page_title = $material->ma_name;

$stmt1 = $auth_user->runQuery("SELECT * FROM user WHERE id=:user_id");
$stmt1->execute(array(":user_id"=>$auth_user->id));    
$userRow=$stmt1->fetch(PDO::FETCH_ASSOC);

$stmt2 = $seller->runQuery("SELECT * FROM user WHERE id=:user_id");
$stmt2->execute(array(":user_id"=>$material->seller_id));    
$sellerRow=$stmt2->fetch(PDO::FETCH_ASSOC);

$stmt3 = $material->runQuery("SELECT * FROM materials WHERE id=:id");
$stmt3->execute(array(":id"=>$material->id));    
$maRow=$stmt3->fetch(PDO::FETCH_ASSOC);

$seller_id = $maRow['seller_id'];


$seller_name = $sellerRow['user_name'];
$order->image = $maRow['image'];

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>研料丨<?php echo $page_title; ?></title>
	
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <script type="text/javascript" src="jquery-1.11.3-jquery.min.js"></script>
    <link rel="stylesheet" href="css/style2.css" type="text/css"  />
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"  />




</head>
<body>

	<nav class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
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

    <div class="clearfix"></div>



    <div class="container-fluid" style="margin-top:88px;">
	<div class="container">	

		
			<h3>商品详情</h3>
            <div class="picture">
			<img width='175' height='240' src="images/<?php echo $material->image ; ?>">
            </div>
            <div class="words">
			<?php
			echo "<br>名称：" . $material->ma_name;
			echo "<br>品相：" . $material->remark . "<br>";
			echo "售价：" . $material->sell_price . "<br>";
			echo "卖家：<a href='seller.php?id=" .$material->seller_id . "'>" . $sellerRow['user_name'] . "</a><br>";
            

            if(intval($material->sold) == 1){
                echo "<br><img src='image/sold.jpg' width=100>";
            }else{
                echo '';
            }

            if (intval($_SESSION['user_session']) == intval($material->seller_id ) ){
                        $material_id = $material->id;
                        echo '<br><a href="material_update.php?id=' . $material_id . '" class="btn btn-info">更新商品信息</a>';
            }elseif(intval($_SESSION['user_session']) !== intval($material->seller_id ) && intval($material->sold) !== 1) {
                echo '<br><form method="post" action="order_add.php?id=' . $material->id .'">' ;

                echo '<input type="submit" class="btn btn-primary" value="加入购物车"/></form>';
            }
            

			?>



		

		<div class="message">

<?php
$message_stmt = $message->read();
$message_num = $message_stmt->rowCount();

	if($message_num>0){
        echo '<ol id="messages" class="list-group">'; 

    while($row = $message_stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<li id="material-'.$row['id'].'" class="list-group-item">';
        echo '<strong>昵称：'.$row['buyer_name'].'</strong>';
        echo '<a href="message_delete.php?message_id='.$row['id'].'&ma_id='.$_GET['id'].'" class="badge badge-danger delete-message" message_delete-id=' . $row['id'] . '>删除</a><br/>';
        echo '<small>Posted:'.date($row['date']).'</small><br/>';
        echo nl2br($row['content']);
        echo '</li>';
    }

    echo '</ol>';

    // the page where this paging is used
    $page_url = "read_one.php?id={$id}&";

 
    // count all messages in the database to calculate total pages
    $total_rows = $message->countAll();
}else{
	echo "<hr><div class='alert alert-info'>还没有留言。</div>";
}
?>
		</div>

		<div class="card">

            <div class="card-body">

                <form method="post" action="<?php echo "message_add.php?ma_id={$_GET['id']}" ?>" class="form-group">
    
                    <label for="content">内容:</label>
                    <textarea class="form-control" name="content" id="content"></textarea>
        
                    <br>
            
                    <input type="submit" class="btn btn-primary" value="添加留言"/>
          
                </form>
            </div>
        </div>




	</div>
</div></div>
<script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>