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
    <h1>Reports</h1>
    <nav>
      <ol class="breadcrumb">
        <li class="breadcrumb-item active">Data Reports</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">
      <div class="col-lg-12">
        <div class="row">

          <!-- Filter Form -->
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <h5 class="card-title">Filter by Date</h5>
                <form method="GET" action="">
                  <div class="row">
                    <div class="col-md-4">
                      <label for="start_date" class="form-label">Start Date</label>
                      <input type="date" class="form-control" name="start_date" id="start_date" required>
                    </div>
                    <div class="col-md-4">
                      <label for="end_date" class="form-label">End Date</label>
                      <input type="date" class="form-control" name="end_date" id="end_date" required>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                      <button type="submit" class="btn btn-primary">Filter</button>
                      <button type="button" class="btn btn-success ms-2" onclick="printReport()">Print</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <?php
          // Get filter values from GET request
          $start_date = $_GET['start_date'] ?? '';
          $end_date = $_GET['end_date'] ?? '';

          // Default query
          $query = "SELECT T.*, T.id AS transaction_id, ST.* FROM transactions AS T
                    INNER JOIN services_transaction AS ST ON ST.transaction_id = T.id
                ";

          // Apply date filter if selected
          if (!empty($start_date) && !empty($end_date)) {
              $query .= " AND DATE(T.created_at) BETWEEN '$start_date' AND '$end_date'";
          }

          $query .= " ORDER BY T.created_at DESC";
          $result = $conn->query($query);
          ?>

          <div class="col-12">
            <div class="card recent-sales overflow-auto">
              <div class="card-body">
                <h5 class="card-title">Scheduled</h5>
                
                <div id="printableArea">
                  <table class="table table-borderless datatable">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Total Amount</th>
                        <th>Transaction</th>
                        <th>Status</th>
                        <th>Date Request</th>
                       
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
                             
                              </tr>";
                        }
                      } else {
                        echo "<tr><td colspan='6'>No records found.</td></tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div> <!-- End Printable Area -->

              </div>
            </div>
          </div>

          <?php $conn->close(); ?>
        </div>
      </div>
    </div>
  </section>
</main>

<!-- Complete Task Modal
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
          <input type="hidden" name="transaction_id" id="transaction_id">
          <button type="submit" class="btn btn-success">Yes, Complete</button>
        </form>
      </div>
    </div>
  </div>
</div> -->

<script>
  var completeModal = document.getElementById('completeModal');
  completeModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;
    var transactionId = button.getAttribute('data-id');
    document.getElementById('transaction_id').value = transactionId;
  });

  function printReport() {
    var printContents = document.getElementById("printableArea").innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
    location.reload();
  }
</script>

<?php
include("../layout/footer.php");
?>
