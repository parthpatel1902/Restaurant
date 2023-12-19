<?php
include('header.php');
?>

<body>
    <?php
    include('navbar.php');
    include('dbconf.php');
    if (!isset($_SESSION)) {
        session_start();
    }
    if (!isset($_SESSION['id'])) {
        include('error.php');
        exit();
    }

    if ($_SESSION['is_admin'] != '1') {
        include('error.php');
        exit();
    }

    $requested_url = 'all';
    if(isset($_GET['status'])){
        if( $_GET['status'] == 'process' || $_GET['status'] == 'done' || $_GET['status'] == 'reject' ){
            $requested_url = $_GET['status'];
        }
    }

    ?>
    <section id="book-a-table" class="book-a-table">
        <div class="container">
            <div class="section-header">
                <p>Orders</p>
                <div class="row mt-5">
                    <div class="col-10 mx-auto table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer ID</th>
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Order Value</th>
                                    <th class='text-center'>Action</th>
                                </tr>
                            </thead>
                            <?php

                            // $customer_id = $_SESSION['id'];
                            if($requested_url == 'reject'){
                                $order_query = "SELECT CO.*,sum(subtotal) AS order_value FROM CUSTOMER_ORDER AS CO
                                        LEFT JOIN CART AS CT ON CT.ORDER_ID = CO.ID
                                        WHERE CO.STATUS = '$requested_url' group by CO.id ;";
                            }

                            elseif($requested_url == 'process'){
                                $order_query = "SELECT CO.*,sum(subtotal) AS order_value FROM CUSTOMER_ORDER AS CO
                                        LEFT JOIN CART AS CT ON CT.ORDER_ID = CO.ID
                                        WHERE CO.STATUS = '$requested_url' group by CO.id ;";
                            }

                            elseif($requested_url == 'done'){
                                $order_query = "SELECT CO.*,sum(subtotal) AS order_value FROM CUSTOMER_ORDER AS CO
                                        LEFT JOIN CART AS CT ON CT.ORDER_ID = CO.ID
                                        WHERE CO.STATUS = '$requested_url' group by CO.id ;";
                            }
                            
                            else{
                                $order_query = "SELECT CO.*,sum(subtotal) AS order_value FROM CUSTOMER_ORDER AS CO
                                        LEFT JOIN CART AS CT ON CT.ORDER_ID = CO.ID
                                        group by CO.id;";
                            }

                            $res = $con->query($order_query);

                            foreach ($res as $rec) {
                            ?>
                                <tr>
                                    <td><?= $rec['id']; ?></td>
                                    <td><?= $rec['customer_id']; ?></td>
                                    <td><?= $rec['date']; ?></td>
                                    <td><?= $rec['status']; ?></td>
                                    <td><?= $rec['order_value']; ?></td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#openOrderDetail<?= $rec['id']; ?>">
                                            View Details
                                        </button>
                                        <div class="modal fade" id="openOrderDetail<?= $rec['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="orderDetailHeader" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="orderDetailHeader">Order Detail</h5>
                                                        <button type="button" class="btn close" data-bs-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="mx-auto">
                                                                <table class="table table-hover">
                                                                    <tr>
                                                                        <th>Cart ID</th>
                                                                        <th>Item Name</th>
                                                                        <th>Qty</th>
                                                                        <th>Price</th>
                                                                        <th>Subtotal</th>
                                                                    </tr>
                                                                    <?php
                                                                    $order_id = $rec['id'];
                                                                    $cart_query = "SELECT CT.*,item_name FROM CART AS CT
                                                                    LEFT JOIN MENU_ITEM AS MI ON MI.ID = CT.MENU_ITEM_ID
                                                                    WHERE CT.ORDER_ID = $order_id ;
                                                                 ";
                                                                    $cartItems = $con->query($cart_query);
                                                                    foreach ($cartItems as $cartRec) {
                                                                    ?>
                                                                        <tr>
                                                                            <td><?= $cartRec['id']; ?></td>
                                                                            <td><?= $cartRec['item_name']; ?></td>
                                                                            <td><?= $cartRec['qty']; ?></td>
                                                                            <td><?= $cartRec['price']; ?></td>
                                                                            <td><?= $cartRec['subtotal']; ?></td>
                                                                        </tr>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                    <tr class="table-info">
                                                                        <td colspan="4" class="text-end">Total</td>
                                                                        <td><?= $rec['order_value']; ?></td>
                                                                    </tr>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <form action="confirm_order.php" method="post">
                                                            <input type="hidden" name='order_id' value="<?= $rec["id"]; ?>">
                                                            <input type="hidden" name='request_url' value="<?= $requested_url ?>">
                                                            <?php
                                                                if($rec["status"]=='process'){
                                                                    ?>
                                                                    <input class="btn btn-success px-2" type="submit" data-bs-dismiss="modal" name="confirm_order" value="Confirm">
                                                                    <input class="btn btn-danger px-2" type="submit" data-bs-dismiss="modal" name="reject_order" value="Reject">
                                                                    <?php
                                                                }
                                                            ?>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

<?php
include('footer_javascript.php');
?>