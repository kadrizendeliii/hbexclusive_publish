<?php 
include __DIR__ . '/../config/config.php'; 

$page_title = "Add Product";
$page_subtitle = "Create a new product for your inventory";

// Fetch categories for the dropdown
$cat_sql = "SELECT id, category_name FROM categories ORDER BY category_name ASC";
$categories = $conn->query($cat_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Inventory System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #d9c600;
            --sidebar-bg: #2c3e50;
            --bg-light: #f8f9fa;
        }

        body { font-family: 'Segoe UI', sans-serif; background: var(--bg-light); }
        .dashboard-wrapper { display: flex; min-height: 100vh; }
        .main-content { margin-left: 260px; flex: 1; transition: all 0.3s ease; }
        .content-area { padding: 40px; }

        /* Form Styling */
        .form-card {
            background: white;
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            max-width: 700px;
            margin: 0 auto;
        }
        .form-header {
            background: white;
            padding: 25px;
            border-bottom: 1px solid #eee;
            border-radius: 15px 15px 0 0;
        }
        .form-body { padding: 30px; }
        
        .form-label { font-weight: 600; color: #555; font-size: 0.85rem; text-transform: uppercase; }
        .form-control, .form-select {
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            background-color: #fcfcfc;
        }
        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25 red rgba(200, 16, 46, 0.1);
        }

        .btn-save { background: var(--secondary-color); border: none; color: white; font-weight: bold; padding: 12px; transition: 0.3s; }
        .btn-save:hover { background: #a00d25; transform: translateY(-2px); }

        .top-header { background: white; padding: 15px 30px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); }

        .top-header .menu-toggle {
            position: relative;
            z-index: 1002;
        }
        
        @media (max-width: 991px) { 
            .main-content { margin-left: 0; } 
            .content-area { padding: 20px !important; }
            .form-card { max-width: 100%; }
        }
        
        @media (max-width: 576px) {
            .content-area { padding: 15px !important; }
            .form-body { padding: 20px !important; }
            .form-card { border-radius: 8px; }
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
            <div class="form-card">
                <div class="form-header text-center">
                    <div class="icon-box mb-2" style="color: var(--secondary-color); font-size: 2rem;">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h4 class="fw-bold mb-0">Product Details</h4>
                    <p class="text-muted small">Fill in the information below to add a new item to stock</p>
                </div>

                <div class="form-body">
                    <form id="productForm" action="../actions/insert_product_logic.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label">Product Name</label>
                                <input type="text" name="product_name" class="form-control" placeholder="Enter product title" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Category</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">Select Category</option>
                                    <?php if ($categories && $categories->num_rows > 0): ?>
                                        <?php while($row = $categories->fetch_assoc()): ?>
                                            <option value="<?php echo $row['id']; ?>"><?php echo $row['category_name']; ?></option>
                                        <?php endwhile; ?>
                                    <?php endif; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price ($)</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" step="0.01" name="price" class="form-control" placeholder="0.00" required>
                                </div>
                            </div>

                            <div class="col-md-12 mb-4">
                                <label class="form-label">Product Image</label>
                                <input type="file" name="product_image" class="form-control" accept="image/*">
                                <div class="form-text">Optional: Max size 2MB (JPG, PNG)</div>
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-save shadow-sm">
                                <i class="fas fa-check-circle me-2"></i>Save Product
                            </button>
                            <a href="manage_categories.php" class="btn btn-light text-muted border-0">Cancel and Return</a>
                        </div>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </main>
</div>

<script>
    window.onload = function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('status') === 'success') {
            Swal.fire({
                icon: 'success',
                title: 'Product Added!',
                text: 'The item has been saved to your inventory.',
                confirmButtonColor: '#c8102e'
            });
        }
    };
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const existingToggleBtn = document.getElementById('menuToggle');

        if (!sidebar || !backdrop || !existingToggleBtn) {
            return;
        }

        const toggleBtn = existingToggleBtn.cloneNode(true);
        existingToggleBtn.parentNode.replaceChild(toggleBtn, existingToggleBtn);

        function setSidebarState(isOpen) {
            sidebar.classList.toggle('active', isOpen);
            backdrop.classList.toggle('active', isOpen);
            toggleBtn.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        }

        function closeSidebar() {
            setSidebarState(false);
        }

        toggleBtn.setAttribute('aria-controls', 'sidebar');
        toggleBtn.setAttribute('aria-expanded', 'false');

        toggleBtn.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            setSidebarState(!sidebar.classList.contains('active'));
        });

        backdrop.addEventListener('click', closeSidebar);

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && sidebar.classList.contains('active')) {
                closeSidebar();
            }
        });

        window.addEventListener('resize', function() {
            if (window.innerWidth > 991) {
                closeSidebar();
            }
        });
    });
</script>

</body>
</html>
