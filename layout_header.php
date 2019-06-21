<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>研料丨<?php echo $page_title; ?>的主页</title>
    
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="style1.css" type="text/css"  />
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
          <a class="navbar-brand" >研料</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="home.php">首页</a></li>
            <li class="active"><a href="shopping_cart.php?id=<?php echo $id;  ?>" class="active">购物车</a></li>
            <!-- 链接要换 -->
            <li><a href="material_add.php">卖书</a></li>
            <!-- 链接要换 -->
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
 
    <!-- container -->
    <div class="container">
 
        <?php
        // show page header
        echo "<div class='page-header'>
                <h1>{$page_title}</h1>
            </div>";
        ?>