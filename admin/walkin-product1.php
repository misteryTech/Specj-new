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
    $categorySql = "SELECT DISTINCT category FROM parts_registrations WHERE archive='No' ORDER BY category ASC";
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
            $partsSql = "SELECT id, parts_name,  batch_number, image FROM parts_registrations WHERE category = ?";
            $stmt = $conn->prepare($partsSql);
            $stmt->bind_param("s", $category);
            $stmt->execute();
            $partsResult = $stmt->get_result();

            echo '<div class="list-group">';
            if ($partsResult->num_rows > 0) {
                echo '<div class="row row-cols-1 row-cols-md-3 g-3">'; // Responsive card grid
                while ($row = $partsResult->fetch_assoc()) {
                    $imagePath = !empty($row['image']) ? "../admin/process/{$row['image']}" : 'images/default.jpg';
            
                    echo '<div class="col">
                    <div class="card shadow-sm">
                        <img src="' . htmlspecialchars($imagePath) . '" class="card-img-top" alt="' . htmlspecialchars($row['parts_name']) . '" style="height: 150px; object-fit: cover;">
                        <div class="card-body text-center">
                            <h5 class="card-title">' . htmlspecialchars($row['parts_name']) . '</h5>
                            <button type="button" class="btn btn-primary add-to-cart" data-id="' . htmlspecialchars($row['batch_number']) . '" onclick="addToCart(this)">Add to Cart</button>
                        </div>
                    </div>
                  </div>';
            
                }
                echo '</div>'; // Close row
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
        

         
            <form id="purchaseForm" action="process/transaction-product.php" method="POST">
    <!-- Customer Details -->
    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="mobile" class="form-label">Mobile No.</label>
            <input type="text" class="form-control" id="mobile" name="mobile" required>
        </div>
        <div class="col-md-6 mb-3">
            <label for="schedule" class="form-label">Date Purchase</label>
            <input type="date" class="form-control" id="schedule" name="schedule" required>
        </div>
    </div>

    <!-- Selected Products -->
    <ul id="selectedProduct" class="list-group mb-3"></ul>
    <div id="cart-items" class="cart-list"></div>

    <!-- Total Price -->
    <div class="text-end">
        <h5>Total: ₱ <span id="totalPrice">0</span></h5>
    </div>

    <!-- Hidden inputs -->
    <input type="hidden" id="selectedproduct" name="selectedproduct">
    <input type="hidden" id="product_transaction" name="product_transaction" value="Product">
    <input type="hidden" id="total_price" name="total_price">
    <!-- Submit Button -->
    <button type="submit" class="btn btn-success">Proceed to Payment</button>
</form>



            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
   let cart = [];

function addToCart(button) {
    let card = button.closest(".card");
    let productId = button.getAttribute("data-id");
    let productName = card.querySelector(".card-title").innerText;
    let productImage = card.querySelector(".card-img-top").src;

    // console.log("Fetching stock for:", productId);

    fetch(`verification/fetch_stock.php?product_id=${productId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
    .then(data => {
    if (Array.isArray(data) && data.length > 0) {
        let existingProduct = cart.find(item => item.id === productId);

        // Sort stock batches in ascending order (lowest stock first)
        data.sort((a, b) => a.stock - b.stock);

        let stockByUnit = {};
        let batchGroup = data[0].batch_group || "N/A"; // Store batch_group from the first item

        data.forEach(stockItem => {
            let unit = stockItem.unit || "N/A";
            let price = parseFloat(stockItem.price) || 0;
            let stock = parseInt(stockItem.stock) || 0;
            let batchGroup = stockItem.batch_group || "Unknown"; // Ensure batch_group is assigned correctly

            if (!stockByUnit[unit]) {
                stockByUnit[unit] = [];
            }
            stockByUnit[unit].push({
                batch: stockItem.batch, 
                batch_group: batchGroup, // Store batch_group correctly
                stock: stock, 
                price: price 
            });
        });

        if (!existingProduct) {
            cart.push({
                id: productId,
                name: productName,
                image: productImage,
                batch_group: batchGroup, // Store batch_group here
                stocks: stockByUnit, // Store stock per unit
                quantities: {} // Initialize empty quantities
            });
            updateCartUI();
        } else {
            alert("This product is already in your cart!");
        }
    } else {
        alert("Sorry, this item is out of stock!");
    }
})
.catch(error => console.error("Error fetching stock:", error));

}



function updateCartUI() {
    let cartContainer = document.getElementById("cart-items");
    let cartCount = document.getElementById("cartCount");
    let totalPriceElement = document.getElementById("totalPrice");
    
    if (!cartContainer || !cartCount || !totalPriceElement) {
        console.error("Error: Cart elements not found in the DOM.");
        return;
    }

    cartContainer.innerHTML = "";
    cartCount.innerText = cart.length;

    if (cart.length === 0) {
        cartContainer.innerHTML = "<p class='text-muted text-center'>Your cart is empty.</p>";
        totalPriceElement.innerText = "0.00";
        return;
    }

    let total = 0;
    cart.forEach(item => {
    let itemElement = document.createElement("div");
    itemElement.classList.add("cart-item", "d-flex", "align-items-center", "border-bottom", "py-2");
    itemElement.setAttribute("data-id", item.id); // Ensure product ID is set

    let stockHtml = "";
    let itemSubtotal = 0;

    Object.entries(item.stocks).forEach(([unit, batches]) => {
        stockHtml += `<p class="mb-1"><strong>${unit}:</strong></p>`;

        
        batches.forEach((batch, index) => {
    let batchId = `${item.id}-${unit}-${index}`;
    let maxStock = batch.stock;
    let selectedQuantity = item.quantities[batchId] || 0;
    let subtotal = selectedQuantity * batch.price;
    itemSubtotal += subtotal;

    stockHtml += `
<div class="d-flex align-items-center mb-2 cart-batch" 
     data-product-id="${item.id}"  
     data-batch-group="${batch.batch_group}" 
     data-price="${batch.price}" 
     data-quantity="${selectedQuantity}" 
     data-subtotal="${subtotal}" 
     data-stock="${batch.stock}"> <!-- ✅ Ensure stock is included -->

    <span class="me-2 text-muted">Batch Group: <strong>${batch.batch_group}</strong></span>
    <span class="me-2 text-muted">${batch.stock} in stock @ ₱${batch.price.toFixed(2)}</span>

    <input type="number" id="${batchId}" class="form-control form-control-sm text-center me-2" 
           value="${selectedQuantity}" min="0" max="${batch.stock}" 
           data-product-id="${item.id}" data-unit="${unit}" data-batch-index="${index}" 
           oninput="updateQuantity(this)" style="width: 60px;">

    <span class="subtotal ms-2 fw-bold">₱${subtotal.toFixed(2)}</span>
</div>

    `;
});

    });

    total += itemSubtotal;

    itemElement.innerHTML = `
        <img src="${item.image}" alt="${item.name}" class="cart-img me-3" 
             style="width: 60px; height: 60px; object-fit: cover; border-radius: 5px;">
        <div class="cart-details flex-grow-1">
            <h5 class="mb-1">${item.name}</h5>
            ${stockHtml}
            <p class="fw-bold text-end">Total: ₱<span class="item-total">${itemSubtotal.toFixed(2)}</span></p>
        </div>
        <button class="btn btn-danger btn-sm ms-3" onclick="removeFromCart('${item.id}')">
            <i class="bi bi-trash"></i>
        </button>
    `;

    cartContainer.appendChild(itemElement);
});

    totalPriceElement.innerText = total.toFixed(2);
}



function updateQuantity(input) {
    let productId = input.getAttribute("data-product-id");
    let unit = input.getAttribute("data-unit");
    let batchIndex = parseInt(input.getAttribute("data-batch-index"));
    let newQuantity = parseInt(input.value) || 0;

    let cartItem = cart.find(item => item.id === productId);
    if (!cartItem) return;

    let batch = cartItem.stocks[unit][batchIndex];
    if (!batch) return;

    if (newQuantity > batch.stock) {
        input.value = batch.stock; // Prevent over-purchasing
        newQuantity = batch.stock;
    }

    cartItem.quantities[`${productId}-${unit}-${batchIndex}`] = newQuantity;
    updateCartUI();
}

function removeFromCart(productId) {
    cart = cart.filter(item => item.id !== productId);
    updateCartUI();
}




document.getElementById('purchaseForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent default submission

    let selectedProducts = [];
    let totalPrice = 0;
    let batchesToRemove = [];

    document.querySelectorAll('.cart-batch').forEach(batch => {
        let productId = batch.getAttribute('data-product-id');
        let batchGroup = batch.getAttribute('data-batch-group');
        let quantity = parseInt(batch.getAttribute('data-quantity')) || 0;
        let unitPrice = parseFloat(batch.getAttribute('data-price')) || 0;
        let subtotal = parseFloat(batch.getAttribute('data-subtotal')) || 0;
        let stockAvailable = parseInt(batch.getAttribute('data-stock')) || 0;

        if (stockAvailable === 0) {
            alert(`Stock is unavailable for batch ${batchGroup}. It will be removed.`);
            batchesToRemove.push(batch); // Mark for removal
            return;
        }

        totalPrice += subtotal;

        if (!productId) {
            console.error("❌ Missing product_id for batch:", batch);
            return;
        }

        let existingProduct = selectedProducts.find(p => p.id === productId);
        if (!existingProduct) {
            existingProduct = { id: productId, batches: [] };
            selectedProducts.push(existingProduct);
        }

        existingProduct.batches.push({
            batch_group: batchGroup,
            quantity: quantity,
            price: unitPrice,
            subtotal: subtotal,
        });
    });

    // Remove out-of-stock items
    batchesToRemove.forEach(batch => batch.remove());

    // Check if cart is empty
    if (selectedProducts.length === 0) {
        alert("All selected items are out of stock. Please add available items to proceed.");
        return;
    }

    console.log("🛒 Selected Products:", selectedProducts); // Debug output

    // Set values in form
    document.getElementById('selectedproduct').value = JSON.stringify(selectedProducts);
    document.getElementById('total_price').value = totalPrice.toFixed(2);

    this.submit();
});






</script>