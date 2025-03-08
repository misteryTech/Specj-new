<?php
include("../layout/header.php");
?>

<body>

<?php
include("../layout/top-nav.php");
include("side-bar.php");


// Check if a transaction ID is provided
if (!isset($_GET['serviceId'])) {
    echo "<script>alert('Transaction ID is missing.');</script>";
    echo "<script>window.location.href='transactions.php';</script>";
    exit();
}

$serviceId = intval($_GET['serviceId']);
?>

<main id="main" class="main">

<div class="pagetitle">
  <h1>Services ID: <?= $serviceId ?></h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item active">Release Products</li>
    </ol>
    
    <!-- Cart Button -->
    <div class="text-end mt-3">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cartModal">
            <i class="bi bi-cart"></i> View Cart (<span id="cartCount">0</span> items)
        </button>
    </div>
  </nav>
</div><!-- End Page Title -->

<section class="section">
 <!-- Multi Columns Form -->
<div class="row g-3">
    <?php
    // Fetch categories and their parts with stock info and images from the database
    $categorySql = "SELECT DISTINCT category FROM parts_registration ORDER BY category ASC";
    $categories = $conn->query($categorySql);
    ?>

    <!-- Tab Pills Navigation -->
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <?php
        $isActive = true;
        if ($categories->num_rows > 0) {
            while ($categoryRow = $categories->fetch_assoc()) {
                $category = $categoryRow['category'];
                echo '<li class="nav-item" role="presentation">
                    <button class="nav-link ' . ($isActive ? 'active' : '') . '" id="pills-' . $category . '-tab" data-bs-toggle="pill" data-bs-target="#pills-' . $category . '" type="button" role="tab" aria-controls="pills-' . $category . '" aria-selected="' . ($isActive ? 'true' : 'false') . '">' . ucfirst($category) . '</button>
                </li>';
                $isActive = false;
            }
        }
        ?>
    </ul>

    <!-- Tab Pills Content -->
    <div class="tab-content" id="pills-tabContent">
        <?php
        $isActive = true;
        $categories->data_seek(0); // Reset result pointer
        while ($categoryRow = $categories->fetch_assoc()) {
            $category = $categoryRow['category'];
            echo '<div class="tab-pane fade ' . ($isActive ? 'show active' : '') . '" id="pills-' . $category . '" role="tabpanel" aria-labelledby="pills-' . $category . '-tab">';
            $isActive = false;

            // Fetch parts for the current category, including stock info and image
            $partsSql = "SELECT id, parts_name, price, quantity_stock, image FROM parts_registration WHERE category = ?";
            $stmt = $conn->prepare($partsSql);
            $stmt->bind_param("s", $category);
            $stmt->execute();
            $partsResult = $stmt->get_result();

            echo '<div class="list-group">';
            if ($partsResult->num_rows > 0) {
                while ($row = $partsResult->fetch_assoc()) {
                    $imagePath = !empty($row['image']) ? "../admin/process/{$row['image']}" : 'images/default.jpg';
                    echo '<button type="button" class="list-group-item list-group-item-action" data-id="' . $row['id'] . '" data-price="' . $row['price'] . '" data-stock="' . $row['quantity_stock'] . '" onclick="selectService(this)">
                        <div class="d-flex align-items-center">
                            <img src="' . $imagePath . '" alt="' . $row['parts_name'] . '" class="img-thumbnail" style="width: 50px; height: 50px; margin-right: 10px;">
                            <div>' . $row['parts_name'] . ' - ₱ ' . number_format($row['price'], 2) . ' (Stock: ' . $row['quantity_stock'] . ')</div>
                        </div>
                    </button>';
                }
            } else {
                echo '<div class="text-muted">No parts available in this category.</div>';
            }
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Your Cart</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="selectedProduct" class="list-group"></ul>
                    <div class="text-end mt-3">
                        <h5>Total: ₱ <span id="totalPrice">0</span></h5>
                    </div>
                </div>
                <div class="modal-footer">
                    <form id="serviceForm" action="process/release-service-product.php" method="POST">
                        
                        <input type="hidden" id="selectedproduct" name="selectedproduct">
                        <input type="hidden" id="services_id" name="services_id" value="<?= $serviceId ?>">
                        <input type="hidden" id="product_transaction" name="product_transaction" value="Product">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </form>
                </div>
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
// Function to handle service selection
function selectService(button) {
    const productId = button.getAttribute('data-id');
    const serviceName = button.textContent.trim();
    const price = parseFloat(button.getAttribute('data-price'));
    const stock = parseInt(button.getAttribute('data-stock'));
    const image = button.querySelector('img').src;

    const selectedProduct = document.getElementById('selectedProduct');
    const cartCount = document.getElementById('cartCount');

    // Check if the service is already selected
    let existingItem = [...selectedProduct.children].find(item => item.dataset.productId === productId);
    if (existingItem) {
        let quantityInput = existingItem.querySelector('.quantityInput');
        let newQuantity = parseInt(quantityInput.value) + 1;

        if (newQuantity > stock) {
            alert("Not enough stock available!");
            return;
        }

        quantityInput.value = newQuantity;
        existingItem.querySelector('.serviceTotal').textContent = '₱ ' + (newQuantity * price).toLocaleString('en-PH', { minimumFractionDigits: 2 });
        updateTotal();
        updateCartCount();
        return;
    }

    // Create a list item for the selected service
    const listItem = document.createElement('li');
    listItem.className = "list-group-item d-flex justify-content-between align-items-center";
    listItem.dataset.productId = productId;
    listItem.dataset.price = price;
    listItem.dataset.stock = stock;
    listItem.innerHTML = `
        <div class="d-flex align-items-center">
            <img src="${image}" alt="${serviceName}" class="img-thumbnail" style="width: 50px; height: 50px; margin-right: 10px;">
            <div>${serviceName} - ₱ <span class="servicePrice">${price.toLocaleString('en-PH', { minimumFractionDigits: 2 })}</span>
            </div>
            
            <label>Quantity</label>

            <input type="number" class="form-control form-control-sm quantityInput" value="1" min="1" max="${stock}" style="width: 60px;" onchange="updateItemTotal(this)">
            <span class="serviceTotal">₱ ${price.toLocaleString('en-PH', { minimumFractionDigits: 2 })}</span>
            <button type="button" class="btn btn-sm btn-danger removeService">Remove</button>
        </div>
    `;
    selectedProduct.appendChild(listItem);

    updateTotal();
    updateCartCount();
}

// Update total price
function updateTotal() {
    let totalPrice = 0;
    const selectedproduct = [];

    // Loop through each selected product and calculate the total price
    document.querySelectorAll("#selectedProduct li").forEach(item => {
        const productId = item.dataset.productId;
        const quantity = parseInt(item.querySelector('.quantityInput').value);
        const price = parseFloat(item.dataset.price);

        // Calculate total price for this item
        totalPrice += quantity * price;

        // Add this item to the selected product list
        selectedproduct.push({ productId: productId, quantity: quantity });
    });

    // Update the total price in the modal
    document.getElementById("totalPrice").textContent = totalPrice.toLocaleString('en-PH', { minimumFractionDigits: 2 });

    // Save the selected products in the hidden input field for form submission
    document.getElementById("selectedproduct").value = JSON.stringify(selectedproduct);
}




// Update cart item count
function updateCartCount() {
    const cartCount = document.getElementById('cartCount');
    const totalItems = document.querySelectorAll("#selectedProduct li").length;
    cartCount.textContent = totalItems;
}

// Update individual item total when quantity changes
function updateItemTotal(input) {
    const listItem = input.closest('li');
    const quantity = parseInt(input.value);
    const price = parseFloat(listItem.dataset.price);
    const total = quantity * price;

    if (quantity > parseInt(listItem.dataset.stock)) {
        alert("Not enough stock available!");
        input.value = listItem.querySelector('.quantityInput').value;
        return;
    }

    listItem.querySelector('.serviceTotal').textContent = '₱ ' + total.toLocaleString('en-PH', { minimumFractionDigits: 2 });
    updateTotal();
}

// Remove selected service
document.getElementById('selectedProduct').addEventListener('click', function(e) {
    if (e.target.classList.contains('removeService')) {
        e.target.closest('li').remove();
        updateTotal();
        updateCartCount();
    }
});
</script>
