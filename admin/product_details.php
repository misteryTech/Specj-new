<?php
include("../layout/header.php");
include("connection.php"); // Ensure database connection is included

// Get the slug from the URL
if (isset($_GET['batch_number'])) {
    $batch_number = $_GET['batch_number'];

    // Fetch product details using the slug
    $sql = "SELECT * FROM parts_registrations WHERE batch_number = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $batch_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();

        $inventory_id = $product['batch_number'];
    } else {
        $error = "Product not found!";
    }
} else {
    $error = "No product selected!";
}
?>

<style>
    .card-title {
        font-size: 35px;
    }
</style>

<body>

<?php
include("../layout/top-nav.php");
include("side-bar.php");
?>

<main id="main" class="main">
    <section class="section">
        <div class="container mt-5">
            <div class="row">
                <?php if (isset($error)) { ?>
                    <div class="col-12">
                        <div class="alert alert-danger text-center"><?= $error ?></div>
                    </div>
                <?php } else { ?>
                    <div class="col-md-12">
                        <div class="card p-4 shadow-lg border-0">
                            <div class="row">
                                <!-- Product Image -->
                                <div class="col-md-5 text-center">
                                    <img src="process/<?= !empty($product['image']) ? $product['image'] : 'images/default-placeholder.png' ?>" 
                                         class="img-fluid rounded shadow" 
                                         alt="Product Image" 
                                         style="max-height: 400px; object-fit: cover;">
                                </div>

                                <!-- Product Details -->
                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h1 class="card-title text-primary fw-bold display-4">
                                            <?= ucwords(strtolower(htmlspecialchars($product['parts_name']))) ?>
                                        </h1>
                                        <label for="brand">Brand:</label>
                                        <h2 class="text-muted"><?= htmlspecialchars($product['manufacturer']) ?></h2>
                                        <label for="category">Category:</label>
                                        <span class="badge bg-primary p-2"><?= htmlspecialchars($product['category']) ?></span>

                                        <p class="mt-3"><?= htmlspecialchars($product['description']) ?></p>

                                        <div class="mt-4 d-flex gap-3">
                                            <!-- Button to open modal -->

                                            <?php
                                             $stockQuery = "SELECT SUM(stock) AS total_stock FROM stocks WHERE product_id = ? AND `condition` != 'expired'";
                                                 $stmt = $conn->prepare($stockQuery);
                                                 $stmt->bind_param("s", $inventory_id);
                                                 $stmt->execute();
                                                 $stockResult = $stmt->get_result();

                                                 if ($row = $stockResult->fetch_assoc()) {
                                                     $totalStock = $row['total_stock'] ?? 0;
                                                 }

                                            ?>

                                            <label for="brand">Total Stocks <br> 
                                                Avialable :
                                            </label>
                                            <h2 class="text-muted"><?= $totalStock; ?></h2>


                                            <button class="btn btn-success btn-lg px-4" data-bs-toggle="modal" data-bs-target="#addStockModal">
                                                <i class="fas fa-plus-circle"></i> Add Stocks
                                            </button>
                                          
                                        </div>

                                        <ul class="list-group list-group-flush mt-4">
                                            <li class="list-group-item"><strong>Product ID:</strong> <?= htmlspecialchars($product['batch_number']) ?></li>
                                            <li class="list-group-item"><strong>Slug:</strong> <?= htmlspecialchars($product['slug']) ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card p-4 shadow-lg border-0">
                            <div class="row">

                          
                                <?php
                                      // Fetch stock details based on product_id
                                  $sql = "SELECT * FROM stocks WHERE product_id = ?";
                                  $stmt = $conn->prepare($sql);
                                  $stmt->bind_param("s", $inventory_id);
                                  $stmt->execute();
                                  $result = $stmt->get_result();
?>
                                <!-- Product Image -->
                                <h2 class="mb-4 text-center text-primary">Stock Information</h2>
                                           <table class="table table-striped">
                                               <thead class="table-dark">
                                                   <tr>
                                                       <th>Parts Number</th>
                                                       <th>Batch Number</th>
                                                       <th>Price</th>
                                                       <th>Unit</th>
                                                       <th>Condition</th>
                                                       <th>Stock</th>
                                                       <th>Reorder Point</th>
                                                       <th>Date Expired</th>
                                            
                                                   </tr>
                                               </thead>
                                               <tbody>
                                                   <?php while ($stock = $result->fetch_assoc()) { ?>
                                                       <tr>
                                                           <td><?= htmlspecialchars($stock['parts_number']) ?></td>
                                                           <td><?= htmlspecialchars($stock['batch_group']) ?></td>
                                                           <td>₱    <?= number_format($stock['price'], 2) ?></td>
                                                           <td><?= htmlspecialchars($stock['unit']) ?></td>
                                                           <td>
                                                               <span class="badge 
                                                                   <?= $stock['condition'] == 'new' ? 'bg-success' : 
                                                                      ($stock['condition'] == 'used' ? 'bg-warning' : 
                                                                      ($stock['condition'] == 'refurbished' ? 'bg-info' : 'bg-danger')) ?>">
                                                                   <?= ucfirst($stock['condition']) ?>
                                                               </span>
                                                           </td>
                                                           <td><?= htmlspecialchars($stock['stock']) ?></td>
                                                           <td><?= htmlspecialchars($stock['reorder_point']) ?></td>
                                                           <td><?= htmlspecialchars($stock['date_expired']) ?></td>
                                                         
                                                       </tr>
                                                   <?php } ?>
                                               </tbody>
                                           </table>

                            </div>
                        </div>
                    </div>



                    <!-- Add Stock Modal -->
                    <div class="modal fade" id="addStockModal" tabindex="-1" aria-labelledby="addStockModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addStockModalLabel">Add Stock for <?= htmlspecialchars($product['parts_name']) ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form action="process/add_stock.php" method="POST">
                                        <div class="modal-body">
                                            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['batch_number']) ?>">

                                            <div class="container-fluid">
                                                <div class="row mb-5">
                                                    <div class="col-md-6">
                                                        <label for="parts_number" class="form-label">Parts Number</label>
                                                        <input type="text" class="form-control" name="parts_number" required>
                                                    </div>
                                                    <?php
                                                        // Fetch the latest batch_group from stocks
                                                    $batchGroup = 1001; // Default value if no batch exists
                                                                                                    
                                           
                                              
                                                        $batchQuery = "SELECT MAX(batch_group) AS latest_batch FROM stocks WHERE product_id = ?";
                                                        $stmt = $conn->prepare($batchQuery);
                                                        $stmt->bind_param("s", $inventory_id);
                                                        $stmt->execute();
                                                        $batchResult = $stmt->get_result();
                                                    
                                                        if ($row = $batchResult->fetch_assoc()) {
                                                            if (!empty($row['latest_batch'])) {
                                                                $batchGroup = $row['latest_batch'] + 1; // Increment the last batch group
                                                            }
                                                        }
                                             
                                                    ?>
                                                    
                                                    <div class="col-md-6">
                                                        <label for="batch_group" class="form-label">Batch Group</label>
                                                        <input type="text" class="form-control" name="batch_group" value="<?= htmlspecialchars($batchGroup) ?>" readonly required>
                                                    </div>

                                                    <div class="col-md-4 mt-3">
                                                        <label for="price" class="form-label">Price</label>
                                                        <input type="number" class="form-control" name="price" step="0.01" required>
                                                    </div>

                                                    
                                                    <div class="col-md-4 mt-3">
                                                        <label for="unit" class="form-label">Unit</label>
                                                        <select class="form-control" name="unit" required>
                                                            <option value="" disabled selected>Select Unit</option>
                                                            <option value="Pieces">Pieces</option>
                                                            <option value="Boxes">Boxes</option>
                                                            <option value="Kilograms">Kilograms</option>
                                                            <option value="Liters">Liters</option>
                                                            <option value="Meters">Meters</option>
                                                        </select>
                                                    </div>



                                                    <div class="col-md-4 mt-3">
                                                        <label for="condition" class="form-label">Condition</label>
                                                        <select class="form-control" name="condition" required>
                                                            <option value="" disabled selected>Select Condition</option>
                                                            <option value="new">New</option>
                                                            <option value="used">Used</option>
                                                            <option value="refurbished">Refurbished</option>
                                                            <option value="damaged">Damaged</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md-3 mt-3">
                                                        <label for="stock" class="form-label">Stock</label>
                                                        <input type="number" class="form-control" name="stock" required>
                                                    </div>

                                                    <div class="col-md-3 mt-3">
                                                        <label for="reorder_point" class="form-label">Reorder Point</label>
                                                        <input type="number" class="form-control" name="reorder_point" required>
                                                    </div>

                                            
                                                    <div class="col-md-3 mt-3">
                                                        <label for="date_expired" class="form-label">Date Expired</label>
                                                        <input type="date" class="form-control" name="date_expired" required>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success">Confirm</button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </form>

                            </div>
                        </div>
                    </div>
                    <!-- End of Modal -->

                <?php } ?>
            </div>
        </div>
    </section>
</main>

<?php
include("../layout/footer.php");
?>
