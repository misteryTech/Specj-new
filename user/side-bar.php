<?php




$current_page = basename($_SERVER['PHP_SELF']);

// Query to count the number of transactions with status 'onprocess'
$query = "SELECT COUNT(*) AS onprocess_count FROM transactions WHERE status = 'onprocess'";
$result = $conn->query($query);

// Check if the query executed successfully
if ($result && $row = $result->fetch_assoc()) {
    $onprocessCount = $row['onprocess_count'];
} else {
    $onprocessCount = 0; // In case of an error, set count to 0
}



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
        <li class="nav-item <?= ($current_page == 'transaction-page.php' || $current_page == 'transaction-page.php') ? 'active' : '' ?>">
            <a class="nav-link" href="transaction.php">
                <i class="bi bi-tools"></i>
                <span>Transactions</span>
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
