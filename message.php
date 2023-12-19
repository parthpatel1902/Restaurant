<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['message'])) {
?>
    <div class="alert alert-warning alert-dismissible fade show col-8 mx-auto my-3" role="alert">
        <?= $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php
    unset($_SESSION['message']);
}
?>