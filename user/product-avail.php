<?php
include("../layout/header.php");
?>

<body>

<?php
include("../layout/top-nav.php");
include("side-bar.php");
?>

<main id="main" class="main">

<div class="pagetitle">
  <h1>Products</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">List of Products</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="page-section">
    <div class="container glass-container">
        <div class="row">

            <!-- Search Products -->
            <div class="col-md-12 mb-4">
                <h1 class="fancy-title">Explore Our Products</h1>
                <label for="productSearch" class="form-label text-white">Search Products:</label>
                <input type="text" id="productSearch" class="form-control" placeholder="Search for products..." onkeyup="searchProduct()">
            </div>

            <!-- Product List Section -->
            <div class="col-md-12">
                <div class="row" id="productList">
                    <?php
                    include("connection.php");

                    // Fetch registered products
                    $sql = "SELECT parts_name, price, category, image FROM parts_registration";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo '<div class="col-md-4 mb-3 product-item" data-name="' . htmlspecialchars($row['parts_name']) . '">';
                            echo '<div class="card" style="width: 100%;">';
                            echo '<img class="card-img-top" src="../admin/process/' . htmlspecialchars($row['image']) . '" alt="Product Image" style="width: 100%; height: 200px; object-fit: cover;">';
                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . htmlspecialchars($row['parts_name']) . '</h5>';
                            echo '<p class="card-text">Category: ' . htmlspecialchars($row['category']) . '</p>';
                            echo '<p class="card-text">Price: ₱ ' . htmlspecialchars($row['price']) . '</p>';
                            echo '</div>';
                            echo '</div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No products found.</p>';
                    }

                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>

</main><!-- End #main -->

<?php
include("../layout/footer.php");
?>

<script>
    // JavaScript function to search products by name
    function searchProduct() {
        var searchQuery = document.getElementById("productSearch").value.toLowerCase();
        var productItems = document.querySelectorAll(".product-item");

        productItems.forEach(function(item) {
            var productName = item.getAttribute("data-name").toLowerCase();

            if (productName.includes(searchQuery)) {
                item.style.display = "block";
            } else {
                item.style.display = "none";
            }
        });
    }
</script>
