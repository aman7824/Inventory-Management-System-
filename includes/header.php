<?php 
require_once __DIR__ . '/auth.php'; 
requireLogin();
?>
<!DOCTYPE html>
<html lang="en" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InventoryX - Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script>
        // Theme initialization in head to prevent flickering
        (function() {
            const theme = localStorage.getItem('theme') || 'dark';
            document.documentElement.setAttribute('data-theme', theme);
        })();
    </script>
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    
    <div class="sidebar" id="sidebar">
        <div class="logo">
            <i class="fas fa-boxes-stacked"></i>
            <span>InventoryX</span>
        </div>
        <ul class="nav-links">
            <li><a href="index.php" id="nav-dashboard"><i class="fas fa-chart-line"></i> Dashboard</a></li>
            <li><a href="customers.php" id="nav-customers"><i class="fas fa-users"></i> Customers</a></li>
            <li><a href="vendors.php" id="nav-vendors"><i class="fas fa-truck-field"></i> Vendors</a></li>
            <li><a href="products.php" id="nav-products"><i class="fas fa-box"></i> Products</a></li>
            <li><a href="purchases.php" id="nav-purchases"><i class="fas fa-cart-shopping"></i> Purchases</a></li>
            <li><a href="sales.php" id="nav-sales"><i class="fas fa-cash-register"></i> Sales</a></li>
            <li><a href="reports.php" id="nav-reports"><i class="fas fa-file-invoice-dollar"></i> Reports</a></li>
            <?php if (isAdmin()): ?>
            <li><a href="users.php" id="nav-users"><i class="fas fa-user-gear"></i> Users</a></li>
            <?php endif; ?>
        </ul>
        <div class="nav-footer" style="color: var(--text-muted); font-size: 0.75rem;">
            &copy; 2026 InventoryX
        </div>
    </div>

    <div class="main-content">
        <div class="header-top">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <button class="icon-btn sidebar-toggle" id="menuToggle" title="Toggle Menu">
                    <i class="fas fa-bars"></i>
                </button>
                <h1 id="page-title">Dashboard</h1>
            </div>
            
            <div class="header-actions">
                <button class="icon-btn" id="themeToggle" title="Toggle Theme">
                    <i class="fas fa-moon"></i>
                </button>

                <div class="user-info">
                    <div style="text-align: right; display: none; display: md-block;" class="desktop-only text-right">
                        <div style="font-weight: 600; font-size: 0.875rem;"><?php echo $_SESSION['full_name'] ?? $_SESSION['username']; ?></div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);"><?php echo ucfirst($_SESSION['role']); ?></div>
                    </div>
                    <div class="user-avatar" style="position: relative; cursor: pointer;">
                        <i class="fas fa-circle-user fa-2x"></i>
                        <div class="user-dropdown" style="display: none; position: absolute; right: 0; top: 100%; background: var(--bg-card); border: 1px solid var(--border); border-radius: 0.5rem; padding: 0.5rem; width: 150px; z-index: 100;">
                            <div class="mobile-only" style="padding: 0.5rem; border-bottom: 1px solid var(--border); margin-bottom: 0.5rem;">
                                <div style="font-weight: 600; font-size: 0.875rem;"><?php echo $_SESSION['username']; ?></div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);"><?php echo ucfirst($_SESSION['role']); ?></div>
                            </div>
                            <a href="logout.php" style="color: var(--danger); text-decoration: none; display: flex; align-items: center; gap: 0.5rem; padding: 0.5rem; font-size: 0.875rem;">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Sidebar Dropdown and Overlay
            document.querySelector('.user-avatar').addEventListener('click', function(e) {
                const dropdown = this.querySelector('.user-dropdown');
                dropdown.style.display = dropdown.style.display === 'none' ? 'block' : 'none';
                e.stopPropagation();
            });
            window.addEventListener('click', function() {
                const dropdown = document.querySelector('.user-dropdown');
                if(dropdown) dropdown.style.display = 'none';
            });
        </script>
        
        <style>
            @media (max-width: 768px) {
                .desktop-only { display: none !important; }
            }
            @media (min-width: 769px) {
                .mobile-only { display: none !important; }
            }
        </style>
