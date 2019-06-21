<?php

// check if value was posted
if($_POST){
 
    // include database and object file

    include_once 'objects/orders.php';

 
    // prepare product object
    $order = new Orders();

     
    // set product id to be deleted
    $order->id = $_POST['object_id'];


    
     
    // delete the product
    if($order->delete()){
        header('location:' . 'shopping_cart.php?id=' . $order->buyer_id);
    
    }
     
    // if unable to delete the product
    else{
        echo "Unable to delete object.";
    }
}



?>