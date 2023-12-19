<?php
include('dbconf.php');
if (!isset($_SESSION)) {
    session_start();
}

if(! isset($_SESSION['id'])){
    include('error.php');
    exit();
}

if (isset($_POST['process_to_checkout'])) {
    
    $customer_id = $_SESSION['id'];
    
    // Checking if anything is present in cart or not.

    $cart_item = "SELECT * FROM CART WHERE CUSTOMER_ID = $customer_id and STATUS = 'draft'";
    $exist_cart = $con->query($cart_item);
    if($exist_cart->num_rows==0){
        $_SESSION['message'] = 'No items found to place order.';
        header("Location: cart.php");
        exit();
    }
    

    // Create order id.
    $order_query = "INSERT INTO CUSTOMER_ORDER(CUSTOMER_ID,STATUS)
    VALUES ($customer_id,'process');";
    
    $order = $con->query($order_query);
    
    // Getting order id which is created. 
    $orderId = mysqli_insert_id($con);

    // Updating cart records.
    
    $query = "UPDATE CART SET STATUS = 'process', ORDER_ID = $orderId
    WHERE CUSTOMER_ID = $customer_id and STATUS = 'draft';";
    
    $cart_query = $con->query($query);
    
    if($cart_query){
        $_SESSION['message'] = 'Your order is succesfully placed.In few minute your order can approve from admin.';
        header('Location: cart.php');
        exit();
    }
    $_SESSION['message'] = 'Error occured while placing order.';
    header('Location: cart.php');
    exit();
    


    $userId = $_POST['userId'];
    $totalAmt = $_POST['totalAmt'];
    echo $userId;
    echo $totalAmt;
} else {
    echo "Invalid Request";
}