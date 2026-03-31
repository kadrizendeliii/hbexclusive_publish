<?php
include_once __DIR__ . '/../config/config.php';

$page_title = "Activity Log";
$page_subtitle = "Track all admin actions and system events";

// Create activity log table if it doesn't exist
$create_table = "CREATE TABLE IF NOT EXISTS activity_log (
    id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id INT NOT NULL,
    admin_name VARCHAR(255) NOT NULL,
    action VARCHAR(50) NOT NULL,
    entity_type VARCHAR(50) NOT NULL,
    entity_id INT,
    entity_name VARCHAR(255),
    details TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (admin_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX (admin_id),
    INDEX (created_at),
    INDEX (entity_type)
)";
$conn->query($create_table);

// Get filter parameters
$filter_action = isset($_GET['action']) ? $_GET['action'] : '';
$filter_entity = isset($_GET['entity']) ? $_GET['entity'] : '';
$filter_date = isset($_GET['date']) ? $_GET['date'] : '';

// Build query
$query = "SELECT * FROM activity_log WHERE 1=1";
$params = [];
$types = "";

if ($filter_action) {
    $query .= " AND action = ?";
    $params[] = $filter_action;
    $types .= "s";
}

if ($filter_entity) {
    $query .= " AND entity_type = ?";
    $params[] = $filter_entity;
    $types .= "s";
}

if ($filter_date) {
    $query .= " AND DATE(created_at) = ?";
    $params[] = $filter_date;
    $types .= "s";
}

$query .= " ORDER BY created_at DESC LIMIT 500";

if ($types) {
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $logs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
} else {
    $result = $conn->query($query);
    $logs = $result->fetch_all(MYSQLI_ASSOC);
}

// Get unique actions and entities for filters
$actions_res = $conn->query("SELECT DISTINCT action FROM activity_log");
$actions = $actions_res->fetch_all(MYSQLI_ASSOC);

$entities_res = $conn->query("SELECT DISTINCT entity_type FROM activity_log");
$entities = $entities_res->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activity Log - HB Exclusive</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <style>
        :root { --primary-color: #1a1a1a; --secondary-color: #d9c600; }
        body { background: #f4f7fe; font-family: 'Segoe UI', sans-serif; }
        .main-content { margin-left: 260px; padding: 0; }
        .activity-card { background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 12px; padding: 16px; border-left: 4px solid #d9c600; transition: all 0.3s ease; }
        .activity-card:hover { box-shadow: 0 8px 24px rgba(0,0,0,0.12); transform: translateY(-2px); }
        .activity-card.created { border-left-color: #10b981; }
        .activity-card.updated { border-left-color: #3b82f6; }
        .activity-card.deleted { border-left-color: #ef4444; }
        .activity-time { font-size: 0.8rem; color: #9ca3af; }
        .badge-action { font-weight: 600; padding: 4px 8px; border-radius: 4px; }
        .badge-created { background: #d1fae5; color: #065f46; }
        .badge-updated { background: #dbeafe; color: #1e40af; }
        .badge-deleted { background: #fee2e2; color: #991b1b; }
        .filter-section { background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); }
        
        @media (max-width: 991px) { .main-content { margin-left: 0; } }
        @media (max-width: 768px) {
            .activity-card { padding: 12px; }
            .activity-time { font-size: 0.75rem; }
            .fw-bold { font-size: 0.95rem; }
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper">
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    <?php include "../includes/sidebar.php"; ?>

    <main class="main-content">
        <?php include "../includes/dashboard_header.php"; ?>
        
        <div class="content-area">
            <div class="admin-page-shell">
            
            <!-- Filters -->
            <div class="filter-section">
                <h6 class="fw-bold mb-3">Filter Activity</h6>
                <form method="GET" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Action</label>
                        <select name="action" class="form-select form-select-sm">
                            <option value="">All Actions</option>
                            <?php foreach ($actions as $act): ?>
                                <option value="<?php echo $act['action']; ?>" <?php echo $filter_action == $act['action'] ? 'selected' : ''; ?>>
                                    <?php echo ucfirst($act['action']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Entity Type</label>
                        <select name="entity" class="form-select form-select-sm">
                            <option value="">All Types</option>
                            <?php foreach ($entities as $ent): ?>
                                <option value="<?php echo $ent['entity_type']; ?>" <?php echo $filter_entity == $ent['entity_type'] ? 'selected' : ''; ?>>
                                    <?php echo ucfirst($ent['entity_type']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold">Date</label>
                        <input type="date" name="date" class="form-control form-control-sm" value="<?php echo $filter_date; ?>">
                    </div>
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-sm btn-primary w-100"><i class="fas fa-filter me-2"></i>Filter</button>
                        <a href="activity_log.php" class="btn btn-sm btn-outline-secondary"><i class="fas fa-redo"></i></a>
                    </div>
                </form>
            </div>

            <!-- Activity List -->
            <div>
                <?php if (empty($logs)): ?>
                    <div class="alert alert-info text-center py-5">
                        <i class="fas fa-info-circle me-2"></i>No activity logs found
                    </div>
                <?php else: ?>
                    <?php foreach ($logs as $log): 
                        $action_class = strtolower($log['action']);
                        $action_badge = match($log['action']) {
                            'created' => '<span class="badge-action badge-created"><i class="fas fa-plus me-1"></i>Created</span>',
                            'updated' => '<span class="badge-action badge-updated"><i class="fas fa-edit me-1"></i>Updated</span>',
                            'deleted' => '<span class="badge-action badge-deleted"><i class="fas fa-trash me-1"></i>Deleted</span>',
                            'viewed' => '<span class="badge-action" style="background: #f3f4f6; color: #6b7280;"><i class="fas fa-eye me-1"></i>Viewed</span>',
                            default => '<span class="badge-action">' . ucfirst($log['action']) . '</span>'
                        };
                    ?>
                    <div class="activity-card <?php echo $action_class; ?>">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <div>
                                <p class="mb-1 fw-bold" style="font-size: 0.95rem;">
                                    <?php echo htmlspecialchars($log['admin_name']); ?> 
                                    <?php echo $action_badge; ?>
                                    <strong><?php echo htmlspecialchars($log['entity_type']); ?></strong>
                                    <?php if ($log['entity_name']): ?>
                                        : <span style="color: var(--secondary-color);"><?php echo htmlspecialchars($log['entity_name']); ?></span>
                                    <?php endif; ?>
                                </p>
                                <?php if ($log['details']): ?>
                                    <p class="text-muted small mb-0" style="font-size: 0.85rem;"><?php echo htmlspecialchars($log['details']); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="text-end">
                                <div class="activity-time"><?php echo date('M d, Y', strtotime($log['created_at'])); ?></div>
                                <div class="activity-time"><?php echo date('H:i:s', strtotime($log['created_at'])); ?></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            </div>
        </div>
    </main>
</div>

<?php include "../includes/footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
