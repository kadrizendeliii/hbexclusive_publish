<?php 
$current_page = basename($_SERVER['SCRIPT_NAME']);

$category_count = 0;
if (isset($conn) && $conn) {
    $cat_count_res = $conn->query("SELECT COUNT(*) as total FROM categories");
    if ($cat_count_res) {
        $cat_data = $cat_count_res->fetch_assoc();
        $category_count = $cat_data['total'] ?? 0;
    }
}
?>

<style>
    :root {
        --primary-color: #1a1a1a;
        --secondary-color: #d9c600;
        --accent-color: #c4a500;
    }

    .sidebar {
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.97) 0%, rgba(249, 247, 239, 0.98) 100%);
        width: 260px;
        position: fixed;
        left: 0;
        top: 0;
        height: 100vh;
        overflow-y: auto;
        overflow-x: hidden;
        padding: 0;
        z-index: 50;
        border-right: 1px solid rgba(217, 198, 0, 0.14);
        box-shadow: 8px 0 30px rgba(0, 0, 0, 0.06);
        transition: transform 0.35s cubic-bezier(0.4, 0, 0.2, 1), top 0.35s ease, height 0.35s ease;
        transform: translateX(0);
        will-change: transform;
        pointer-events: auto;
    }

    .sidebar-header {
        padding: 18px 20px;
        border-bottom: 1px solid rgba(217, 198, 0, 0.14);
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255, 255, 255, 0.96);
        position: sticky;
        top: 0;
        z-index: 10;
        flex-shrink: 0;
        min-height: 64px;
    }

    .sidebar-header i {
        font-size: 1.45rem;
        color: var(--accent-color);
    }

    .sidebar-header h3 {
        margin: 0;
        font-size: 1.08rem;
        font-weight: 700;
        color: var(--primary-color);
        letter-spacing: -0.03em;
    }

    .sidebar-menu {
        list-style: none;
        padding: 16px 10px;
        margin: 0;
        max-height: calc(100vh - 96px);
        overflow-y: auto;
        overflow-x: hidden;
        -webkit-overflow-scrolling: touch;
    }

    .sidebar-menu li {
        margin-bottom: 4px;
    }

    .sidebar-menu .menu-label {
        padding: 14px 16px 8px;
        font-size: 0.66rem;
        font-weight: 800;
        text-transform: uppercase;
        color: #8a8170;
        letter-spacing: 0.12em;
        margin-top: 12px;
        display: block;
    }

    .sidebar-menu a {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        color: #4b5563;
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.25s ease;
        position: relative;
        font-size: 0.92rem;
        font-weight: 600;
    }

    .sidebar-menu a i {
        font-size: 1rem;
        width: 22px;
        text-align: center;
        transition: all 0.25s ease;
        color: #7a7a7a;
    }

    .sidebar-menu a span {
        flex: 1;
        color: #1f2937;
    }

    .sidebar-menu a:hover {
        background-color: rgba(217, 198, 0, 0.1);
        color: var(--accent-color);
        padding-left: 18px;
    }

    .sidebar-menu a:hover i {
        color: var(--accent-color);
        transform: translateX(2px);
    }

    .sidebar-menu a.active {
        background: linear-gradient(135deg, #1a1a1a 0%, #2f2f2f 100%);
        color: white;
        box-shadow: 0 10px 24px rgba(26, 26, 26, 0.18);
    }

    .sidebar-menu a.active i,
    .sidebar-menu a.active span {
        color: white;
    }

    .badge {
        background: var(--secondary-color);
        color: #1a1a1a;
        font-size: 0.65rem;
        padding: 2px 7px;
        border-radius: 999px;
        font-weight: 700;
        margin-left: auto;
    }

    .sidebar::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: #c9c0aa;
        border-radius: 3px;
    }

    .sidebar-backdrop {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0);
        opacity: 0;
        z-index: 998;
        transition: opacity 0.35s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        pointer-events: none;
        display: none;
        visibility: hidden;
    }

    .sidebar-backdrop.active {
        background: rgba(0, 0, 0, 0.45);
        opacity: 1;
        pointer-events: all;
        display: block !important;
        visibility: visible;
    }

    @media (max-width: 991px) {
        .sidebar-backdrop {
            top: var(--header-height, 72px);
            height: calc(100vh - var(--header-height, 72px));
        }

        .sidebar {
            transform: translateX(-100%) !important;
            z-index: 999 !important;
            top: var(--header-height, 72px) !important;
            height: calc(100vh - var(--header-height, 72px)) !important;
            width: 280px !important;
            max-width: 90vw !important;
            pointer-events: none !important;
            box-shadow: none !important;
        }

        .sidebar.active {
            transform: translateX(0) !important;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
            pointer-events: auto !important;
        }

        .sidebar-menu {
            max-height: calc(100vh - var(--header-height, 72px) - 64px) !important;
        }
    }

    @media (max-width: 768px) {
        .sidebar {
            width: 280px;
            max-width: 90vw;
        }

        .sidebar-menu {
            padding: 12px 8px;
        }

        .sidebar-menu a {
            padding: 10px 12px;
            font-size: 0.88rem;
            gap: 10px;
        }

        .sidebar-header {
            padding: 16px 15px;
        }
    }
</style>

<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-store"></i>
        <h3>HB Exclusive</h3>
    </div>
    
    <ul class="sidebar-menu">
        <li>
            <a href="dashboard.php" class="<?php echo ($current_page == 'dashboard.php') ? 'active' : ''; ?>">
                <i class="fas fa-chart-pie"></i>
                <span>Dashboard</span>
            </a>
        </li>
        
        <li class="menu-label">Products</li>
        
        <li>
            <a href="view_products.php" class="<?php echo ($current_page == 'view_products.php') ? 'active' : ''; ?>">
                <i class="fas fa-boxes"></i>
                <span>All Products</span>
            </a>
        </li>
        
        <li>
            <a href="add_products.php" class="<?php echo ($current_page == 'add_products.php') ? 'active' : ''; ?>">
                <i class="fas fa-plus-circle"></i>
                <span>Add Product</span>
            </a>
        </li>
        
        <li>
            <a href="manage_categories.php" class="<?php echo ($current_page == 'manage_categories.php') ? 'active' : ''; ?>">
                <i class="fas fa-folder-open"></i>
                <span>Categories</span>
                <span class="badge"><?php echo $category_count; ?></span>
            </a>
        </li>

    </ul>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const backdrop = document.getElementById('sidebarBackdrop');
        const existingToggleBtn = document.getElementById('menuToggle');
        const header = document.querySelector('.top-header');

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

        function syncHeaderHeight() {
            if (!header) {
                return;
            }

            document.documentElement.style.setProperty('--header-height', header.offsetHeight + 'px');
        }

        toggleBtn.setAttribute('aria-controls', 'sidebar');
        toggleBtn.setAttribute('aria-expanded', 'false');

        syncHeaderHeight();

        toggleBtn.addEventListener('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            setSidebarState(!sidebar.classList.contains('active'));
        });

        backdrop.addEventListener('click', closeSidebar);

        sidebar.querySelectorAll('.sidebar-menu a').forEach(link => {
            link.addEventListener('click', function() {
                if (window.innerWidth <= 991) {
                    closeSidebar();
                }
            });
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && sidebar.classList.contains('active')) {
                closeSidebar();
            }
        });

        window.addEventListener('resize', function() {
            syncHeaderHeight();
            if (window.innerWidth > 991) {
                closeSidebar();
            }
        });
    });
</script>
