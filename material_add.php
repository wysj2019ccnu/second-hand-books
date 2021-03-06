<!DOCTYPE HTML>
   <html>
   <head>
    <meta charset="UTF-8">
    <title>研料丨上架我的二手考研资料</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/add_style.css">


   </head>

<br><br>
    <body>
        <div class="container">


<?php


// include database and object files
include_once 'dbconfig.php';
include_once 'objects/material.php';
include_once 'objects/message.php';
include_once 'objects/class.user.php';
require_once 'session.php';

// prepare objects
$material = new Material();
$message = new Message();
$auth_user = new User();

$auth_user->id = $_SESSION['user_session'];

$stmt1 = $auth_user->runQuery("SELECT * FROM user WHERE id=:user_id");
$stmt1->execute(array(":user_id"=>$auth_user->id));    
$userRow=$stmt1->fetch(PDO::FETCH_ASSOC);



echo "<div class='right-button-margin'>";
    echo "<a href='seller.php?id=$auth_user->id' class='btn btn-default pull-right'>返回我的主页</a>";
echo "</div><br>";
 
?>

<?php 
// if the form was submitted
if($_POST){
 
    // set material property values
    $material->seller_id = $auth_user->id;
    $material->ma_name = $_POST['ma_name'];
    $material->image = $_POST['image'];
    $material->sell_price = $_POST['sell_price'];
    $material->type = $_POST['type'];
    $material->remark = $_POST['remark'];
//图片上传

$material->image = $_FILES['image']["name"];

$upload_path = "images/".$material->image; //上传文件的存放路径
//开始移动文件到相应的文件夹
if(move_uploaded_file($_FILES["image"]["tmp_name"],
      $upload_path)){

    echo "Successfully!";
}else{
    echo "Failed!";
} 
    // create the material
    if($material->create()){
            redirect('home.php'); 
        
    }
 
    // if unable to create the material, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create a material.</div>";
    }
}
?>
<!-- HTML form for creating a material -->

<form method="post" class="form-group" enctype="multipart/form-data"  style="text-aligncenter">
    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>名称</td>
            <td><input type='text' name='ma_name' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>图片</td>
            <td><input type='file' name='image' id="file" class='form-control' /></td>
        </tr>
 
        <tr>
            <td>售价</td>
            <td><input name='sell_price' class='form-control' value="￥"></td>
        </tr>
 
        <tr>
            <td>种类</td>
            <td>
                <select class='form-control' name='type'>
                    <option value="">选择上架种类...</option>
                    <option value="专业书">专业书</option>
                    <option value="笔记">笔记</option>
                    <option value="参考资料">参考资料</option>
                    <option value="政治">政治</option>
                    <option value="英语">英语</option>
                </select>
            

            </td>
        </tr>

        <tr>
            <td>品相</td>
            <td><textarea type="content" name='remark' class='form-control'></textarea></td>
        </tr>
 
        <tr>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">提交</button>
            </td>
        </tr>
 
    </table>
        
</form>

</div>
</body>
</html>

