<?php
// log_activity.php - Helper function to log admin actions

function logActivity($conn, $action, $entity_type, $entity_id = null, $entity_name = null, $details = null) {
    if (!isset($_SESSION['user_id'])) return false;
    
    try {
        $stmt = $conn->prepare("
            INSERT INTO activity_log (admin_id, admin_name, action, entity_type, entity_id, entity_name, details) 
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->bind_param(
            "ississs",
            $_SESSION['user_id'],
            $_SESSION['user_name'],
            $action,
            $entity_type,
            $entity_id,
            $entity_name,
            $details
        );
        
        return $stmt->execute();
    } catch (Exception $e) {
        error_log("Activity log error: " . $e->getMessage());
        return false;
    }
}
?>
