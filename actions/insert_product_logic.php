<?php
session_start();
include_once __DIR__ . "/../config/config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_name = $_POST['product_name'];
    $category_id = $_POST['category_id'];
    $price = $_POST['price'];

    $target_dir = "../assets/uploads/";
    $image_path = ""; 

    if (isset($_FILES["product_image"]) && $_FILES["product_image"]["error"] == 0) {
        $file_name = time() . "_" . basename($_FILES["product_image"]["name"]);
        $target_file = $target_dir . $file_name;
        if (move_uploaded_file($_FILES["product_image"]["tmp_name"], $target_file)) {
            $image_path = $target_file; 
        }
    }

    $sql = "INSERT INTO products (product_name, price, category_id, image_url) VALUES (?, ?, ?, ?)";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("sdis", $product_name, $price, $category_id, $image_path);
        
        if ($stmt->execute()) {
            header("Location: ../admin/add_products.php?status=success"); 
        } else {
            header("Location: ../public/add_products.php?status=error");
        }
        $stmt->close();
    } 
    $conn->close();
    exit();
}
?>
