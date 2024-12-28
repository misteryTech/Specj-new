<?php
include("../layout/header.php");
include("connection.php");
?>

<body>

<?php
include("../layout/top-nav.php");
include("side-bar.php");

// Check if a transaction ID is provided
if (!isset($_GET['transaction_id'])) {
    echo "<script>alert('Transaction ID is missing.');</script>";
    echo "<script>window.location.href='transactions.php';</script>";
    exit();
}

$transactionId = intval($_GET['transaction_id']);

// Fetch transaction details (name, total amount, transaction type)
$transactionQuery = "
    SELECT t.firstname, t.lastname, t.total_amount, t.transaction ,t.type_transaction, t.created_at    
    FROM transactions t 
    WHERE t.id = ?
";
$transactionStmt = $conn->prepare($transactionQuery);
$transactionStmt->bind_param("i", $transactionId);
$transactionStmt->execute();
$transactionResult = $transactionStmt->get_result();

if ($transactionResult->num_rows === 0) {
    echo "<script>alert('Invalid Transaction ID.');</script>";
    echo "<script>window.location.href='transactions.php';</script>";
    exit();
}

$transactionDetails = $transactionResult->fetch_assoc();
$transactionStmt->close();
?>

<main id="main" class="main">

  <div class="pagetitle">
    <h1>Transaction Details</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="transactions.php">Transaction</a></li>
        <li class="breadcrumb-item active">Details</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- Transaction Summary -->
      <div class="col-12 mb-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title">Transaction Summary</h5>

            <div class="d-flex flex-wrap">
              <div class="col-md-6 mb-2">
                <p><strong>Name:</strong> <?php echo htmlspecialchars($transactionDetails['firstname'] . " " . $transactionDetails['lastname']); ?></p>
              </div>
              <div class="col-md-6 mb-2">
                <p><strong>Total Amount:</strong> ₱<?php echo number_format($transactionDetails['total_amount'], 2); ?></p>
              </div>
              <div class="col-md-6 mb-2">
                <p><strong>Transaction Type:</strong> <?php echo htmlspecialchars($transactionDetails['type_transaction']); ?></p>
              </div>
              <div class="col-md-6 mb-2">
                <p><strong>Date:</strong> <?php echo date("F d, Y", strtotime($transactionDetails['created_at'])); ?></p>
              </div>
            </div>

          </div>
        </div>
      </div>

      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">

          <!-- Product Services -->
          <?php
          // Fetch services associated with the given transaction ID
          $serviceQuery = "
            SELECT s.id, s.parts_name, s.price , st.quantity, st.status, s.quantity_stock
            FROM product_transaction st
            INNER JOIN parts_registration s ON st.product_id = s.id
            WHERE st.transaction_id = ?
          ";
          $serviceStmt = $conn->prepare($serviceQuery);
          $serviceStmt->bind_param("i", $transactionId);
          $serviceStmt->execute();
          $serviceResult = $serviceStmt->get_result();
          ?>

          <div class="col-12">
            <div class="card recent-sales overflow-auto">
              <div class="card-body">
                <h5 class="card-title">Product for Transaction ID: <?php echo $transactionId; ?></h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">Product Name</th>
                      <th scope="col">Price</th>
                      <th scope="col">Quantity Request</th>
                      <th scope="col">Instock</th>
                      <th scope="col">Status</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Check if there are services for the transaction
                    if ($serviceResult->num_rows > 0) {
                      // Loop through the records and display them
                      while ($row = $serviceResult->fetch_assoc()) {
                        ?>
                        <tr>
                          <td><?php echo htmlspecialchars($row['parts_name']); ?></td>
                          <td>₱<?php echo number_format($row['price'], 2); ?></td>
                          <td><?php echo $row['quantity']; ?></td>
                          <td><?php echo $row['quantity_stock']; ?></td>
                          <td><?php echo $row['status']; ?></td>
                          <td>
                            <button class="btn btn-success btn-sm" 
                              onclick="openReleaseModal(<?php echo $row['id']; ?>, '<?php echo addslashes($row['parts_name']); ?>', <?php echo $row['quantity']; ?>)">
                              Release Item
                            </button>
                          </td>
                        </tr>
                        <?php
                      }
                    } else {
                      echo "<tr><td colspan='5'>No products found for this transaction.</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>

              </div>
            </div>
          </div>

          <?php
          // Close the prepared statement
          $serviceStmt->close();
          ?>

        </div>
      </div><!-- End Left side columns -->

    </div>
  </section>

  <!-- Modal -->
  <div class="modal fade" id="releaseItemModal" tabindex="-1" aria-labelledby="releaseItemModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="releaseItemModalLabel">Release Item</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="releaseForm" method="POST">
            <div class="mb-3">
              <label for="productName" class="form-label">Product Name</label>
              <input type="text" class="form-control" id="productName" name="product_name" readonly>
            </div>
            <div class="mb-3">
              <label for="currentStock" class="form-label">Quantity Request</label>
              <input type="number" class="form-control" id="currentStock" name="current_stock" readonly>
            </div>
       

            <div class="mb-3">
              <label for="quantityRelease" class="form-label">Quantity to Release</label>
              <input type="number" class="form-control" id="quantityRelease" name="quantity_release" required>
            </div>
            <input type="hidden" id="productId" name="product_id">
            <input type="hidden" id="transactionId" name="transaction_id" value="<?php echo $transactionId; ?>">
            <button type="submit" class="btn btn-primary">Release</button>
          </form>
        </div>
      </div>
    </div>
  </div>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php
include("../layout/footer.php");
?>

</body>
</html>

<script>
// Function to open the modal and populate product details
function openReleaseModal(productId, productName, currentStock) {
  document.getElementById('productName').value = productName;
  document.getElementById('currentStock').value = currentStock;
  document.getElementById('productId').value = productId;
  $('#releaseItemModal').modal('show');
}

// Add event listener for the form submission
document.getElementById('releaseForm').addEventListener('submit', function(e) {
    e.preventDefault();

    // Get form data
    const formData = new FormData(this);

    // Send request to server to update stock
    fetch('process/release-product.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json()) // Ensure the response is parsed as JSON
    .then(data => {
      if (data.success) {
        alert('Product Released Successfully!');
        location.reload(); // Reload the page to reflect changes
      } else {
        alert('Error: ' + data.message); // Handle error message from the server
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert('An error occurred. Please try again later.');
    });
});

</script>
