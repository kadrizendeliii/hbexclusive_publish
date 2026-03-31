<?php
include_once __DIR__ . '/../config/config.php';
session_start();

// Check if user is admin using correct session variable names
if (empty($_SESSION['user_id']) || empty($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../public/login.php');
    exit;
}

// Check if the ID is passed via the URL
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Security: Ensure ID is always a number

    // Prepare the delete statement
    $sql = "DELETE FROM categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            // Successful deletion redirect
            header("Location: ../admin/manage_categories.php?status=deleted");
            exit();
        } else {
            // Error during execution
            header("Location: ../admin/manage_categories.php?status=error");
            exit();
        }
        $stmt->close();
    } else {
        // Error preparing statement
        header("Location: ../public/manage_categories.php?status=error");
        exit();
    }
} else {
    // Redirect back if no ID was provided
    header("Location: ../public/manage_categories.php");
    exit();
}
?>
