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
  <h1>Motorcycle Services Registration</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Forms</li>
      <li class="breadcrumb-item active">Motorcycle Services Registration</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-6">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Service Registration</h5>

      <!-- Multi Columns Form -->
      <form class="row g-3" action="process/service-registration.php" method="POST" >
                             
                                <div class="col-md-12">
                                    <label for="service_name" class="form-label">Service Name</label>
                                    <input type="text" class="form-control" id="service_name" name="service_name">
                                </div>

                                <div class="col-md-4">
                                    <label for="service_type" class="form-label">Service Type</label>
                                    <select name="service_type" id="service_type" class="form-select">
                                        <option selected>Motorcycle</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-control" id="category" name="category">
                                        <option value="">Select a category</option>
                                        <option value="engine-repair">Engine Repair</option>
                                        <option value="brake-service">Brake Service</option>
                                        <option value="oil-change">Oil Change</option>
                                        <option value="tire-change">Tire Change</option>
                                        <option value="suspension-service">Suspension Service</option>
                                        <option value="electrical-service">Electrical Service</option>
                                        <option value="general-maintenance">General Maintenance</option>
                                    </select>
                                </div>

                           
                                <div class="col-md-4">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="price" name="price">
                                </div>

                            
                                
                                <div class="text-center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                    <button type="reset" class="btn btn-secondary" onclick="resetImagePreview()">Reset</button>
                                </div>
                            </form><!-- End Multi Columns Form -->


        </div>
      </div>

    </div>


        <!-- Right side columns -->
        <div class="col-lg-6">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Registered Motorcycle Services</h5>

                    <table class="table table-striped" id="service_datatable">
    <thead>
        <tr>
            <th>Service Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch services from the database (including the ID)
        $sql = "SELECT id, service_name, category, price FROM motorcycle_services ORDER BY service_name ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['service_name'] . "</td>
                        <td>" . $row['category'] . "</td>
                        <td>" . $row['price'] . "</td>
                        <td>
                            <a href='edit-service.php?id=" . $row['id'] . "' class='btn btn-warning btn-sm'>Edit</a>
                            <a href='archive-service.php?id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure you want to archive this service?\")'>Archive</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No services found</td></tr>";
        }
        ?>
    </tbody>
</table>


                </div>
            </div>

        </div><!-- End Right side columns -->

  </div>
</section>

</main><!-- End #main -->

<?php
    include("../layout/footer.php");
?>
 <script>
       

        $(document).ready(function() {
            $('#service_datatable').DataTable();
        });
    </script>
