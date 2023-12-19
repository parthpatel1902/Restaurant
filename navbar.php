<!-- ======= Header ======= -->
<?php
include('dbconf.php');
if (!isset($_SESSION)) {
    session_start();
}
?>
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

        <a href="index.php" class="logo d-flex align-items-center me-auto me-lg-0">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <h1>Yummy<span>.</span></h1>
            <!-- <img src="assets/img/logo.png" alt=""> -->
        </a>

        <nav id="navbar" class="navbar">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <?php
                if (isset($_SESSION['id'])) {
                ?>
                    <li><a href="cart.php">Cart</a></li>
                    <li><a href="order.php">Order</a></li>
                <?php
                } else {
                ?>
                    <li><a href="login.php">Cart</a></li>
                <?php
                }
                ?>

                <?php
                if (isset($_SESSION['is_admin'])) {
                    if ($_SESSION['is_admin'] == '1') {
                ?>
                        <li class="dropdown"><a href="#"><span>Admin Panel</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                            <ul>
                                <li><a href="category.php">Category</a></li>
                                <li><a href="menu_item.php">Menu_item</a></li>
                                <li class="dropdown"><a href="customer_orders.php"><span>Orders</span> <i class="bi bi-chevron-down dropdown-indicator"></i></a>
                                    <ul>
                                        <li><a href="customer_orders.php?status=process">To Process</a></li>
                                        <li><a href="customer_orders.php?status=done">Done</a></li>
                                        <li><a href="customer_orders.php?status=reject">Rejected</a></li>
                                        <li><a href="customer_orders.php">All</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>
                <?php
                    }
                }
                ?>
            </ul>
        </nav><!-- .navbar -->
        <?php
        if (isset($_SESSION["id"])) {
            echo '<a class="btn-book-a-table" href="logout.php">Log Out</a>';
        } else {
            echo '<a class="btn-book-a-table" href="login.php">Login</a>';
        }
        ?>
        <i class="mobile-nav-toggle mobile-nav-show bi bi-list"></i>
        <i class="mobile-nav-toggle mobile-nav-hide d-none bi bi-x"></i>

    </div>
</header><!-- End Header -->