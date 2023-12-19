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
                                    <th>Order Date</th>
                                    <th>Status</th>
                                    <th>Order Value</th>
                                    <th class='text-center'>Action</th>
                                    <th class='text-center'>Download Bill</th>
                                </tr>
                            </thead>
                            <?php

                            $customer_id = $_SESSION['id'];

                            $order_query = "SELECT CO.*,sum(subtotal) AS order_value FROM CUSTOMER_ORDER AS CO
                                    LEFT JOIN CART AS CT ON CT.ORDER_ID = CO.ID
                                    where CO.customer_id = $customer_id group by CO.id ORDER BY DATE DESC;";

                            $res = $con->query($order_query);

                            foreach ($res as $rec) {
                            ?>
                                <tr>
                                    <td><?= $rec['id']; ?></td>
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
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="order_bill_pdf.php?user_id=<?= $rec['customer_id'] ?>&order_id=<?= $rec['id'] ?>" download>Download</a>
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
