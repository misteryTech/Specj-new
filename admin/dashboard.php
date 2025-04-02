<?php
    include("../layout/header.php");

?>

<body>

  <?php
    include("../layout/top-nav.php");
    include("side-bar.php");
  ?>

  <!-- ======= Sidebar ======= -->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.html">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col-lg-8">
          <div class="row">

            <!-- Sales Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card sales-card">

               
                <div class="card-body">
                  <h5 class="card-title">Scheduled <span>| Services</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-calendar-check"></i>
                    </div>
                    <div class="ps-3">
                    <h6>
                        <?php
                        // Fetch total customer count from the database
                        $sql = "SELECT COUNT(*) AS total_services FROM services_transaction WHERE status = 'Scheduled'"; // Adjust table name as needed
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['total_services'] ?? 0; // Display 0 if no data
                        ?>
                    </h6>
                   

                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Sales Card -->

            <!-- Revenue Card -->
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                
                <div class="card-body">
                <h5 class="card-title">Total Customers</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-lines-fill"></i>
                    </div>
                    <div class="ps-3">
                   
                    <h6>
                        <?php
                        // Fetch total customer count from the database
                        $sql = "SELECT COUNT(*) AS total_customers FROM users"; // Adjust table name as needed
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        echo $row['total_customers'] ?? 0; // Display 0 if no data
                        ?>
                    </h6>
                    </div>
                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

            <div class="col-xxl-4 col-md-6">
              <div class="card info-card expired-item">

       <div class="card-body">
  
  <h5 class="card-title">Expired Items</h5>
  <a href="expired-list.php"> 
  <div class="d-flex align-items-center">
    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
      <i class="bi bi-exclamation-triangle"></i>
    </div>
    <div class="ps-3">
      <?php


      // Get current date
      $currentDate = date('Y-m-d');

      // Query to count expired products
      $query = "SELECT COUNT(*) AS expired_count FROM stocks WHERE date_expired < ?";
      
      if ($stmt = $conn->prepare($query)) {
          $stmt->bind_param("s", $currentDate);
          $stmt->execute();
          $stmt->bind_result($expiredCount);
          $stmt->fetch();
          $stmt->close();
      } else {
          $expiredCount = 0; // In case of query failure
      }
      ?>

      <h6><?php echo $expiredCount; ?> Expired</h6>
      </a>

      <span class="text-danger small pt-1 fw-bold">Check Inventory</span>
    </div>




                  </div>
                </div>

              </div>
            </div><!-- End Revenue Card -->

   

            
   

            
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card out-stock">

                
                <div class="card-body">
                <h5 class="card-title">On Process</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <div class="spinner-border" role="status">
  <span class="visually-hidden">Loading...</span>
</div>
                    </div>
                    <div class="ps-3">
            
                  <h6>
                  <?php
                      // Fetch total count of parts that are out of stock or below reorder point
                      $sql_transactions_process = "SELECT COUNT(*) AS trans_status_process FROM transactions WHERE status='onprocess'"; 
                      $result_transactions_process = $conn->query($sql_transactions_process);
                      $row_transactions_process = $result_transactions_process->fetch_assoc();
                      echo $row_transactions_process['trans_status_process'] ?? 0; // Display 0 if no data
                      ?>
                  </h6>


                    </div>
                  </div>
                </div>




                

              </div>
            </div><!-- End Revenue Card -->





            
            <div class="col-xxl-4 col-md-6">
              <div class="card info-card revenue-card">

                
                <div class="card-body">
                <h5 class="card-title">Completed Task</h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                    <i class="bi bi-graph-up"></i>
                    </div>
                    <div class="ps-3">
                    <h6>
                      <?php
                      // Fetch total count of parts that are out of stock or below reorder point
                      $sql_transactions = "SELECT COUNT(*) AS trans_status FROM transactions WHERE status='Completed'"; 
                      $result_transactions = $conn->query($sql_transactions);
                      $row_transactions = $result_transactions->fetch_assoc();
                      echo $row_transactions['trans_status'] ?? 0; // Display 0 if no data
                      ?>
                  </h6>

                    </div>
                  </div>
                </div>




                

              </div>
            </div><!-- End Revenue Card -->





            <!-- <div class="col-xxl-4 col-xl-12">

              <div class="card info-card customers-card">

                <div class="filter">
                  <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <li class="dropdown-header text-start">
                      <h6>Filter</h6>
                    </li>

                    <li><a class="dropdown-item" href="#">Today</a></li>
                    <li><a class="dropdown-item" href="#">This Month</a></li>
                    <li><a class="dropdown-item" href="#">This Year</a></li>
                  </ul>
                </div>

                <div class="card-body">
                  <h5 class="card-title">Customers <span>| This Year</span></h5>

                  <div class="d-flex align-items-center">
                    <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="ps-3">
                      <h6>1244</h6>
                      <span class="text-danger small pt-1 fw-bold">12%</span> <span class="text-muted small pt-2 ps-1">decrease</span>

                    </div>
                  </div>

                </div>
              </div>

            </div> -->

           

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">

          <!-- Recent Activity -->
          <div class="card">
          
            <div class="card-body">
              <h5 class="card-title">List of Services<span>| Today</span></h5>
              <table class="table table-borderless">
    <thead>
        <tr>
            <th>Service Name</th>
            <th>Price</th>
            <th>Total Availed</th>
        </tr>
    </thead>
    <tbody>
        <?php
        include("connection.php"); // Ensure this file establishes a valid database connection

        // Fetch the list of services and the total number of times each service has been availed
        $query_services = "
            SELECT 
                ms.service_name, 
                ms.price, 
                COUNT(st.id) AS total_availed
            FROM motorcycle_services ms
            LEFT JOIN services_transaction st ON ms.id = st.service_id
            GROUP BY ms.id, ms.service_name, ms.price
        "; // Adjust column names as per your database schema

        $result = $conn->query($query_services);

        // Check if the query returned results
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['service_name']) . "</td>";
                echo "<td>" . htmlspecialchars($row['price']) . "</td>";
                echo "<td>" . htmlspecialchars($row['total_availed']) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No services found or availed yet.</td></tr>";
        }

        // Close the connection
        $conn->close();
        ?>
    </tbody>
</table>





            </div>
          </div><!-- End Recent Activity -->

   
        </div><!-- End Right side columns -->


        <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Scheduled Services Calendar</h5>
                        <div id='calendar'></div>
                    </div>
                </div>
           </div>


      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php

  include("../layout/footer.php");

  ?>

  <script>  
 document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: 'calendar/load_scheduled_services.php', // URL to fetch events
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        }
    });

    calendar.render();
});


  </script>