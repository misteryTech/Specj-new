<?php
    include("../layout/header.php");
    include("connection.php"); // Ensure database connection is included
?>

<body>

<?php
    include("../layout/top-nav.php");
    include("side-bar.php");
?>

<main id="main" class="main">

<div class="pagetitle">
  <h1>Brands</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Brands</a></li>

    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-6">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Brands Registration</h5>

      <!-- Multi Columns Form -->
      <form class="row g-3" action="process/brand-registration.php" method="POST" >
                             
        <div class="col-md-12">
            <label for="service_name" class="form-label">Brand Name</label>
            <input type="text" class="form-control" id="brands_name" name="brands_name">
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
            <h5 class="card-title">Brands List</h5>

            <table class="table table-striped" id="service_datatable">
                <thead>
                    <tr>
                        <th>Brands Name</th>
                 
                    </tr>
                </thead>
                <tbody>
    <?php
    if (isset($conn)) {
        $sql = "SELECT * FROM branding ORDER BY brand_name ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
   
            
                echo "<tr>
                        <td>" . htmlspecialchars($row['brand_name']) . "</td>
            
                       
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>No services found</td></tr>";
        }
    } else {
        echo "<tr><td colspan='5'>Database connection error</td></tr>";
    }
    ?>
</tbody>

            </table>
        </div>
    </div>
</div>

</section>

</main><!-- End #main -->

<?php include("../layout/footer.php"); ?>
<!-- 
<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("service_id").value = this.dataset.id;
                document.getElementById("edit_service_name").value = this.dataset.name;
                document.getElementById("edit_Brands").value = this.dataset.Brands;
                document.getElementById("edit_price").value = this.dataset.price;
                let editModal = new bootstrap.Modal(document.getElementById("editModal"));
                editModal.show();
            });
        });

        $(document).ready(function() {
            $('#service_datatable').DataTable();
        });
    });
</script> -->
