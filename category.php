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
                        <p>Category</p>
                    </div>
                    <div class="row">
                        <div class="col-8 mx-auto">
                            <form action="category_data.php" method="post" enctype="multipart/form-data">
                                <div class="col-lg-8 mx-auto">
                                    <input type="text" class="form-control" required name="name" id="name" placeholder="Ex. Italian,Punjabi...">
                                </div>
                                <div class="col-lg-8 mx-auto my-4">
                                    <input type="file" class="form-control" required name="image" id="image">
                                </div>
                                <input type="submit" class="btn btn-outline-success d-block mx-auto" value="Add Category">
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
                                    <th>Image</th>
                                    <th class='text-center'>Action</th>
                                </tr>
                                <?php
                                $res = $con->query('select * from `category`;');
                                foreach ($res as $rec) {
                                ?>
                                    <tr class="align-middle">
                                        <td><?= $rec['id']; ?></td>
                                        <td><?= $rec['name']; ?></td>
                                        <td><img style="width: 200px;height:200px;object-fit:contain;mix-blend-mode: darken;" src="<?= $rec['image']; ?>"></td>
                                        <td>
                                            <div class='row col-10 mx-auto'>
                                                <div class='col-3 mx-auto'>
                                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#openUpdateModal<?= $rec['id']; ?>">Update</button>
                                                    <a href="category_data.php?delete=true&id=<?= $rec['id'] ?>" class='btn btn-danger mt-3'>Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Adding modal for updating category -->
                                    <div id="openUpdateModal<?= $rec['id']; ?>" class="modal fade" role="dialog">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title">Update Category</h4>
                                                    <button type="button" class="btn close" data-bs-dismiss="modal">&times;</button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class=" mx-auto">
                                                            <form action="category_data.php" method="post" enctype="multipart/form-data">
                                                                <input type="text" name="id" value="<?= $rec['id']; ?>" hidden>
                                                                <input type="text" name="update" value="true" hidden>
                                                                <div class="col-lg-8 mx-auto">
                                                                    <input type="text" class="form-control" value="<?= $rec['name']; ?>" required name="name" id="name" placeholder="Ex. Italian,Punjabi...">
                                                                </div>
                                                                <div class="col-lg-8 mx-auto my-4">
                                                                    <input type="file" class="form-control" name="image" id="image" placeholder="Ex. Italian,Punjabi...">
                                                                    <span class="text-danger">Upload image if you want to update.</span>
                                                                </div>
                                                                <div class="col-lg-8 mx-auto my-4">
                                                                    <img class="d-block mx-auto" style="width: 200px;height:200px;object-fit:contain;mix-blend-mode: darken;" src="<?= $rec['image']; ?>">
                                                                </div>
                                                                <input type="submit" class="btn btn-outline-success d-block mx-auto" value="Update Category">
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
        } else{
                header("Location: error.php");
        }
        ?>
    <?php
        }
     else {
        include('error.php');
    }
    ?>
</body>
<?php
include('footer_javascript.php');
?>