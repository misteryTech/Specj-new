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
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    if (isset($conn)) {
        $sql = "SELECT id, service_name, category, price, archive FROM motorcycle_services ORDER BY service_name ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $buttonText = ($row['archive'] == 1) ? 'Unarchive' : 'Archive';
                $buttonClass = ($row['archive'] == 1) ? 'btn-success' : 'btn-danger';
                $confirmMessage = ($row['archive'] == 1) 
                    ? "Are you sure you want to unarchive this service?" 
                    : "Are you sure you want to archive this service?";

                echo "<tr>
                        <td>" . htmlspecialchars($row['service_name']) . "</td>
                        <td>" . htmlspecialchars($row['category']) . "</td>
                        <td>" . htmlspecialchars($row['price']) . "</td>
                        <td>" . ($row['archive'] == 1 ? 'Archived' : 'Active') . "</td>
                        <td>
                            <button class='btn btn-warning btn-sm edit-btn' 
                                data-id='" . $row['id'] . "' 
                                data-name='" . htmlspecialchars($row['service_name']) . "' 
                                data-category='" . htmlspecialchars($row['category']) . "' 
                                data-price='" . htmlspecialchars($row['price']) . "'>
                                Edit
                            </button>
                            <a href='process/archive-services.php?id=" . $row['id'] . "&archive=" . $row['archive'] . "' 
                                class='btn $buttonClass btn-sm' 
                                onclick='return confirm(\"$confirmMessage\")'>
                                $buttonText
                            </a>
                        </td>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Service</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST" action="process/update-service.php">
                <div class="modal-body">
                    <input type="hidden" name="service_id" id="service_id">
                    <div class="mb-3">
                        <label for="edit_service_name" class="form-label">Service Name</label>
                        <input type="text" class="form-control" id="edit_service_name" name="service_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_category" class="form-label">Category</label>
                        <select class="form-control" id="edit_category" name="edit_category">
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
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Price</label>
                        <input type="number" step="0.01" class="form-control" id="edit_price" name="price" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

</section>

</main><!-- End #main -->

<?php include("../layout/footer.php"); ?>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".edit-btn").forEach(button => {
            button.addEventListener("click", function () {
                document.getElementById("service_id").value = this.dataset.id;
                document.getElementById("edit_service_name").value = this.dataset.name;
                document.getElementById("edit_category").value = this.dataset.category;
                document.getElementById("edit_price").value = this.dataset.price;
                let editModal = new bootstrap.Modal(document.getElementById("editModal"));
                editModal.show();
            });
        });

        $(document).ready(function() {
            $('#service_datatable').DataTable();
        });
    });
</script>
