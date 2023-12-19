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
                        <p>Menu-Item</p>
                    </div>
                    <div class="row">
                        <div class="col-8 mx-auto">
                            <form action="menu_item_data.php" method="post" enctype="multipart/form-data">
                                <div class="col-lg-8 mx-auto">
                                    <input type="text" class="form-control" name="item_name" id="item_name" placeholder="Ex. Burger,Pizza..." required>
                                </div>

                                <div class="col-lg-8 mx-auto mt-4">
                                    <input type="text" class="form-control" name="detail" id="detail" placeholder="Ex. Ingredients.." required>
                                </div>
                                <div class="col-lg-8 mt-4 mx-auto">
                                    <select name="category" class="form-select form-select-sm mb-3" aria-label=".form-select-lg example" required>
                                        <option disabled selected>Choose One Category</option>
                                        <?php
                                        $res = $con->query('select * from `category`;');
                                        foreach ($res as $rec) {
                                            echo "<option value='{$rec['id']}'>{$rec['name']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-8 mx-auto my-4">
                                    <input type="number" placeholder="Price" class="form-control" name="price" id="price" required>
                                </div>
                                <div class="col-lg-8 mx-auto my-4">
                                    <input type="number" placeholder="Qty" class="form-control" name="qty" id="qty" required>
                                </div>
                                <div class="col-lg-8 mx-auto my-4">
                                    <input type="file" class="form-control" name="image" id="image" required>
                                </div>
                                <input type="submit" class="btn btn-outline-success d-block mx-auto" value="Add Menu_item">
                            </form>
                            <?php
                            include('message.php');
                            ?>
                        </div>
                    </div>
                    <div class="row mt-5">
                        <div class="col-10 mx-auto table-responsive">
                            <table class="table table-hover">
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Qty</th>
                                    <th>Image</th>
                                    <th class='text-center'>Action</th>
                                </tr>
                                <?php
                                $res = $con->query('select * from `menu_item`;');
                                foreach ($res as $rec) {
                                ?>
                                    <tr class="align-middle">
                                        <td><?= $rec['id']; ?></td>
                                        <td><?= $rec['item_name']; ?></td>
                                        <td>
                                            <?php
                                            $categoryName = mysqli_fetch_assoc($con->query("select * from `category` where id = {$rec['category_id']} limit 1"))['name'];
                                            echo "$categoryName";
                                            ?>
                                        </td>
                                        <td><?= $rec['price']; ?></td>
                                        <td><?= $rec['qty']; ?></td>
                                        <td><img style="width: 200px;height:200px;object-fit:contain;mix-blend-mode: darken;" src="<?= $rec['image']; ?>"></td>
                                        <td>
                                            <div class='row col-10 mx-auto'>
                                                <div class='col-3 mx-auto'>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#openUpdateModal<?= $rec['id']; ?>">Update</button>
                                                    <a href="menu_item_data.php?delete=true&id=<?= $rec['id'] ?>" class='btn btn-danger mt-3'>Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Adding modal for updating category -->
                                    <div id="openUpdateModal<?= $rec['id']; ?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Update Menu_item</h4>
                                                    <button type="button" class="btn close" data-bs-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class=" mx-auto">
                                                            <form action="menu_item_data.php" method="post" enctype="multipart/form-data">
                                                                <input type="text" name="id" value="<?= $rec['id']; ?>" hidden>
                                                                <input type="text" name="update" value="true" hidden>
                                                                <div class="col-lg-8 mx-auto">
                                                                    <input type="text" class="form-control" value="<?= $rec['item_name']; ?>" name="item_name" id="item_name" placeholder="Ex. Italian,Punjabi..." required>
                                                                </div>
                                                                <div class="col-lg-8 mx-auto mt-4">
                                                                    <input type="text" class="form-control" value="<?= $rec['detail']; ?>" name="detail" id="detail" placeholder="Ex. Ingredients.." required>
                                                                </div>
                                                                <div class="col-lg-8 mx-auto">
                                                                    <select name="category" class="form-select mt-4 form-select-sm mb-3" aria-label=".form-select-lg example" required>
                                                                        <option disabled selected>Choose One Category</option>
                                                                        <?php
                                                                        $res = $con->query('select * from `category`;');
                                                                        foreach ($res as $cat) {
                                                                            if ($rec['category_id'] == $cat['id']) {
                                                                                $selected = "selected";
                                                                            } else {
                                                                                $selected = "";
                                                                            }
                                                                            echo "<option {$selected} value='{$cat['id']}'>{$cat['name']}</option>";
                                                                        }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-lg-8 mx-auto">
                                                                    <input type="number" class="form-control" value="<?= $rec['price']; ?>" name="price" id="price" placeholder="Price">
                                                                </div>
                                                                <div class="col-lg-8 mx-auto my-4">
                                                                    <input type="number" class="form-control" value="<?= $rec['qty']; ?>" name="qty" id="qty" placeholder="Qty">
                                                                </div>
                                                                <div class="col-lg-8 mx-auto my-4">
                                                                    <input type="file" class="form-control" name="image" id="image">
                                                                    <span class="text-danger">Upload image if you want to update.</span>
                                                                </div>
                                                                <div class="col-lg-8 mx-auto my-4">
                                                                    <img class="d-block mx-auto" style="width: 200px;height:200px;object-fit:contain;mix-blend-mode: darken;" src="<?= $rec['image']; ?>">
                                                                </div>
                                                                <input type="submit" class="btn btn-outline-success d-block mx-auto" value="Update Menu_item">
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                }
                                ?>
                            </table>
                        </div>
                    </div>

                </div>
            </section>
    <?php
        }
        else {
            include('error.php');
        }
    
    } else {
        include('error.php');
    }
    ?>
</body>
<?php
include('footer_javascript.php');
?>
