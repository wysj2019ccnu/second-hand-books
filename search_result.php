<?php

	require_once("session.php");
	
	require_once("objects/class.user.php");
	$auth_user = new USER();
	
	
	$id = $_SESSION['user_session'];
	
	$stmt = $auth_user->runQuery("SELECT * FROM user WHERE id=:id");
	$stmt->execute(array(":id"=>$id));
	
	$userRow=$stmt->fetch(PDO::FETCH_ASSOC);

?>

<?php
// include database and object files

include_once 'objects/material.php';

// instantiate database and objects


$material = new Material ();


$keyword = $_POST['keyword'];
$stmt1 = $material->search($keyword);

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
<!-- <link href="bootstrap/css/bootstrap-theme.min.css" rel="stylesheet" media="screen"> -->
<script type="text/javascript" src="js/jquery-1.11.3-jquery.min.js"></script>
<link rel="stylesheet" href="css/style1.css" type="text/css"  />
<title>研料<?php print($userRow['user_email']); ?></title>
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

<div class="sousuo">
<form class="navbar-form navbar-collapse" method="post">
            <div class="form-group">
              <input type="text" class="form-control" name="keyword" id="keyword" >
            </div>
            <button type="submit" class="btn btn-default" name="btn-default">搜索</button>
          </form><br>
</div>



    	
<div style="background-image: url(image/homeback.jpg);height: 220px;width: 100%;background-repeat: no-repeat;margin: 0 12%;"></div>   
<div class="container" style="margin-top:20px;">
	
    <div class="container">
        
        <h1>
        <a >搜索结果</a></h1>


       	<hr />
            
    </div>

</div>

<div class="container">
<?php
      if (isset($_POST['keyword'])) {

        $resnum=$stmt1->rowCount();

        if($resnum>0){
          while ($Row=$stmt1->fetch(PDO::FETCH_ASSOC)) 
                    
              echo '<div class="panel"><div class="panel-body">';
              echo '<div>' . $Row['ma_name'];
              echo "<br><img src='images/" . $Row['image'] . "'><br>";
              echo '售价：' . $Row['sell_price'] ;
              echo '<br><a href="material_read.php?id=' . $Row['id'] . '">查看详情</a></div>';
              echo '</div></div>';
                 } 
            }
            else{
               echo "meiyoushiju";
            }
          }
          else{
                echo "没有输入搜索词。";
            }


?>
</div>

<script src="bootstrap/js/bootstrap.min.js"></script>

</body>
</html>


