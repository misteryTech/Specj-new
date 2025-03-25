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
  <h1>Expired Items</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="product-list">Expired List</a></li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Parts List</h5>

                    <table class="table table-striped" id="product_table">
                        <thead>
                            <tr>
                                <th>Product ID</th>
                                <th>Parts Name</th>
                                <th>Batch Group</th>
                                <th>Stock</th>
                                <th>Date Expired</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $currentDate = date('Y-m-d');

                            // Query to get expired items
                            $sql = "SELECT S.*, PR.parts_name 
                                    FROM stocks AS S 
                                    INNER JOIN parts_registrations AS PR ON PR.batch_number = S.product_id 
                                    WHERE S.date_expired < '$currentDate'";

                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>{$row['product_id']}</td>
                                            <td>{$row['parts_name']}</td>
                                            <td>{$row['batch_group']}</td>
                                            <td>{$row['stock']}</td>
                                            <td>{$row['date_expired']}</td>
                                            <td>
                                                <button class='btn btn-danger pullout-btn' 
                                                    data-id='{$row["product_id"]}' 
                                                    data-name='{$row["parts_name"]}' 
                                                    data-batch='{$row["batch_group"]}'
                                                    data-stock='{$row["stock"]}' 
                                                    data-expired='{$row["date_expired"]}'
                                                    data-bs-toggle='modal' 
                                                    data-bs-target='#pulloutModal'>
                                                    <i class='fas fa-trash'></i> Pullout
                                                </button>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No expired products found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
</main><!-- End #main -->

<!-- Pullout Confirmation Modal -->
<div class="modal fade" id="pulloutModal" tabindex="-1" aria-labelledby="pulloutModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="pulloutModalLabel">Confirm Pullout</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="process/pullout_stock.php" method="POST">
        <div class="modal-body">
          <input type="text" name="product_id" id="pullout_product_id">
          <input type="text" name="batch_group" id="pullout_batch_group">
          <p>Are you sure you want to pull out <b id="pullout_part_name"></b> from batch <b id="pullout_batch"></b>?</p>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-danger">Confirm</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include("../layout/footer.php"); ?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".pullout-btn").forEach(button => {
        button.addEventListener("click", function () {
            document.getElementById("pullout_product_id").value = this.dataset.id;
            document.getElementById("pullout_part_name").innerText = this.dataset.name;
            document.getElementById("pullout_batch").innerText = this.dataset.batch;
            document.getElementById("pullout_batch_group").value = this.dataset.batch;
        });
    });
});
</script>
