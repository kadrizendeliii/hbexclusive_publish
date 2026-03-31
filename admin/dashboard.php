<?php 
include_once("../config/config.php");

$page_title = "Dashboard";
$page_subtitle = "Overview of products, categories, and recent updates";

// Stats Queries
// Orders table no longer exists - set all order-related stats to 0
$total_revenue = 0;
$total_orders = 0;
$total_customers = 0;

$prod_query = $conn->query("SELECT COUNT(id) as total FROM products");
$total_products = $prod_query->fetch_assoc()['total'] ?? 0;

$cat_query = $conn->query("SELECT COUNT(id) as total FROM categories");
$total_categories = $cat_query->fetch_assoc()['total'] ?? 0;

include "../includes/header.php";
?>
<link rel="stylesheet" href="../assets/css/dashboard.css">

<style>
    /* Modern iOS-Inspired Dashboard Header */
    :root {
        --dashboard-header-height: 73px;
    }

    .top-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 100%);
        border-bottom: 1px solid #e5e7eb;
        padding: 14px 20px !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        min-height: var(--dashboard-header-height);
    }

    .top-header h4 {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0;
        letter-spacing: -0.5px;
    }

    .top-header p {
        margin: 0;
        font-size: 0.85rem;
        color: #9ca3af;
    }

    .mobile-nav-toggle {
        background: white;
        border: 1px solid #e5e7eb;
        padding: 8px 12px;
        border-radius: 10px;
        cursor: pointer;
        transition: all 0.3s ease;
        color: var(--primary-color);
        font-size: 1.1rem;
    }

    .mobile-nav-toggle:hover {
        background: linear-gradient(135deg, #fdf2f4 0%, #fff 100%);
        border-color: var(--secondary-color);
        color: var(--secondary-color);
    }

    .header-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        margin-left: auto;
        gap: 12px;
    }

    /* Stats Grid - Modern Cards */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 20px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        overflow: hidden;
        position: relative;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--secondary-color), #d91e3f);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        transform: translateY(-4px);
    }

    .stat-card:hover::before {
        transform: scaleX(1);
    }

    .stat-card-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .stat-info h3 {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--primary-color);
        margin: 0 0 4px 0;
    }

    .stat-info p {
        margin: 0;
        font-size: 0.85rem;
        color: #9ca3af;
        font-weight: 500;
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        flex-shrink: 0;
    }

    .stat-icon.bg-success {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    }

    .stat-icon.bg-primary {
        background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
    }

    .stat-icon.bg-info {
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 100%);
    }

    .stat-icon.bg-warning {
        background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
    }

    /* Content Area */
    .content-area {
        background: #f8f9fa;
        min-height: calc(100vh - 120px);
    }

    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }

        .main-content {
            margin-left: 0 !important;
        }

        .top-header {
            padding: 12px 16px !important;
        }

        .header-right {
            gap: 8px;
        }

        .stat-card {
            padding: 16px;
        }

        .stat-info h3 {
            font-size: 1.5rem;
        }

        .content-area {
            padding: 16px;
        }
    }

    /* Quick Action Links */
    .quick-action-link {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
        padding: 24px 16px;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border: 2px solid #e5e7eb;
        border-radius: 12px;
        text-decoration: none;
        color: var(--primary-color);
        transition: all 0.3s ease;
        font-weight: 500;
        height: 100%;
    }

    .quick-action-link i {
        font-size: 1.8rem;
        color: var(--secondary-color);
    }

    .quick-action-link span {
        color: var(--primary-color);
        font-size: 0.95rem;
    }

    .quick-action-link:hover {
        background: linear-gradient(135deg, var(--secondary-color) 0%, #b91c1c 100%);
        color: white;
        border-color: var(--secondary-color);
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(200, 16, 46, 0.2);
        text-decoration: none;
    }

    .quick-action-link:hover i,
    .quick-action-link:hover span {
        color: white;
    }

    /* Desktop: Sidebar visible */
    @media (min-width: 992px) {
        .main-content {
            margin-left: 260px;
        }

        .menu-toggle {
            display: none !important;
        }
    }

    /* Mobile header padding - account for toggle button space */
    @media (max-width: 991px) {
        .top-header {
            padding: 12px 16px 12px 68px !important;
        }

        .top-header .menu-toggle {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            z-index: 1001;
        }

        .top-header .header-copy {
            min-width: 0;
        }

        .top-header .header-copy h4 {
            font-size: 1.05rem;
        }

        .top-header .header-copy p {
            line-height: 1.3;
        }
    }
</style>

<div class="dashboard-wrapper">
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <?php include "../includes/sidebar.php"; ?>

    <main class="main-content">

        <?php include "../includes/dashboard_header.php"; ?>

        <div class="content-area">
            <div class="admin-page-shell">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-content">
                        <div class="stat-info">
                            <h3><?php echo $total_products; ?></h3>
                            <p>Total Products</p>
                        </div>
                        <div class="stat-icon bg-warning"><i class="fas fa-box"></i></div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card-content">
                        <div class="stat-info">
                            <h3><?php echo $total_categories; ?></h3>
                            <p>Total Categories</p>
                        </div>
                        <div class="stat-icon bg-info"><i class="fas fa-list"></i></div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header p-2 rounded-2"><h5>Quick Actions</h5></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6 col-sm-12 col-12">
                            <a href="add_products.php" class="quick-action-link">
                                <i class="fas fa-plus-circle"></i>
                                <span>Add Product</span>
                            </a>
                        </div>
                        <div class="col-md-6 col-sm-12 col-12">
                            <a href="manage_categories.php" class="quick-action-link">
                                <i class="fas fa-folder-plus"></i>
                                <span>Manage Categories</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5 g-4">
                <div class="col-lg-12">
                    <div class="card" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.08); border-radius: 14px;">
                        <div class="card-header p-2 rounded-2" style="border-bottom: 2px solid #f0f0f0; padding-bottom: 18px; margin-bottom: 18px;"><h5 style="font-weight: 700; color: #1a1a1a;">📦 Recent Products</h5><a href="view_products.php" class="btn btn-primary btn-sm">View All</a></div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr><th>Product Name</th><th>Category</th><th>Price</th><th>Created</th><th>Actions</th></tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $recent = $conn->query("SELECT p.id, p.product_name, p.price, p.created_at, c.category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC LIMIT 5");
                                        while($row = $recent->fetch_assoc()):
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['product_name']); ?></td>
                                            <td><?php echo htmlspecialchars($row['category_name'] ?? 'N/A'); ?></td>
                                            <td>$<?php echo number_format($row['price'], 2); ?></td>
                                            <td><?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                            <td>
                                                <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-light"><i class="fas fa-edit"></i></a>
                                                <a href="../actions/delete_product.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-light text-danger" onclick="return confirm('Delete this product?');"><i class="fas fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        <?php endwhile; ?>
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

<?php include "../includes/footer.php"; ?>
