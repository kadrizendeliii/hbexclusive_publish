<?php 
include_once __DIR__ . '/../config/config.php'; 

// 1. Get the current product data
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $res = $conn->query("SELECT * FROM products WHERE id = $id");
    $product = $res->fetch_assoc();
    
    if (!$product) {
        header("Location: view_products.php");
        exit();
    }
}

$page_title = "Edit Product";
$page_subtitle = "Modify product details and information";

// 2. Fetch categories for the dropdown
$categories = $conn->query("SELECT * FROM categories ORDER BY category_name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - <?php echo $product['product_name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root { --secondary-color: #d9c600; --bg-light: #f8f9fa; }
        body { background: var(--bg-light); font-family: 'Segoe UI', sans-serif; }
        .main-content { margin-left: 260px; padding: 40px; }
        .form-card { background: white; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto; overflow: hidden; }
        .current-img-preview { width: 120px; height: 120px; object-fit: cover; border-radius: 10px; border: 3px solid #eee; }
        @media (max-width: 991px) { 
            .main-content { margin-left: 0; } 
            .main-content { padding: 20px !important; }
            .form-card { max-width: 100%; }
        }
        
        @media (max-width: 576px) {
            .main-content { padding: 15px !important; }
            .form-body { padding: 20px !important; }
            .form-card { border-radius: 8px; }
            .current-img-preview { width: 100px; height: 100px; }
        }
    </style>
</head>
<body>

<div class="dashboard-wrapper d-flex">
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>
    <?php include "../includes/sidebar.php"; ?>

    <main class="main-content w-100">
        <?php include "../includes/dashboard_header.php"; ?>
        
        <div class="content-area">
        <div class="admin-page-shell">
        <div class="form-card">
            <div class="p-4 bg-white border-bottom d-flex justify-content-between align-items-center">
                <h4 class="fw-bold mb-0">Product Information</h4>
                <a href="view_products.php" class="btn btn-light btn-sm">Back to Products</a>
            </div>

            <form action="../actions/update_product_logic.php" method="POST" enctype="multipart/form-data" class="p-4">
                <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                <input type="hidden" name="old_image" value="<?php echo $product['image_url']; ?>">

                <div class="row">
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label fw-bold small text-muted">PRODUCT NAME</label>
                            <input type="text" name="product_name" class="form-control" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">CATEGORY</label>
                                <select name="category_id" class="form-select" required>
                                    <?php while($cat = $categories->fetch_assoc()): ?>
                                        <option value="<?php echo $cat['id']; ?>" <?php echo ($cat['id'] == $product['category_id']) ? 'selected' : ''; ?>>
                                            <?php echo $cat['category_name']; ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold small text-muted">PRICE ($)</label>
                                <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $product['price']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4 text-center border-start">
                        <label class="form-label fw-bold small text-muted">CURRENT IMAGE</label>
                        <div class="mb-3">
                            <img src="<?php echo !empty($product['image_url']) ? $product['image_url'] : 'https://via.placeholder.com/150'; ?>" class="current-img-preview" id="preview">
                        </div>
                        <input type="file" name="product_image" class="form-control form-control-sm" onchange="previewFile()">
                    </div>
                </div>

                <div class="mt-4 pt-3 border-top">
                    <button type="submit" class="btn btn-danger w-100 fw-bold py-2" style="background: var(--secondary-color);">
                        <i class="fas fa-save me-2"></i>Update Product Details
                    </button>
                </div>
            </form>
        </div>
        </div>
    </main>
</div>

<script>
    function previewFile() {
        const preview = document.getElementById('preview');
        const file = document.querySelector('input[type=file]').files[0];
        const reader = new FileReader();
        reader.onloadend = function () { preview.src = reader.result; }
        if (file) { reader.readAsDataURL(file); }
    }
</script>

</body>
</html>
