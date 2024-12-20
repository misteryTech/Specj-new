<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>

<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard Nav -->
        <li class="nav-item <?= ($current_page == 'dashboard-page.php' || $current_page == 'dashboard-page.php') ? 'active' : '' ?>">
            <a class="nav-link" href="dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <!-- User Nav -->
        <li class="nav-item <?= ($current_page == 'user-registration.php' || $current_page == 'user-list.php') ? 'active' : '' ?>">
            <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="user-nav" class="nav-content collapse <?= ($current_page == 'user-registration.php' || $current_page == 'user-list.php') ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="user-list.php" class="<?= $current_page == 'user-list.php' ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>User List</span>
                    </a>
                </li>
                <li>
                    <a href="tables-data.html" class="<?= $current_page == 'tables-data.html' ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>Data Tables</span>
                    </a>
                </li>
            </ul>
        </li><!-- End User Nav -->


        
        <!-- Dashboard Nav -->
        <li class="nav-item <?= $current_page == 'services.php' ? 'active' : '' ?>">
            <a class="nav-link" href="services.php">
                <i class="bi bi-book"></i>
                <span>Services</span>
            </a>
        </li><!-- End Dashboard Nav -->


        <!-- Product Nav -->
        <li class="nav-item <?= ($current_page == 'product-registration.php' || $current_page == 'product-list.php') ? 'active' : '' ?>">
            <a class="nav-link collapsed" data-bs-target="#product-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-box"></i><span>Product</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="product-nav" class="nav-content collapse <?= ($current_page == 'product-registration.php' || $current_page == 'product-list.php') ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="product-registration.php" class="<?= $current_page == 'product-registration.php' ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>Register Product</span>
                    </a>
                </li>
                <li>
                    <a href="product-list.php" class="<?= $current_page == 'product-list.php' ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>List of Product</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Product Nav -->

    </ul>
</aside><!-- End Sidebar -->
