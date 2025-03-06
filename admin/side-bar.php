<?php
$current_page = basename($_SERVER['PHP_SELF']);

include("connection.php");

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
        <li class="nav-item <?= ($current_page == 'dashboard.php') ? 'active' : '' ?>">
            <a class="nav-link" href="dashboard.php">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <!-- User Nav -->
        <li class="nav-item <?= in_array($current_page, ['user-registration.php', 'user-list.php', 'user-archived.php']) ? 'active' : '' ?>">
            <a class="nav-link collapsed" data-bs-target="#user-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-person"></i><span>User</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="user-nav" class="nav-content collapse <?= in_array($current_page, ['user-registration.php', 'user-list.php', 'user-archived.php', 'user-restore.php']) ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="user-list.php" class="<?= $current_page == 'user-list.php' ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>User List</span>
                    </a>
                </li>
                <li>
                    <a href="user-archived.php" class="<?= $current_page == 'user-archived.php' ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>Archive User</span>
                    </a>
                </li>

                <li>
                    <a href="user-restore.php" class="<?= $current_page == 'user-restore.php' ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>Restore User</span>
                    </a>
                </li>


            </ul>
        </li><!-- End User Nav -->
        
        <!-- Walkin Nav -->
        <li class="nav-item <?= in_array($current_page, ['walkin-service.php', 'walkin-product.php']) ? 'active' : '' ?>">
            <a class="nav-link collapsed" data-bs-target="#walkin-nav" data-bs-toggle="collapse" href="#">
                <i class="ri-store-2-line"></i><span>Walkin</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="walkin-nav" class="nav-content collapse <?= in_array($current_page, ['walkin-service.php', 'walkin-product.php']) ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="walkin-service.php" class="<?= $current_page == 'walkin-service.php' ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>Services</span>
                    </a>
                </li>
                <li>
                    <a href="walkin-product.php" class="<?= $current_page == 'walkin-product.php' ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>Product</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Walkin Nav -->

        <!-- Services Nav -->
        <li class="nav-item <?= ($current_page == 'services.php') ? 'active' : '' ?>">
            <a class="nav-link" href="services.php">
                <i class="bi bi-book"></i>
                <span>Services</span>
            </a>
        </li><!-- End Services Nav -->

        <!-- Product Nav -->
        <li class="nav-item <?= in_array($current_page, ['product-registration.php', 'product-list.php', 'archive-product.php']) ? 'active' : '' ?>">
            <a class="nav-link collapsed" data-bs-target="#product-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-box"></i><span>Product</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="product-nav" class="nav-content collapse <?= in_array($current_page, ['product-registration.php', 'product-list.php', 'archive-product.php']) ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="product-registration.php" class="<?= $current_page == 'product-registration.php' ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>Register Product</span>
                    </a>
                </li>
                <li>
                    <a href="product-list.php" class="<?= $current_page == 'product-list.php' ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>List of Products</span>
                    </a>
                </li>
                <li>
                    <a href="archive-product.php" class="<?= $current_page == 'archive-product.php' ? 'active' : '' ?>">
                        <i class="bi bi-circle"></i><span>Archive Products</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Product Nav -->

<!-- Transaction Nav -->
<li class="nav-item <?= ($current_page == 'transaction-list.php') ? 'active' : '' ?>">
    <a class="nav-link collapsed" data-bs-target="#transaction-nav" data-bs-toggle="collapse" href="#">
        <i class="bi bi-clipboard-data"></i><span>Transaction</span>
        <i class="bi bi-chevron-down ms-auto"></i>
        <?php if ($onprocessCount > 0): ?>
            <span class="badge bg-danger"><?= $onprocessCount ?></span> <!-- Show count badge if greater than 0 -->
        <?php endif; ?>
    </a>
    <ul id="transaction-nav" class="nav-content collapse <?= ($current_page == 'transaction-list.php') ? 'show' : '' ?>" data-bs-parent="#sidebar-nav">
        <li>
            <a href="transaction-list.php" class="<?= $current_page == 'transaction-list.php' ? 'active' : '' ?>">
                <i class="bi bi-circle"></i><span>List of Transactions</span>
            </a>
        </li>
    </ul>
</li><!-- End Transaction Nav -->
    </ul>
</aside><!-- End Sidebar -->
