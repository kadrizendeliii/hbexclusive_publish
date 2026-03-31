<?php
include_once('../config/config.php');
if (isset($_POST['id']) && isset($_POST['category_name'])) {
    $id = intval($_POST['id']);
    $name = trim($_POST['category_name']);
    if (!empty($name)) {
        $sql = "UPDATE categories SET category_name = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $name, $id);
        if ($stmt->execute()) { echo "success"; } 
        else { echo "error"; }
        $stmt->close();
    }
}
?>