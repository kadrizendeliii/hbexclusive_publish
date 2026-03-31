<?php
include_once __DIR__ . '/../config/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = intval($_POST['id']);
    $name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];
    $image_path = $_POST['old_image']; 

    if (isset($_FILES["product_image"]) && $_FILES["product_image"]["error"] == 0) {
        $target_dir = "uploads/";
        $file_name = time() . "_" . basename($_FILES["product_image"]["name"]);
        $target_file = $target_dir . $file_name;

        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            if (!empty($_POST['old_image']) && file_exists($_POST['old_image'])) {
                unlink($_POST['old_image']);
            }
            $image_path = $target_file;
        }
    }

    $sql = "UPDATE products SET product_name=?, price=?, category_id=?, image_url=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    
    $stmt->bind_param("sdisi", $name, $price, $category_id, $image_path, $id);

    if ($stmt->execute()) {
        header("Location: ../admin/view_products.php?status=updated");
    } else {
        header("Location: ../admin/view_products.php?status=error");
    }
    exit();
}
?>
