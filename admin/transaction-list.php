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
        <li class="breadcrumb-item active">List of Request</li>
      </ol>
    </nav>
  </div><!-- End Page Title -->

  <section class="section dashboard">
    <div class="row">

      <!-- Left side columns -->
      <div class="col-lg-12">
        <div class="row">

          <!-- Recent Sales -->
          <?php
          // Fetch data from the transactions table
          $query = "SELECT * FROM transactions ORDER BY created_at DESC";
          $result = $conn->query($query);
          ?>

          <div class="col-12">
           <div class="card recent-sales overflow-auto">

              <div class="card-body">
                <h5 class="card-title">Transactions</h5>

                <table class="table table-borderless datatable">
                  <thead>
                    <tr>
                      <th scope="col">Name</th>
                      <th scope="col">Total Amount</th>
                      <th scope="col">Transaction</th>
                      <th scope="col">Date Request</th>
                      <th scope="col">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    // Check if there are records returned from the query
                    if ($result->num_rows > 0) {
                      // Loop through the records and display them
                      while ($row = $result->fetch_assoc()) {
                        // Determine the redirection URL based on the transaction type
                        $transactionType = $row['transaction'];
                        $detailsPage = ($transactionType === 'Services') ? 'view-services.php' : 'view-products.php';
                        if ($transactionType === 'Service and Product') {
                          $detailsPage = 'view-both.php';
                        }

                        echo "<tr>
                              <td>{$row['firstname']} {$row['lastname']}</td>
                              <td>{$row['total_amount']}</td>
                              <td>{$row['transaction']}</td>
                              <td>{$row['created_at']}</td>
                              <td>
                                <a href='{$detailsPage}?transaction_id={$row['id']}' class='btn btn-primary btn-sm'>View Details</a>
                              </td>
                            </tr>";
                      }
                    } else {
                      echo "<tr><td colspan='5'>No transactions found.</td></tr>";
                    }
                    ?>
                  </tbody>
                </table>

              </div>

            </div>
          </div>

          <?php
          // Close the database connection
          $conn->close();
          ?>
          <!-- End Recent Sales -->

        </div>
      </div><!-- End Left side columns -->

    </div>
  </section>

</main><!-- End #main -->

<!-- ======= Footer ======= -->
<?php
include("../layout/footer.php");
?>

</body>
</html>
