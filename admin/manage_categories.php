<?php 
include_once('../config/config.php'); 

$page_title = "Manage Categories";
$page_subtitle = "Add and manage product categories";

// Logic to handle adding a new category
if (isset($_POST['add_category'])) {
    $category_name = trim($_POST['category_name']);
    if (!empty($category_name)) {
        $sql = "INSERT INTO categories (category_name) VALUES (?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $category_name);
        if ($stmt->execute()) {
            header("Location: manage_categories.php?status=success");
            exit();
        }
        $stmt->close();
    }
}

// Fetch total count for the counter
$count_res = $conn->query("SELECT COUNT(*) as total FROM categories");
$total_categories = $count_res->fetch_assoc()['total'];

// Note: This assumes you have a 'products' table with a 'category_id'
$top_cat_res = $conn->query("SELECT c.category_name, COUNT(p.id) as count 
                             FROM categories c 
                             LEFT JOIN products p ON c.id = p.category_id 
                             GROUP BY c.id 
                             ORDER BY count DESC LIMIT 1");
$top_category = $top_cat_res->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Categories - Your Business</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #d9c600;
            --accent-color: #2c5f8d;
            --sidebar-bg: #2c3e50;
            --sidebar-hover: #34495e;
            --bg-light: #f8f9fa;
        }

        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: var(--bg-light); }
        .dashboard-wrapper { display: flex; min-height: 100vh; }
        .main-content { margin-left: 260px; flex: 1; transition: all 0.3s ease; }
        .main-content.expanded { margin-left: 0; }
        .content-area { padding: 30px; }

        .card { border: none; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.03); margin-bottom: 25px; overflow: hidden; }
        .card-header { background: white; border-bottom: 1px solid #edf2f9; padding: 18px 25px; }
        .card-header h5 { font-size: 1rem; font-weight: 700; color: #333; }

        .icon-box { width: 48px; height: 48px; border-radius: 10px; display: flex; align-items: center; justify-content: center; }
        .bg-primary-light { background: rgba(13, 110, 253, 0.1); color: #0d6efd; }
        .bg-success-light { background: rgba(25, 135, 84, 0.1); color: #198754; }
        .bg-warning-light { background: rgba(255, 193, 7, 0.1); color: #ffc107; }

        .table thead th { background: #fdfdfd; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; color: #6c757d; border-top: none; }
        .table tbody tr td { vertical-align: middle; padding: 15px 10px; border-color: #f1f4f8; }

        .top-header { background: white; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; position: sticky; top: 0; z-index: 100; }
        .menu-toggle { background: none; border: none; font-size: 1.2rem; cursor: pointer; color: var(--sidebar-bg); }

        @media (max-width: 991px) { .main-content { margin-left: 0; } }
        .hover-shadow:hover { background-color: #fff !important; box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important; transform: translateY(-2px); }
        .transition { transition: all 0.2s ease-in-out; }
    </style>
</head>
<body>

    <div class="dashboard-wrapper">
        <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
        <?php include "../includes/sidebar.php"; ?>

        <main class="main-content" id="mainContent">
            <?php include "../includes/dashboard_header.php"; ?>

            <div class="content-area">
                <div class="admin-page-shell">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card p-3 border-0">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-primary-light me-3"><i class="fas fa-tags fa-lg"></i></div>
                                <div><p class="text-muted mb-0 small fw-bold uppercase">TOTAL CATEGORIES</p><h3 class="fw-bold mb-0"><?php echo $total_categories; ?></h3></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 border-0">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-success-light me-3"><i class="fas fa-star fa-lg"></i></div>
                                <div>
                                    <p class="text-muted mb-0 small fw-bold uppercase">TOP CATEGORY</p>
                                    <h3 class="fw-bold mb-0" style="font-size: 1.1rem;">
                                        <?php echo $top_category['category_name'] ?? 'None'; ?>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3 border-0">
                            <div class="d-flex align-items-center">
                                <div class="icon-box bg-warning-light me-3"><i class="fas fa-clock fa-lg"></i></div>
                                <div><p class="text-muted mb-0 small fw-bold uppercase">LAST UPDATED</p><h3 class="fw-bold mb-0" style="font-size: 1.2rem;"><?php echo date('H:i A'); ?></h3></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header"><h5 class="mb-0"><i class="fas fa-plus me-2"></i>Create New</h5></div>
                            <div class="card-body">
                                <form method="POST">
                                    <div class="mb-3">
                                        <label class="form-label small fw-bold text-muted">CATEGORY NAME</label>
                                        <input type="text" name="category_name" class="form-control form-control-lg" placeholder="e.g. Electronics" required style="font-size: 0.9rem;">
                                    </div>
                                    <button type="submit" name="add_category" class="btn btn-primary w-100 py-2 fw-bold" style="background-color: var(--secondary-color); border:none;">Add Category</button>
                                </form>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-header bg-white"><h6 class="mb-0 fw-bold"><i class="fas fa-history me-2 text-primary"></i>Recent Categories</h6></div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    <?php
                                    $recent = $conn->query("SELECT category_name FROM categories ORDER BY id DESC LIMIT 3");
                                    if($recent->num_rows > 0):
                                        while($r = $recent->fetch_assoc()): ?>
                                        <li class="list-group-item d-flex justify-content-between align-items-center py-3 border-0">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-light p-2 me-3"><i class="fas fa-folder text-secondary small"></i></div>
                                                <span class="small fw-bold text-dark"><?php echo $r['category_name']; ?></span>
                                            </div>
                                            <span class="badge rounded-pill bg-light text-muted fw-normal" style="font-size: 0.65rem;">Just now</span>
                                        </li>
                                    <?php endwhile; else: ?>
                                        <li class="list-group-item text-muted small py-3">No recent activity</li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>

                        <div class="row g-2">
                            <div class="col-6">
                                <a href="add_products.php" class="card text-center p-3 text-decoration-none hover-shadow transition">
                                    <i class="fas fa-box-open text-danger mb-2"></i>
                                    <div class="small fw-bold text-dark">Add Product</div>
                                </a>
                            </div>
                            <div class="col-6">
                                <a href="#" class="card text-center p-3 text-decoration-none hover-shadow transition">
                                    <i class="fas fa-print text-primary mb-2"></i>
                                    <div class="small fw-bold text-dark">Print List</div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center bg-white">
                                <h5 class="mb-0">Manage Categories</h5>
                                <div class="input-group input-group-sm" style="width: 200px;">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fas fa-search"></i></span>
                                    <input type="text" id="categorySearch" class="form-control bg-light border-start-0" placeholder="Search...">
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead>
                                            <tr>
                                                <th class="ps-4">ID</th>
                                                <th>Category Name</th>
                                                <th class="text-end pe-4">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody id="categoryTable">
                                            <?php
                                            $result = $conn->query("SELECT * FROM categories ORDER BY id DESC");
                                            if($result->num_rows > 0):
                                                while($row = $result->fetch_assoc()): ?>
                                                <tr>
                                                    <td class="ps-4 text-muted small">#<?php echo $row['id']; ?></td>
                                                    <td class="fw-bold text-dark"><?php echo htmlspecialchars($row['category_name']); ?></td>
                                                    <td class="text-end pe-4">
                                                        <div class="btn-group">
                                                            <button class="btn btn-sm btn-light border text-primary me-1" 
                                                                    onclick="editCategory(<?php echo $row['id']; ?>, '<?php echo addslashes($row['category_name']); ?>')">
                                                                <i class="fas fa-edit"></i>
                                                            </button>
                                                            <button class="btn btn-sm btn-light border text-danger" 
                                                                    onclick="confirmDelete(<?php echo $row['id']; ?>)">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <?php endwhile; else: ?>
                                                <tr><td colspan="3" class="text-center py-4 text-muted">No categories found.</td></tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            if(sidebar) sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
        }

        // Live Search
        document.getElementById('categorySearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            document.querySelectorAll('#categoryTable tr').forEach(row => {
                let text = row.cells[1] ? row.cells[1].textContent.toLowerCase() : '';
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });

        // Edit using SweetAlert
        function editCategory(id, currentName) {
            Swal.fire({
                title: 'Edit Category',
                input: 'text',
                inputValue: currentName,
                showCancelButton: true,
                confirmButtonColor: '#2c3e50',
                confirmButtonText: 'Save'
            }).then((result) => {
                if (result.isConfirmed && result.value) {
                    const formData = new FormData();
                    formData.append('id', id);
                    formData.append('category_name', result.value);
                    fetch('../actions/update_category_logic.php', { method: 'POST', body: formData })
                    .then(r => r.text())
                    .then(data => {
                        if (data.trim() === 'success') {
                            Swal.fire({ icon: 'success', title: 'Updated!', timer: 1000, showConfirmButton: false }).then(() => location.reload());
                        }
                    });
                }
            });
        }

        // Delete Confirmation with SweetAlert
        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Deleting this category may affect linked products!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#c8102e',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../actions/delete_category.php?id=' + id;
                }
            });
        }

        // Handle Alert Messages from PHP redirects
        window.onload = function() {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('status') === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Category added successfully!',
                    timer: 1500,
                    showConfirmButton: false
                });
            }
        };
    </script>
</body>
</html>
