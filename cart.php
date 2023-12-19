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
                <p>Cart-Item</p>
            </div>
            <?php
            include('message.php');
            ?>
            <div class="row">
                <?php
                $customer_id = $_SESSION['id'];
                $query = "SELECT CRT.*,item_name,image FROM CART AS CRT
                    LEFT JOIN MENU_ITEM AS MI ON CRT.MENU_ITEM_ID = MI.ID
                    WHERE CUSTOMER_ID = $customer_id AND STATUS = 'draft';
                    ";

                $res = $con->query($query);

                // checking if current user has any thing in cart.
                
                if($res->num_rows > 0){
                    foreach ($res as $rec) {
                    ?>
                        <div class="col-md-4 mt-3 d-flex justify-content-center">
                            <div class="card" style="width: 18rem; height:28rem">
                                <img class="card-img-top border p-2" style="width: 18rem;height:15rem;object-fit: contain;" src="<?= $rec['image'] ?>" alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">Item : <?= $rec['item_name']; ?></h5>
                                    <p class="title my-2">Price : <?= $rec['price']; ?></p>
                                    <p class="title">SubTotal : <?= $rec['subtotal']; ?></p>
                                    <form action="handleCart.php" method="post">
                                        <input type="hidden" name='cart_id' value="<?= $rec["id"]; ?>">
                                        <input type="hidden" name='price' value="<?= $rec["price"]; ?>">
                                        <input class="btn btn-primary px-4" style="font-size: 20px;" type="submit" name="add_To_Cart" value="+">
                                        <span class="lead px-3"> <?= $rec['qty']; ?></span>
                                        <input class="btn btn-danger px-4" style="font-size: 20px;" type="submit" name="remove_To_Cart" value="-">
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                    ?>
            </div>
            <div class="row">
                <div class="col-12 mt-4" style="border-radius: 9px;">
                    <?php
                    
                    $query = "SELECT SUM(subtotal) AS TotalAmount FROM cart
                    where customer_id = $customer_id and status = 'draft'";
                    $res = $con->query($query);
                    
                    foreach ($res as $rec) {
                    ?>
                        <p class="title mx-5 float-end" style="font-size: 30px;">Total : <?= $rec['TotalAmount'] ?></p>

                </div>
            </div>
            <form action="checkout.php" method="post">
                <input type="hidden" name='userId' value="<?= $customer_id ?>">
                <input type="hidden" name='totalAmt' value="<?= $rec["TotalAmount"]; ?>">
                <input class="btn btn-danger mx-4  float-end" type="submit" name="process_to_checkout" value="Process To Checkout">
            </form>
        </div>
        <?php }
        }

        // If no cart item is there then we will show message
        else{
        ?>
            <h3 class="text-center text-muted">🍔🛒 Hungry for more? Your cart's feeling a bit light! 🛒🍔</h3>
        <?php
        }
    ?>
    </section>
</body>

<?php
include('footer_javascript.php');
?>