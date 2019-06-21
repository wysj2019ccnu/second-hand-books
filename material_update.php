<!DOCTYPE HTML>
   <html>
   <head>
    <meta charset="UTF-8">
    <title>研料丨更新我的二手考研资料</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/add_style.css">


   </head>
<br><br>
    <body>
        <div class="container">


<?php
$id = isset($_GET['id']) ? $_GET['id'] : die('ERROR: missing ID.');
// include database and object files

include_once 'objects/material.php';
include_once 'objects/message.php';
include_once 'objects/class.user.php';
require_once 'session.php';
 
 
// pass connection to objects
$message = new Message();
$material = new Material();
$auth_user = new User();

$auth_user->id = $_SESSION['user_session'];
$material->id = $_GET['id'];

$stmt1 = $auth_user->runQuery("SELECT * FROM user WHERE id=:user_id");
$stmt1->execute(array(":user_id"=>$auth_user->id));    
$userRow=$stmt1->fetch(PDO::FETCH_ASSOC);
 
$material->readOne();
?>

<?php 
// if the form was submitted
if($_POST){
 
    // set material property values
    $material->id = $_GET['id'];
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
    // update
    if($material->update()){
        header('location:' . 'material_read.php?id=' .  $material->id);
    }
 
    // if unable to update , tell the user
    else{
        echo "<div class='alert alert-danger alert-dismissable'>";
            echo "Unable to update material.";
        echo "</div>";
    }
}
?>
<!-- HTML form  -->
<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . "?id={$id}");?>" method="post" method="post" class="form-group" enctype="multipart/form-data">
 

    <table class='table table-hover table-responsive table-bordered'>
 
        <tr>
            <td>名称</td>
            <td><input type='text' name='ma_name' class='form-control' value='<?php echo $material->ma_name; ?>'/></td>
        </tr>
 
        <tr>
            <td>图片</td>
            <td><input type='file' name='image' value='<?php echo $material->image; ?>' class='form-control' /></td>
        </tr>
 
        <tr>
            <td>售价</td>
            <td><input name='sell_price' value='<?php echo $material->sell_price; ?>' class='form-control'></td>
        </tr>
 
        <tr>

        </tr>

        <tr>
            <td>品相</td>
            <td><textarea type="content" name='remark' value='<?php echo $material->remark; ?>' class='form-control'></textarea></td>
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

