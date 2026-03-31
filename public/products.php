<?php
include_once('../config/config.php');

$total_all_result = $conn->query("SELECT COUNT(*) as total FROM products");
$total_all = $total_all_result ? (int) $total_all_result->fetch_assoc()['total'] : 0;

$categories = [];
$cats_result = $conn->query("SELECT c.*, (SELECT COUNT(*) FROM products p WHERE p.category_id = c.id) as p_count FROM categories c ORDER BY c.category_name ASC");
if ($cats_result) {
    while ($category = $cats_result->fetch_assoc()) {
        $categories[] = $category;
    }
}

$products = [];
$prod_sql = "SELECT p.*, c.category_name FROM products p JOIN categories c ON p.category_id = c.id ORDER BY p.id DESC";
$prod_result = $conn->query($prod_sql);
if ($prod_result) {
    while ($product = $prod_result->fetch_assoc()) {
        $products[] = $product;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Products - Exclusive Doors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #1a1a1a;
            --secondary-color: #D9C600;
            --accent-color: #C4A500;
            --light-bg: #f8f9fa;
            --gradient-primary: linear-gradient(135deg, #D9C600 0%, #b89e00 100%);
            --gradient-warm: linear-gradient(135deg, #C4A500 0%, #7f6600 100%);
            --gold-soft: rgba(217, 198, 0, 0.14);
            --shadow-lg: 0 24px 60px rgba(17, 17, 17, 0.16);
            --shadow-md: 0 16px 36px rgba(17, 17, 17, 0.10);
            --radius-xl: 28px;
            --radius-lg: 20px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            background:
                radial-gradient(circle at top left, rgba(217, 198, 0, 0.14), transparent 28%),
                linear-gradient(180deg, #f5f5f5 0%, #ffffff 48%, #f8f9fa 100%);
            min-height: 100vh;
            padding-top: 92px;
        }

        a {
            text-decoration: none;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            border-bottom: none;
            backdrop-filter: blur(10px);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.8rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            letter-spacing: -1px;
        }

        .navbar-toggler {
            border: 0;
            padding: 0.35rem 0.55rem;
            color: var(--secondary-color);
        }

        .navbar-toggler:focus {
            box-shadow: none;
            outline: 2px solid var(--secondary-color);
            outline-offset: 2px;
        }

        .navbar-toggler-icon {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 30 30'%3e%3cpath stroke='%23ffdd00' stroke-linecap='round' stroke-miterlimit='10' stroke-width='2' d='M4 7h22M4 15h22M4 23h23'/%3e%3c/svg%3e");
        }

        .nav-link {
            color: #333 !important;
            font-size: 0.95rem;
            font-weight: 600;
            letter-spacing: 0.02em;
            margin: 0 12px;
        }

        .nav-link:hover,
        .nav-link:focus {
            color: var(--secondary-color) !important;
        }

        .btn-nav-cta {
            background: var(--gradient-primary);
            color: #fff !important;
            border-radius: 999px;
            padding: 11px 28px;
            margin-left: 15px;
            box-shadow: 0 8px 25px rgb(229, 226, 20);
            font-weight: 800;
            font-size: 0.9rem;
            letter-spacing: 0.7px;
            position: relative;
            overflow: hidden;
            border: none;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        .btn-nav-cta::before {
            content: "";
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.2);
            transition: left 0.5s ease;
        }

        .btn-nav-cta:hover,
        .btn-nav-cta:focus {
            background: var(--gradient-primary);
            color: #fff7b8 !important;
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgb(229, 226, 20);
        }

        .btn-nav-cta:hover::before,
        .btn-nav-cta:focus::before {
            left: 100%;
        }

        .catalog-shell {
            width: min(1240px, calc(100% - 32px));
            margin: 0 auto 56px;
        }

        .catalog-hero {
            position: relative;
            overflow: hidden;
            border-radius: var(--radius-xl);
            padding: 38px 40px;
            margin-bottom: 28px;
            background:
                linear-gradient(135deg, rgba(26, 26, 26, 0.94), rgba(47, 47, 47, 0.92)),
                linear-gradient(120deg, rgba(217, 198, 0, 0.14), transparent 60%);
            box-shadow: var(--shadow-lg);
            color: #fff;
        }

        .catalog-hero::after {
            content: "";
            position: absolute;
            inset: auto -70px -70px auto;
            width: 220px;
            height: 220px;
            border-radius: 50%;
            background: radial-gradient(circle, rgba(217, 198, 0, 0.32), transparent 72%);
            pointer-events: none;
        }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            font-size: 0.82rem;
            text-transform: uppercase;
            letter-spacing: 0.16em;
            color: rgba(255, 255, 255, 0.72);
            margin-bottom: 1rem;
        }

        .hero-eyebrow::before {
            content: "";
            width: 36px;
            height: 1px;
            background: var(--secondary-color);
        }

        .catalog-hero h1 {
            font-size: clamp(2rem, 4vw, 3.7rem);
            line-height: 0.98;
            margin: 0 0 1rem;
            letter-spacing: -0.05em;
        }

        .catalog-hero p {
            margin: 0;
            max-width: 650px;
            font-size: 1.02rem;
            line-height: 1.75;
            color: rgba(255, 255, 255, 0.82);
        }

        .hero-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 1.75rem;
        }

        .hero-stat {
            min-width: 132px;
            padding: 14px 16px;
            border-radius: 18px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }

        .hero-stat strong {
            display: block;
            font-size: 1.4rem;
            color: #fff;
        }

        .hero-stat span {
            font-size: 0.82rem;
            color: rgba(255, 255, 255, 0.72);
            text-transform: uppercase;
            letter-spacing: 0.08em;
        }

        .catalog-layout {
            display: grid;
            grid-template-columns: 290px minmax(0, 1fr);
            gap: 24px;
            align-items: start;
        }

        .category-sidebar {
            position: sticky;
            top: 112px;
            border-radius: var(--radius-xl);
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(217, 198, 0, 0.14);
            backdrop-filter: blur(12px);
            box-shadow: var(--shadow-md);
            padding: 24px;
        }

        .sidebar-kicker {
            font-size: 0.78rem;
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--accent-color);
            margin-bottom: 0.7rem;
            font-weight: 700;
        }

        .category-sidebar h2 {
            margin: 0 0 0.7rem;
            font-size: 1.7rem;
            line-height: 1.05;
            color: var(--primary-color);
        }

        .sidebar-text {
            margin: 0 0 1.3rem;
            color: #666;
            font-size: 0.95rem;
            line-height: 1.65;
        }

        .category-list {
            list-style: none;
            margin: 0;
            padding: 0;
            display: grid;
            gap: 0.8rem;
        }

        .category-item {
            width: 100%;
            border: 1px solid rgba(217, 198, 0, 0.14);
            border-radius: 18px;
            background: #fff;
            padding: 14px 15px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.75rem;
            cursor: pointer;
            transition: transform 0.22s ease, border-color 0.22s ease, box-shadow 0.22s ease, background 0.22s ease;
            font: inherit;
            color: #333;
        }

        .category-item:hover,
        .category-item:focus-visible {
            transform: translateY(-2px);
            border-color: rgba(217, 198, 0, 0.35);
            box-shadow: 0 12px 24px rgba(17, 17, 17, 0.08);
            outline: none;
        }

        .category-item.active {
            background: var(--gradient-primary);
            color: #fff;
            border-color: transparent;
            box-shadow: 0 16px 32px rgba(17, 17, 17, 0.18);
        }

        .category-name {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-size: 0.98rem;
            font-weight: 600;
        }

        .category-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--secondary-color);
            flex-shrink: 0;
        }

        .cat-count {
            min-width: 38px;
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(217, 198, 0, 0.16);
            color: var(--accent-color);
            font-size: 0.8rem;
            font-weight: 700;
            text-align: center;
        }

        .category-item.active .cat-count {
            background: rgba(255, 255, 255, 0.14);
            color: #fff;
        }

        .products-panel {
            min-width: 0;
        }

        .products-toolbar {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 16px;
            padding: 22px 24px;
            border-radius: var(--radius-xl);
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(217, 198, 0, 0.14);
            backdrop-filter: blur(10px);
            box-shadow: var(--shadow-md);
            margin-bottom: 22px;
        }

        .toolbar-copy h2 {
            margin: 0 0 0.35rem;
            font-size: 1.7rem;
            color: var(--primary-color);
        }

        .toolbar-copy p {
            margin: 0;
            color: #666;
            font-size: 0.95rem;
        }

        .results-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.6rem;
            border-radius: 999px;
            background: #fff;
            border: 1px solid rgba(217, 198, 0, 0.14);
            padding: 12px 15px;
            white-space: nowrap;
            color: #333;
            font-size: 0.93rem;
        }

        .results-pill strong {
            color: var(--primary-color);
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 20px;
        }

        .product-item {
            min-width: 0;
        }

        .product-card {
            height: 100%;
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid rgba(217, 198, 0, 0.12);
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 18px 40px rgba(17, 17, 17, 0.08);
            transition: transform 0.24s ease, box-shadow 0.24s ease, border-color 0.24s ease;
        }

        .product-card:hover {
            transform: translateY(-6px);
            border-color: rgba(217, 198, 0, 0.36);
            box-shadow: 0 24px 46px rgba(212, 136, 27, 0.16);
        }

        .product-image {
            position: relative;
            aspect-ratio: 4 / 4.2;
            overflow: hidden;
            background: linear-gradient(145deg, #f5f7fa, #ffffff);
        }

        .product-image::after {
            content: "";
            position: absolute;
            inset: auto 0 0;
            height: 42%;
            background: linear-gradient(180deg, transparent, rgba(21, 21, 21, 0.12));
            pointer-events: none;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.45s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-content {
            padding: 20px 20px 22px;
        }

        .product-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 14px;
        }

        .product-category {
            display: inline-flex;
            align-items: center;
            gap: 0.45rem;
            max-width: 75%;
            padding: 7px 11px;
            border-radius: 999px;
            background: rgba(217, 198, 0, 0.15);
            color: var(--accent-color);
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .product-category i {
            font-size: 0.76rem;
        }

        .product-code {
            color: rgba(26, 26, 26, 0.38);
            font-size: 0.8rem;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .product-title {
            margin: 0 0 0.8rem;
            font-size: 1.22rem;
            line-height: 1.2;
            color: var(--primary-color);
        }

        .product-footer {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 16px;
            margin-top: 1.1rem;
        }

        .price-wrap span {
            display: block;
            font-size: 0.76rem;
            letter-spacing: 0.11em;
            text-transform: uppercase;
            color: #666;
            margin-bottom: 0.3rem;
        }

        .product-price {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary-color);
            letter-spacing: -0.04em;
        }

        .product-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 10px 12px;
            border-radius: 999px;
            background: #fff;
            border: 1px solid rgba(217, 198, 0, 0.14);
            color: #333;
            font-size: 0.84rem;
            font-weight: 600;
            flex-shrink: 0;
        }

        .empty-state {
            display: none;
            padding: 36px 24px;
            margin-top: 20px;
            text-align: center;
            border-radius: var(--radius-xl);
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(217, 198, 0, 0.14);
            color: #666;
            box-shadow: var(--shadow-md);
        }

        .empty-state.visible {
            display: block;
        }

        .empty-state i {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 58px;
            height: 58px;
            margin-bottom: 14px;
            border-radius: 50%;
            background: var(--gold-soft);
            color: var(--accent-color);
            font-size: 1.2rem;
        }

        .empty-state h3 {
            margin-bottom: 0.5rem;
            color: var(--primary-color);
            font-size: 1.25rem;
        }

        @media (max-width: 1199px) {
            .catalog-layout {
                grid-template-columns: 250px minmax(0, 1fr);
            }

            .product-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 991px) {
            body {
                padding-top: 82px;
            }

            .catalog-shell {
                width: min(100% - 24px, 1240px);
            }

            .catalog-hero {
                padding: 28px 24px;
            }

            .catalog-layout {
                grid-template-columns: 1fr;
            }

            .category-sidebar {
                position: static;
            }

            .products-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .results-pill {
                justify-content: center;
            }

            .nav-link {
                margin: 0.2rem 0;
            }

            .navbar-collapse {
                padding-top: 14px;
                text-align: center;
            }

            .navbar-nav {
                align-items: center !important;
                width: 100%;
            }

            .nav-item {
                width: 100%;
            }

            .nav-link {
                display: inline-flex;
                justify-content: center;
                width: 100%;
            }

            .btn-nav-cta {
                margin: 0.65rem auto 0;
                text-align: center;
            }
        }

        @media (max-width: 767px) {
            body {
                padding-top: 78px;
            }

            .catalog-shell {
                width: calc(100% - 18px);
                margin-bottom: 36px;
            }

            .catalog-hero {
                border-radius: 24px;
                padding: 24px 18px;
                margin-bottom: 18px;
            }

            .catalog-hero p {
                font-size: 0.94rem;
                line-height: 1.65;
            }

            .hero-stats {
                display: grid;
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .hero-stat {
                min-width: 0;
            }

            .category-sidebar,
            .products-toolbar,
            .empty-state {
                border-radius: 22px;
            }

            .category-sidebar {
                padding: 18px;
            }

            .category-list {
                gap: 0.65rem;
            }

            .category-item {
                padding: 13px 14px;
                border-radius: 16px;
            }

            .product-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .product-card {
                border-radius: 20px;
            }

            .product-content {
                padding: 16px 16px 18px;
            }

            .product-meta {
                align-items: start;
            }

            .product-category {
                max-width: 100%;
                font-size: 0.74rem;
            }

            .product-title {
                font-size: 1.1rem;
            }

            .product-price {
                font-size: 1.32rem;
            }

            .product-footer {
                align-items: center;
            }
        }

        @media (max-width: 480px) {
            .hero-stats {
                grid-template-columns: 1fr;
            }

            .hero-stat {
                padding: 12px 14px;
                border-radius: 16px;
            }

            .toolbar-copy h2 {
                font-size: 1.35rem;
            }

            .toolbar-copy p,
            .results-pill,
            .sidebar-text {
                font-size: 0.9rem;
            }

            .category-name {
                font-size: 0.92rem;
            }

            .cat-count {
                min-width: 34px;
                padding-inline: 8px;
            }

            .product-badge {
                padding: 9px 10px;
                font-size: 0.78rem;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">Exclusive Doors</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain" aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarMain">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item"><a class="nav-link" href="index.php#home">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#experience">Our Story</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#about">Why Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#certificates">Certificates</a></li>
                    <li class="nav-item"><a class="nav-link" href="index.php#locations">Locations</a></li>
                    <li class="nav-item"><a class="nav-link btn-nav-cta" href="products.php">View Products</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="catalog-shell">
        <section class="catalog-hero">
            <div class="hero-eyebrow">Selected collection</div>
            <h1>Doors and flooring chosen to elevate everyday spaces.</h1>
            <p>Browse our current collection and filter by category to find the styles that fit your home. The layout is designed to feel lighter, cleaner, and much easier to use on phones.</p>
            <div class="hero-stats">
                <div class="hero-stat">
                    <strong><?php echo $total_all; ?></strong>
                    <span>Total Products</span>
                </div>
                <div class="hero-stat">
                    <strong><?php echo count($categories); ?></strong>
                    <span>Categories</span>
                </div>
            </div>
        </section>

        <section class="catalog-layout">
            <aside class="category-sidebar">
                <div class="sidebar-kicker">Refine your view</div>
                <h2>Shop by category</h2>
                <p class="sidebar-text">Tap a category to filter the catalog instantly. On mobile, these controls stay roomy and easy to press.</p>

                <ul class="category-list">
                    <li>
                        <button class="category-item active" type="button" data-category="all" data-label="All Products">
                            <span class="category-name">
                                <span class="category-dot"></span>
                                All Products
                            </span>
                            <span class="cat-count"><?php echo $total_all; ?></span>
                        </button>
                    </li>
                    <?php foreach ($categories as $category): ?>
                        <li>
                            <button class="category-item" type="button" data-category="cat-<?php echo $category['id']; ?>" data-label="<?php echo htmlspecialchars($category['category_name']); ?>">
                                <span class="category-name">
                                    <span class="category-dot"></span>
                                    <?php echo htmlspecialchars($category['category_name']); ?>
                                </span>
                                <span class="cat-count"><?php echo (int) $category['p_count']; ?></span>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </aside>

            <div class="products-panel">
                <div class="products-toolbar">
                    <div class="toolbar-copy">
                        <h2 id="resultsHeading">All Products</h2>
                        <p>Explore the collection with a calmer card layout and clearer hierarchy.</p>
                    </div>
                    <div class="results-pill">
                        <i class="fa-solid fa-grid-2"></i>
                        <span><strong id="visibleCount"><?php echo $total_all; ?></strong> items visible</span>
                    </div>
                </div>

                <div class="product-grid" id="productsGrid">
                    <?php foreach ($products as $index => $product): ?>
                        <?php
                        $image_path = strpos($product['image_url'], '../') === 0
                            ? $product['image_url']
                            : '../assets/uploads/' . basename($product['image_url']);
                        ?>
                        <article class="product-item" data-category="cat-<?php echo $product['category_id']; ?>">
                            <div class="product-card">
                                <div class="product-image">
                                    <img src="<?php echo htmlspecialchars($image_path); ?>" alt="<?php echo htmlspecialchars($product['product_name'] . ' in ' . $product['category_name']); ?>">
                                </div>
                                <div class="product-content">
                                    <div class="product-meta">
                                        <span class="product-category">
                                            <i class="fa-solid fa-tag"></i>
                                            <?php echo htmlspecialchars($product['category_name']); ?>
                                        </span>
                                        <span class="product-code">#<?php echo str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT); ?></span>
                                    </div>

                                    <h3 class="product-title"><?php echo htmlspecialchars($product['product_name']); ?></h3>

                                    <div class="product-footer">
                                        <div class="price-wrap">
                                            <span>Starting price</span>
                                            <div class="product-price">$<?php echo number_format((float) $product['price'], 2); ?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>

                <div class="empty-state" id="emptyState">
                    <i class="fa-solid fa-box-open"></i>
                    <h3>No products in this category yet</h3>
                    <p>Try another category to keep browsing the collection.</p>
                </div>
            </div>
        </section>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const categoryButtons = document.querySelectorAll('.category-item');
            const productItems = document.querySelectorAll('.product-item');
            const visibleCount = document.getElementById('visibleCount');
            const resultsHeading = document.getElementById('resultsHeading');
            const emptyState = document.getElementById('emptyState');
            const navbarCollapse = document.getElementById('navbarMain');
            const navLinks = document.querySelectorAll('.navbar-nav .nav-link');

            function updateResults(selectedCategory, selectedLabel) {
                let count = 0;

                productItems.forEach((item) => {
                    const matches = selectedCategory === 'all' || item.dataset.category === selectedCategory;
                    item.style.display = matches ? '' : 'none';

                    if (matches) {
                        count += 1;
                    }
                });

                visibleCount.textContent = count;
                resultsHeading.textContent = selectedLabel;
                emptyState.classList.toggle('visible', count === 0);
            }

            categoryButtons.forEach((button) => {
                button.addEventListener('click', function () {
                    categoryButtons.forEach((item) => item.classList.remove('active'));
                    this.classList.add('active');
                    updateResults(this.dataset.category, this.dataset.label);
                });
            });

            navLinks.forEach((link) => {
                link.addEventListener('click', function () {
                    if (navbarCollapse.classList.contains('show')) {
                        const collapseInstance = bootstrap.Collapse.getInstance(navbarCollapse);
                        if (collapseInstance) {
                            collapseInstance.hide();
                        }
                    }
                });
            });

            updateResults('all', 'All Products');
        });
    </script>
</body>
</html>
