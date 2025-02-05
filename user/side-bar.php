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

               
        <!-- Dashboard Nav -->
        <li class="nav-item <?= $current_page == 'services-list.php' ? 'active' : '' ?>">
            <a class="nav-link" href="services-list.php">
                <i class="bi bi-book"></i>
                <span>Services</span>
            </a>
        </li><!-- End Dashboard Nav -->

  
          <!-- <li class="nav-item <?= $current_page == 'products-page.php' ? 'active' : '' ?>">
            <a class="nav-link" href="products-list.php">
                <i class="bi bi-gear"></i>
                <span>Products</span>
            </a>
        </li> -->

          <!-- Dashboard Nav -->
          <li class="nav-item <?= $current_page == 'product-avail.php' ? 'active' : '' ?>">
            <a class="nav-link" href="product-avail.php">
                <i class="bi bi-gear"></i>
                <span>List of Products</span>
            </a>
        </li><!-- End Dashboard Nav -->




    </ul>
</aside><!-- End Sidebar -->
