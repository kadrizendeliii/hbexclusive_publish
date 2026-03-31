<?php
include_once __DIR__ . '/../config/config.php';
session_start();

// Check if user is admin
if (empty($_SESSION['user_id']) || empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../public/login.php');
    exit;
}

if(isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Optional: Delete the physical image file from the folder too
    $res = $conn->query("SELECT image_url FROM products WHERE id = $id");
    $row = $res->fetch_assoc();
    if(!empty($row['image_url']) && file_exists($row['image_url'])) {
        unlink($row['image_url']);
    }

    $sql = "DELETE FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    if($stmt->execute()) {
        header("Location: ../admin/view_products.php?msg=deleted");
        exit();
    } else {
        header("Location: ../admin/view_products.php?msg=error");
        exit();
    }
    $stmt->close();
} else {
    header("Location: ../public/view_products.php");
    exit();
}
?>
