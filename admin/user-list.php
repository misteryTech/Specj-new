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
        <div class="col-lg-12">
          <div class="row">

            <!-- Recent Sales -->
            <?php
            // Fetch data from the users table
            $query = "SELECT * FROM users";
            $result = $conn->query($query);
            ?>

            <div class="col-12">
              <div class="card recent-sales overflow-auto">

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
                  <h5 class="card-title">User List <span>| All Users</span></h5>

                  <table class="table table-borderless datatables" id="userlist">
                    <thead>
                      <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Username</th>
                        <th scope="col">Email</th>
                        <th scope="col">Status</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // Check if there are records returned from the query
                      if ($result->num_rows > 0) {
                        // Loop through the records and display them
                        while ($row = $result->fetch_assoc()) {
                            $archivestatus = ($row['archive'] == 0) ? 'Unarchive' : 'Archive';
                          echo "<tr>
                                <td>{$row['firstname']} {$row['lastname']}</td>
                                <td>{$row['username']}</td>
                                <td>{$row['email']}</td>
                                <td>{$archivestatus}</td>
                              </tr>";
                        }
                      } else {
                        echo "<tr><td colspan='4'>No users found.</td></tr>";
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

<script>
    $(document).ready( function (){
        $('#userlist').DataTable();
    });
</script>
