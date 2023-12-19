<?php
    if (!isset($_SESSION)) {
        session_start();
    }
    include('dbconf.php');

// Delete Category
if (isset($_GET['delete']) && isset($_GET['id'])) {
    $categoryId = $_GET['id'];

    // Searching category if exists or not  .
    $categoryExist = $con->query("select * from category where id=$categoryId limit 1")->fetch_assoc();
    if ($categoryExist) {

        // Deleting image that is present in our server.
        try {
            unlink($_SERVER['DOCUMENT_ROOT'] . $categoryExist['image']);
        } catch (\Throwable $th) {
            // Ignoring error if it comes when deleting image.
        }

        // Deleting category.
        $con->query("delete from category where id = $categoryId");
        $_SESSION['message'] = 'Deleted Successfully';
        header('Location: category.php');
    } else {
        echo "No category found to delete";
    }
    exit();
}

// Update Category
if (isset($_POST['update']) && isset($_POST['id'])) {
    $categoryId = $_POST['id'];
    $categoryName = $_POST['name'];

    // Searching category if exists or not.
    $categoryExist = $con->query("select * from category where id=$categoryId limit 1")->fetch_assoc();
    if ($categoryExist) {

        // Check if image is uploaded or not. If uploaded then we will update image also.
        if ($_FILES["image"]['name'] == null) {
            $updateQuery  = $con->query("update category set name='$categoryName' where id=$categoryId");
            $statusMsg = "The " . $categoryName . " has been successfully updated .";
        } else {

            // For uploading image of category.
            $uploadTargetDir = $_SERVER['DOCUMENT_ROOT'] . "/restaurants/uploads/category/";
            $dbTargetDirPath = "/restaurants/uploads/category/";
            $uploadedFileName = basename($_FILES["image"]["name"]);

            // Checking uploaded file is image or not
            $fileType = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
            $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
            if (in_array($fileType, $allowTypes)) {
                $imageFileName = $categoryName . '-' . time() . "." . $fileType;
                $categoryName = $categoryName;

                //Uploading image to folder. 
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadTargetDir . $imageFileName)) {

                    // Deleting image that is present in our server and updating image.
                    try {
                        unlink($_SERVER['DOCUMENT_ROOT'] . $categoryExist['image']);
                    } catch (\Throwable $th) {
                        // Ignoring error if it comes when deleting image.
                    }

                    // Insert image file name into database
                    $dbImageFileName = "$dbTargetDirPath" . "$imageFileName";
                    $update = $con->query("UPDATE category SET NAME = '$categoryName', IMAGE = '$dbImageFileName' WHERE ID = $categoryId");
                    if ($update) {
                        $statusMsg = "The " . $categoryName . " has been successfully updated .";
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
        header("Location: category.php");
    } else {
        echo "No category found to update";
    }
    exit();
}

// Create Category
if (isset($_POST['name']) && isset($_FILES['image'])) {

    // For uploading image of category.
    $uploadTargetDir = $_SERVER['DOCUMENT_ROOT'] . "/restaurants/uploads/category/";
    //C:\xampp\htdocs\restaurants\uploads\category
    $dbTargetDirPath = "/restaurants/uploads/category/";
    $uploadedFileName = basename($_FILES["image"]["name"]);

    // Checking uploaded file is image or not
    $fileType = pathinfo($uploadedFileName, PATHINFO_EXTENSION);
    $allowTypes = array('jpg', 'png', 'jpeg', 'webp');
    if (in_array($fileType, $allowTypes)) {
        $imageFileName = $_POST['name'] . '-' . time() . "." . $fileType;
        $categoryName = $_POST['name'];

        //Uploading image to folder. 
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploadTargetDir . $imageFileName)) {

            // Insert image file name into database
            $dbImageFileName = "$dbTargetDirPath" . "$imageFileName";
            $insert = $con->query("INSERT into category (name, image) VALUES ('$categoryName', '$dbImageFileName')");
            if ($insert) {
                $statusMsg = "The " . $categoryName . " has been successfully inserted .";
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
    header("Location: category.php");
    exit();
}

echo "Invalid request made.";
