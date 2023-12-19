<?php
    if (!isset($_SESSION)) {
        session_start();
    }
include('./dbconf.php');

// Delete Category
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $itemId = $_GET['id'];

    // Searching category if exists or not  .
    $itemExist = $con->query("select * from menu_item where id=$itemId limit 1")->fetch_assoc();
    if ($itemExist) {

        // Deleting image that is present in our server.
        try {
            unlink($_SERVER['DOCUMENT_ROOT'] . $itemExist['image']);
        } catch (\Throwable $th) {
            // Ignoring error if it comes when deleting image.
        }

        // Deleting category.
        $con->query("delete from menu_item where id = $itemId");
        $_SESSION['message'] = 'Deleted Successfully';
        header('Location: menu_item.php');
    } else {
        echo "No Item found to delete";
    }
    exit();
}

// Update Category
if (isset($_POST['update']) && isset($_POST['id'])) {
    $itemId = $_POST['id'];
    $item_name = $_POST['item_name'];
    $category = $_POST['category'];
    $price = $_POST['price'];
    $qty = $_POST['qty'];
    $detail = $_POST['detail'];

    // Searching category if exists or not.
    $menu_item_exist = $con->query("select * from menu_item where id=$itemId limit 1")->fetch_assoc();
    if ($menu_item_exist) {

        // Check if image is uploaded or not. If uploaded then we will update image also.
        if ($_FILES["image"]['name'] == null) {
            $updateQuery  = $con->query("update menu_item set item_name='$item_name',detail='$detail',category_id=$category,price=$price,qty=$qty where id=$itemId");
            $statusMsg = "The " . $item_name . " has been successfully updated .";
        } else {

            // For uploading image of category.
            $uploadTargetDir = $_SERVER['DOCUMENT_ROOT'] . "/restaurants/uploads/menu_item/";
            $dbTargetDirPath = "/restaurants/uploads/menu_item/";
            $uploadedFileName = basename($_FILES["image"]["name"]);

            // Checking uploaded file is image or not
            $fileType = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
            $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
            if (in_array($fileType, $allowTypes)) {
                $imageFileName = $item_name . '-' . time() . "." . $fileType;
                $item_name = $item_name;

                //Uploading image to folder. 
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadTargetDir . $imageFileName)) {

                    // Deleting image that is present in our server and updating image.
                    try {
                        unlink($_SERVER['DOCUMENT_ROOT'] . $menu_item_exist['image']);
                    } catch (\Throwable $th) {
                        // Ignoring error if it comes when deleting image.
                    }

                    // Insert image file name into database
                    $dbImageFileName = "$dbTargetDirPath" . "$imageFileName";
                    $update = $con->query("UPDATE menu_item SET item_name = '$item_name', image = '$dbImageFileName' WHERE ID = $itemId");
                    if ($update) {
                        $statusMsg = "The " . $item_name . " has been successfully updated .";
                    } else {
                        $statusMsg = "File upload failed, please try again.";
                    }
                } else {
                    $statusMsg = "Sorry, there was an error uploading your file.";
                }
            } else {
                $statusMsg =  "Uploaded file is not image.";
            }
        }
        $_SESSION['message'] = $statusMsg;
        header("Location: menu_item.php");
    } else {
        echo "No Item found to update";
    }
    exit();
}

// Create Category
if (isset($_POST['item_name']) && isset($_POST['category']) && isset($_POST['price']) && isset($_FILES['image'])) {

    // For uploading image of category.
    $uploadTargetDir = $_SERVER['DOCUMENT_ROOT'] . "/restaurants/uploads/menu_item/";
    $dbTargetDirPath = "/restaurants/uploads/menu_item/";
    $uploadedFileName = basename($_FILES["image"]["name"]);

    // Checking uploaded file is image or not
    $fileType = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
    if (in_array($fileType, $allowTypes)) {
        $item_name = $_POST['item_name'];
        $category = $_POST['category'];
        $price = $_POST['price'];
        $qty = $_POST['qty'];
        $detail = $_POST['detail'];
        $imageFileName = $_POST['item_name'] . '-' . time() . "." . $fileType;

        //Uploading image to folder. 
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadTargetDir . $imageFileName)) {

            // Insert image file name into database
            $dbImageFileName = "$dbTargetDirPath" . "$imageFileName";
            $insert = $con->query("INSERT into menu_item (item_name,detail,category_id,price,image,qty) VALUES ('$item_name','$detail', $category,$price,'$dbImageFileName',$qty)");
            if ($insert) {
                $statusMsg = "The " . $item_name . " has been successfully inserted .";
            } else {
                $statusMsg = "File upload failed, please try again.";
            }
        } else {
            $statusMsg = "Sorry, there was an error uploading your file.";
        }
    } else {
        $statusMsg =  "Uploaded file is not image.";
    }
    $_SESSION['message'] = $statusMsg;
    header("Location: menu_item.php");
}

echo "Invalid request made.";
