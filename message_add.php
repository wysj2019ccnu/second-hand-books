<?php

// include database and object files

include_once 'objects/material.php';
include_once 'objects/message.php';
include_once 'objects/class.user.php';
require_once 'session.php';
 
 
// pass connection to objects
$message = new Message();
$material = new Material();
$auth_user = new User();
$seller = new User();

$auth_user->id = $_SESSION['user_session'];

$stmt1 = $auth_user->runQuery("SELECT * FROM user WHERE id=:user_id");
$stmt1->execute(array(":user_id"=>$auth_user->id));    
$userRow=$stmt1->fetch(PDO::FETCH_ASSOC);
 
?>

<?php 
// if the form was submitted 
if($_POST){
 
    // set message property values
    $message->ma_id = $_GET['ma_id'];
    $message->buyer_id = $auth_user->id;
    $message->buyer_name = $userRow['user_name'];
    $message->content = $_POST['content'];
    
 
    // create the message
    if($message->create()){
        header('location:' . 'material_read.php?id=' . $message->ma_id) . '#messages'; 
        
        
    }
 
    // if unable to create the message, tell the user
    else{
        echo "<div class='alert alert-danger'>Unable to create a message.</div>";
    }
}
?>