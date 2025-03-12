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
    <h1>Transaction</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.html">Transaction</a></li>
        <li class="breadcrumb-item active">List of Scheduled</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">
          <?php
          $query = "SELECT T.*, T.id AS transaction_id, ST.* FROM transactions AS T
                    INNER JOIN services_transaction AS ST ON ST.transaction_id = T.id
                    WHERE T.status= 'Scheduled' ORDER BY T.created_at DESC";
          $result = $conn->query($query);
          ?>

          <div class="col-12">
            <div class="card recent-sales overflow-auto">
              <div class="card-body">
                <h5 class="card-title">Scheduled</h5>
                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Total Amount</th>
                      <th>Transaction</th>
                      <th>Status</th>
                      <th>Date Request</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                      while ($row = $result->fetch_assoc()) {
                        $setDate = date('m/d/Y g:i A', strtotime($row['created_at']));
                        echo "<tr>
                              <td>{$row['firstname']} {$row['lastname']}</td>
                              <td>{$row['total_amount']}</td>
                              <td>{$row['transaction']}</td>
                              <td>{$row['status']}</td>
                              <td>$setDate</td>
                              <td>
                                <button class='btn btn-success btn-sm' data-bs-toggle='modal' data-bs-target='#completeModal' data-id='{$row['transaction_id']}'>Complete Task</button>
                              </td>
                            </tr>";
                      }
                    } else {
                      echo "<tr><td colspan='6'>No Scheduled found.</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <?php $conn->close(); ?>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Complete Task Modal -->
<div class="modal fade" id="completeModal" tabindex="-1" aria-labelledby="completeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="completeModalLabel">Confirm Completion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to mark this task as completed?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <form method="POST" action="process/update-task.php">
          <input type="text" name="transaction_id" id="transaction_id">
          <button type="submit" class="btn btn-success">Yes, Complete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  var completeModal = document.getElementById('completeModal');
  completeModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var transactionId = button.getAttribute('data-id');
    document.getElementById('transaction_id').value = transactionId;
  });
</script>

<?php
include("../layout/footer.php");
?>
