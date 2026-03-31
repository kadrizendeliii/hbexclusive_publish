<?php
if (!isset($page_title)) {
    $page_title = "Dashboard";
}

if (!isset($page_subtitle)) {
    $page_subtitle = "Manage your content";
}
?>

<header class="top-header">
    <div class="admin-page-shell w-100 d-flex align-items-center justify-content-between gap-3 px-3 px-md-4">
        <div class="d-flex align-items-center gap-3 flex-grow-1" style="min-width: 0;">
            <button
                class="menu-toggle d-lg-none"
                id="menuToggle"
                type="button"
                aria-controls="sidebar"
                aria-expanded="false"
                style="background: none; border: none; color: var(--primary-color); font-size: 1.2rem; cursor: pointer; padding: 0; width: 44px; height: 44px; display: inline-flex; align-items: center; justify-content: center; flex-shrink: 0;"
            >
                <i class="fas fa-bars"></i>
            </button>

            <div class="header-copy" style="min-width: 0;">
                <div class="small text-uppercase fw-bold" style="letter-spacing: 0.12em; color: var(--accent-color);">Admin Panel</div>
                <h4 class="fw-bold mb-0" style="font-size: 1.15rem; color: var(--primary-color); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo htmlspecialchars($page_title); ?></h4>
                <p class="mb-0 d-none d-sm-block" style="font-size: 0.83rem; color: var(--muted-text); overflow: hidden; text-overflow: ellipsis; white-space: nowrap;"><?php echo htmlspecialchars($page_subtitle); ?></p>
            </div>
        </div>

        <div class="header-right d-flex align-items-center gap-2">
            <a
                href="../public/index.php"
                class="btn btn-sm"
                style="background: var(--gradient-primary); color: #1a1a1a; border: none; padding: 9px 14px; border-radius: 12px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;"
            >
                <i class="fas fa-home"></i>
                <span class="d-none d-md-inline">Website</span>
            </a>
        </div>
    </div>
</header>

