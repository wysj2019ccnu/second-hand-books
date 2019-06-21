<?php

 
// include database and object file

include_once 'objects/material.php';
include_once 'objects/message.php';
 
 
    // prepare object
$message = new Message();
$material = new Material();

    // set id to be deleted
    $message->ma_id = $_GET['ma_id'];
     
    // delete 
    if($message->delete()){
      header('location:' . 'material_read.php?id=' . $message->ma_id);
    }
    else{
        echo "Fail to delete.";
    }
    ;

?>