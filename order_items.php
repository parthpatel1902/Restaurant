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
    if (isset($_SESSION['is_admin'])) {
        if ($_SESSION['is_admin'] == '1') {
    ?>
            <section id="book-a-table" class="book-a-table">
                <div class="container">
                    <div class="section-header">
                        <p>Orders</p>
                    </div>
                </div>
            </section>
            <div class="row">
                <div class="col-10 mx-auto table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>customer_id</th>
                                <th>Menu_item</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Status</th>
                                <th>Image</th>
                                <th class='text-center'>Action</th>
                            </tr>
                        </thead>
                        <?php
                        $query = "select customer_order.id,customer_order.customer_id,menu_item.item_name,customer_order.price,customer_order.qty,customer_order.process_status,menu_item.image from customer_order,menu_item where menu_item.id = customer_order.menu_item_id and customer_order.process_status = 'Process'";
                        $res = $con->query($query);
                        foreach ($res as $rec) {

                        ?>
                            <tbody>
                                <tr class="align-middle">
                                    <td><?= $rec['id'] ?></td>
                                    <td><?= $rec['customer_id'] ?></td>
                                    <td><?= $rec['item_name'] ?></td>
                                    <td><?= $rec['price'] ?></td>
                                    <td><?= $rec['qty'] ?></td>
                                    <td><?= $rec['process_status'] ?></td>
                                    <td><img style="width: 200px;height:200px;object-fit:contain;mix-blend-mode: darken;" src="<?= $rec['image']; ?>"></td>
                                    <td>
                                        <form action="confirm_order.php" method="post">
                                            <input type="hidden" name='id' value="<?= $rec['id'] ?>">
                                            <input class="btn btn-danger mx-4" type="submit" name="process__to_confirm" value="Confirm Order">
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
    <?php
        }
    }  ?>
</body>


<?php
include('footer_javascript.php');
?>