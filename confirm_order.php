<?php
include('dbconf.php');
if (!isset($_SESSION)) {
    session_start();
}

if(! isset($_SESSION['id'])){
    echo "Invalid Request made";
    exit();
}

if( $_SESSION['is_admin'] != '1'){
    echo "Invalid Request made";
    exit();
}

if (isset($_POST['confirm_order'])) {
    $id = $_POST['order_id'];
    
    // Used this to send back from where it came. Ex. to get status.
    $request_url = $_POST['request_url'];
    $updateStatus = "UPDATE customer_order set status = 'done' where id = $id";


    if ($con->query($updateStatus)) {
        
        $updateCart = "UPDATE cart set status = 'done' where order_id = $id;";
        $con->query($updateStatus);

        if($request_url=='all'){
            header("Location: customer_orders.php");
        }
        else{
            header("Location: customer_orders.php?status=$request_url");
        }

    }
}
elseif(isset($_POST['reject_order'])) {
    $id = $_POST['order_id'];
    
    // Used this to send back from where it came. Ex. to get status.
    $request_url = $_POST['request_url'];
    $updateStatus = "UPDATE customer_order set status = 'reject' where id = $id";


    if ($con->query($updateStatus)) {
        
        $updateCart = "UPDATE cart set status = 'reject' where order_id = $id;";
        $con->query($updateCart);

        if($request_url=='all'){
            header("Location: customer_orders.php");
        }
        else{
            header("Location: customer_orders.php?status=$request_url");
        }

    }
} else {
    echo "Invalod Request";
}
