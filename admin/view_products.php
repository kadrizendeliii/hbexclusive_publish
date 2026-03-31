<?php

include_once('../config/config.php');

$page_title = "Products";
$page_subtitle = "View and manage all inventory";

// 1. Enhanced Stats - Count products and calculate total value

$stats_res = $conn->query("SELECT COUNT(*) as total_skus, SUM(price) as total_value FROM products");

$stats = $stats_res->fetch_assoc();

// 2. Fetch Top Category

$top_cat_res = $conn->query("SELECT c.category_name, COUNT(p.id) as item_count FROM categories c JOIN products p ON c.id = p.category_id GROUP BY c.id ORDER BY item_count DESC LIMIT 1");

$top_cat = $top_cat_res->fetch_assoc();

// 3. Get total categories count

$cat_count_res = $conn->query("SELECT COUNT(*) as total FROM categories");

$cat_count = $cat_count_res->fetch_assoc()['total'] ?? 0;

// Quantity tracking removed - no inventory management needed

// 4. Fetch Categories for Filter

$cat_list = $conn->query("SELECT * FROM categories ORDER BY category_name ASC");

// 5. Fetch Products

$sql = "SELECT p.*, c.category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC";

$result = $conn->query($sql);

include "../includes/header.php";

?>

<style>
    /* --- MOBILE ACCESSIBILITY ADDITIONS --- */
    :root {
        --header-height: 65px;
    }

    @media (max-width: 991px) {
        .main-content { 
            margin-left: 0 !important; 
            padding-top: var(--header-height) !important;
            width: 100% !important;
        }
        
        /* Responsive main content */
        @media (max-width: 991px) {
            .main-content-wrapper {
                margin-left: 0;
            }
        }

        @media (min-width: 992px) {
            .main-content-wrapper {
                margin-left: 260px;
            }
        }

        /* Keeps your table structure traditional but allows swiping */
        .premium-table-card {
            overflow-x: auto;
            white-space: nowrap;
            -webkit-overflow-scrolling: touch;
        }
    }

    .mobile-nav-toggle {
        display: none;
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        margin-right: 15px;
    }

    @media (max-width: 991px) {
        .mobile-nav-toggle { display: block; }
    }
</style>

<div class="dashboard-wrapper">
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <?php include "../includes/sidebar.php"; ?>

    <main class="main-content" style="margin-left: 260px;">
        <?php include "../includes/dashboard_header.php"; ?>

        <div style="padding: 40px;">
            <div class="row g-3 mb-4">

                <div class="col-lg-3 col-sm-6 col-12">

                    <div class="stat-card-premium">

                        <span class="stat-label">Total SKUs (Types)</span>

                        <div class="d-flex align-items-center justify-content-between">

                            <h3 class="stat-value mb-0"><?php echo number_format($stats['total_skus']); ?></h3>

                            <div class="icon-box d-none d-md-flex"><i class="fas fa-barcode"></i></div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-sm-6 col-12">

                    <div class="stat-card-premium">

                        <span class="stat-label">Total Inventory Value</span>

                        <div class="d-flex align-items-center justify-content-between">

                            <h3 class="stat-value mb-0">$<?php echo number_format($stats['total_value'], 2); ?></h3>

                            <div class="icon-box d-none d-md-flex"><i class="fas fa-dollar-sign"></i></div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-sm-6 col-12">

                    <div class="stat-card-premium">

                        <span class="stat-label">Top Category</span>

                        <div class="d-flex align-items-center justify-content-between">

                            <div>

                                <h3 class="stat-value mb-0"><?php echo htmlspecialchars($top_cat['category_name'] ?? 'N/A'); ?></h3>

                                <p class="stat-label small" style="margin: 4px 0 0 0;"><?php echo $top_cat['item_count'] ?? 0; ?> items</p>

                            </div>

                            <div class="icon-box d-none d-md-flex"><i class="fas fa-list"></i></div>

                        </div>

                    </div>

                </div>

                <div class="col-lg-3 col-sm-6 col-12">

                    <div class="stat-card-premium">

                        <span class="stat-label">Total Categories</span>

                        <div class="d-flex align-items-center justify-content-between">

                            <h3 class="stat-value mb-0"><?php echo $cat_count; ?></h3>

                            <div class="icon-box d-none d-md-flex"><i class="fas fa-folder"></i></div>

                        </div>

                    </div>

                </div>





            </div>

            <div class="search-container bg-white p-4 rounded-4 border mb-4 shadow-sm">

                <div class="row g-3 align-items-center">

                    <div class="col-md-5">

                        <div class="input-group">

                            <span class="input-group-text bg-transparent border-end-0"><i class="fas fa-search text-muted"></i></span>

                            <input type="text" id="searchInput" class="form-control border-start-0" placeholder="Search product name or SKU...">

                        </div>

                    </div>

                    <div class="col-md-3">

                        <select id="categoryFilter" class="form-select">

                            <option value="">All Categories</option>

                            <?php

                            $cat_list->data_seek(0);

                            while($c = $cat_list->fetch_assoc()): ?>

                                <option value="<?php echo htmlspecialchars($c['category_name']); ?>"><?php echo $c['category_name']; ?></option>

                            <?php endwhile; ?>

                        </select>

                    </div>

                    <div class="col-md-4 text-end">

                        <div class="d-flex gap-2 justify-content-end">

                            <button class="filter-pill active" id="btnShowAll">All Items</button>

                        </div>

                    </div>

                </div>

            </div>

            <div class="premium-table-card shadow-sm">

                <table class="table table-hover mb-0" id="productTable">

                    <thead>

                        <tr>

                            <th>Product Detail</th>

                            <th>Category</th>

                            <th>Price</th>

                            <th class="text-end">Actions</th>

                        </tr>

                    </thead>

                    <tbody>

                        <?php if($result->num_rows > 0): ?>

                            <?php while($row = $result->fetch_assoc()): ?>

                            <?php

                                $rowData = json_encode($row);

                            ?>

                            <tr class="product-row">

                                <td>

                                    <div class="d-flex align-items-center">

                                        <img src="<?php echo (!empty($row['image_url'])) ? $row['image_url'] : 'https://via.placeholder.com/50'; ?>" class="rounded-3 me-3" style="width:40px; height:40px; object-fit:cover; border:1px solid #eee;">

                                        <div>

                                            <div class="fw-bold product-name" style="font-size: 0.9rem;"><?php echo htmlspecialchars($row['product_name']); ?></div>

                                            <div class="text-muted small">REF: #<?php echo str_pad($row['id'], 5, '0', STR_PAD_LEFT); ?></div>

                                        </div>

                                    </div>

                                </td>

                                <td><span class="badge bg-light text-dark product-category"><?php echo htmlspecialchars($row['category_name']); ?></span></td>

                                <td class="fw-bold text-dark">$<?php echo number_format($row['price'], 2); ?></td>

                                <td class="text-end">

                                    <div class="d-flex gap-1 justify-content-end">

                                        <button onclick='openEditModal(<?php echo htmlspecialchars($rowData, ENT_QUOTES, 'UTF-8'); ?>)' class="btn btn-light border btn-sm shadow-sm"><i class="fas fa-pen fa-xs"></i></button>

                                        <button class="btn btn-light border btn-sm shadow-sm text-danger" onclick="confirmDelete(<?php echo $row['id']; ?>)"><i class="fas fa-trash fa-xs"></i></button>

                                    </div>

                                </td>

                            </tr>

                            <?php endwhile; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="5" class="text-center py-5">

                                    <i class="fas fa-box-open fa-3x text-light mb-3"></i>

                                    <p class="text-muted">No products found in your inventory.</p>

                                </td>

                            </tr>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>

<div class="modal fade" id="editProductModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content rounded-4 border-0 shadow">

            <div class="modal-header border-bottom px-4">

                <h5 class="fw-bold mb-0">Edit Product</h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

            </div>

            <form action="../actions/update_product_logic.php" method="POST" enctype="multipart/form-data">

                <div class="modal-body p-4">

                    <input type="hidden" name="id" id="edit_id">

                    <input type="hidden" name="old_image" id="edit_old_image">

                    <div class="mb-3">

                        <label class="form-label small fw-bold">Product Name</label>

                        <input type="text" name="product_name" id="edit_name" class="form-control" required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label small fw-bold">Category</label>

                        <select name="category_id" id="edit_category_id" class="form-select" required>

                            <option value="">Select Category</option>

                            <?php 

                            $cat_list->data_seek(0);

                            while($c = $cat_list->fetch_assoc()): ?>

                                <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['category_name']); ?></option>

                            <?php endwhile; ?>

                        </select>

                    </div>

                    <div class="row g-3 mb-3">

                        <div class="col-6">

                            <label class="form-label small fw-bold">Price ($)</label>

                            <input type="number" step="0.01" name="price" id="edit_price" class="form-control" required>

                        </div>

                    </div>

                    <div class="mb-0">

                        <label class="form-label small fw-bold">Replace Image (Optional)</label>

                        <input type="file" name="product_image" class="form-control" accept="image/*">

                    </div>

                </div>

                <div class="modal-footer border-0 p-4 pt-0">

                    <button type="submit" class="btn btn-dark w-100 py-2 fw-bold rounded-3">Save & Update Inventory</button>

                </div>

            </form>

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.querySelector('.sidebar') || document.getElementById('sidebar');
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
    });

    // 1. Live Search Filtering

    document.getElementById('searchInput').addEventListener('keyup', function() {

        const query = this.value.toLowerCase();

        const rows = document.querySelectorAll('.product-row');

        rows.forEach(row => {

            const name = row.querySelector('.product-name').textContent.toLowerCase();

            row.style.display = name.includes(query) ? '' : 'none';

        });

    });

    // 2. Category Filtering

    document.getElementById('categoryFilter').addEventListener('change', function() {

        const selected = this.value.toLowerCase();

        const rows = document.querySelectorAll('.product-row');

        rows.forEach(row => {

            const cat = row.querySelector('.product-category').textContent.toLowerCase();

            row.style.display = (selected === "" || cat === selected) ? '' : 'none';

        });

    });



    document.getElementById('btnShowAll').addEventListener('click', function() {

        this.classList.add('active');

        document.getElementById('btnShowLowStock').classList.remove('active');

        const rows = document.querySelectorAll('.product-row');

        rows.forEach(row => row.style.display = '');

    });

    // 4. Modal Population

    const editModal = new bootstrap.Modal(document.getElementById('editProductModal'));

    function openEditModal(data) {

        document.getElementById('edit_id').value = data.id;

        document.getElementById('edit_name').value = data.product_name;

        document.getElementById('edit_price').value = data.price;

        document.getElementById('edit_old_image').value = data.image_url;

        document.getElementById('edit_category_id').value = data.category_id;

        editModal.show();

    }

    // 5. Delete Confirmation

    function confirmDelete(id) {

        Swal.fire({

            title: 'Remove Product?',

            text: "This action will permanently delete this item from stock.",

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#000',

            confirmButtonText: 'Yes, Delete'

        }).then((result) => {

            if (result.isConfirmed) {

window.location.href = '../actions/delete_product.php?id=' + id;

            }

        });

    }

</script>

<!-- Sidebar Toggle Script -->
<script>
    // Additional sidebar close handlers for this page
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        
        if (sidebar && backdrop) {
            // Make sure sidebar closes on mobile when a table action is clicked
            document.querySelectorAll('.btn-edit, .btn-delete').forEach(btn => {
                btn.addEventListener('click', function() {
                    if (window.innerWidth <= 991) {
                        sidebar.classList.remove('active');
                        backdrop.classList.remove('active');
                    }
                });
            });
        }
    });
</script>

</body>

</html>
