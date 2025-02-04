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

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Scheduled Services Calendar</h5>
                        <div id='calendar'></div>
                    </div>
                </div>
           </div>

          </div>
        </div><!-- End Left side columns -->

        <!-- Right side columns -->
        <div class="col-lg-4">
    <!-- Recent Activity -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">List of Services <span>| Logs</span></h5>

            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Total Amount</th>
                            <th>Transaction</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include("connection.php"); // Ensure this file establishes a valid database connection

                        // Fetch the list of services and the total number of times each service has been availed
                        $query_services = "
                            SELECT * FROM transactions
                            WHERE user_id = '$user_id' 
                            ORDER BY created_at DESC 
                            LIMIT 10
                        "; 

                        $result = $conn->query($query_services);

                        // Check if the query returned results
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars(date("F/d/Y", strtotime($row['created_at']))) . "</td>";
                                echo "<td>" . htmlspecialchars($row['total_amount']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['transaction']) . "</td>";
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
        </div>
    </div><!-- End Recent Activity -->
</div><!-- End Right side columns -->




      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php

  include("../layout/footer.php");

  ?>

  <script>  
document.addEventListener('DOMContentLoaded', function () {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: 'calendar/load_services.php', // URL to fetch events
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth'
        },
        eventDidMount: function (info) {
            // Add tooltip or extended display for amount & description
            var tooltipContent = `Transaction: ${info.event.extendedProps.tranSaction} <br> Total Amount: ₱ ${info.event.extendedProps.totalAmount}`;
            var tooltip = new bootstrap.Tooltip(info.el, {
                title: tooltipContent,
                html: true,
                placement: 'top'
            });
        },
        eventContent: function(arg) {
            return {
                html: `<b>${arg.event.title}</b><br>
                       <strong>Total: ₱ ${arg.event.extendedProps.totalAmount}</strong>`
            };
        }
    });

    calendar.render();
});




  </script>