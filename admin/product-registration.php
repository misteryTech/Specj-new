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
  <h1>Motorcycle Product Registration</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Forms</li>
      <li class="breadcrumb-item active">Motorcycle Registration</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-8">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Product Registration</h5>

      <!-- Multi Columns Form -->
      <form class="row g-3" action="process/parts-registration.php" method="POST" enctype="multipart/form-data">
                                <div class="col-md-4">
                                <img id="image_preview" src=""  style="max-width: 100%; margin-bottom: 15px;">
                                    <label for="parts_image" class="form-label">Product Picture (Optional)</label>
                                    <input type="file" class="form-control" id="parts_image" name="parts_image" onchange="previewImage(event)">

                                </div>

                                <div class="col-md-12">
                                    <label for="parts_name" class="form-label">Parts Name</label>
                                    <input type="text" class="form-control" id="parts_name" name="parts_name">
                                </div>

                                <div class="col-md-4">
                                    <label for="services_type" class="form-label">Services Type</label>
                                    <select name="services_type" id="services_type" class="form-select">
                                        <option selected>Select Type Of Vehicle</option>
                                        <option value="Car">Car</option>
                                        <option value="Motorcycle">Motorcycle</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="parts_number" class="form-label">Parts Number</label>
                                    <input type="text" class="form-control" id="parts_number" name="parts_number">
                                </div>

                                <div class="col-md-4">
                                    <label for="date_expired" class="form-label">Date Expired</label>
                                    <input type="date" class="form-control" id="date_expired" name="date_expired" required> 
                                </div>

                                <div class="col-md-4">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-control" id="category" name="category">
                                        <option value="">Select a category</option>
                                        <option value="engine-components">Engine Components</option>
                                        <option value="exhaust-system">Exhaust System</option>
                                        <option value="electrical-and-lighting">Electrical and Lighting</option>
                                        <option value="fuel-system">Fuel System</option>
                                        <option value="braking-system">Braking System</option>
                                        <option value="transmission-and-drivetrain">Transmission and Drivetrain</option>
                                        <option value="suspension-and-steering">Suspension and Steering</option>
                                        <option value="body-and-frame">Body and Frame</option>
                                        <option value="wheels-and-tires">Wheels and Tires</option>
                                        <option value="controls-and-levers">Controls and Levers</option>
                                        <option value="cooling-system">Cooling System</option>
                                        <option value="accessories">Accessories</option>
                                        <option value="protective-gear">Protective Gear</option>
                                        <option value="maintenance-tools">Maintenance Tools</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="manufacturer" class="form-label">Brand Name</label>
                                    <select class="form-control" id="manufacturer" name="manufacturer">
                                        <option value="">Select a Brand</option>
                                        <option value="Rusi">Rusi</option>
                                        <option value="bosch">Bosch</option>
                                        <option value="brembo">Brembo</option>
                                        <option value="did">DID</option>
                                        <option value="dunlop">Dunlop</option>
                                        <option value="ebc-brakes">EBC Brakes</option>
                                        <option value="fmf-racing">FMF Racing</option>
                                        <option value="hinson">Hinson</option>
                                        <option value="kn">K&N</option>
                                        <option value="michelin">Michelin</option>
                                        <option value="ngk">NGK</option>
                                        <option value="ohlins">Ohlins</option>
                                        <option value="pirelli">Pirelli</option>
                                        <option value="renthal">Renthal</option>
                                        <option value="rk-excel">RK Excel</option>
                                        <option value="scorpion-exhausts">Scorpion Exhausts</option>
                                        <option value="shinko">Shinko</option>
                                        <option value="showa">Showa</option>
                                        <option value="vance-hines">Vance & Hines</option>
                                        <option value="wiseco">Wiseco</option>
                                        <option value="yoshimura">Yoshimura</option>
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label for="price" class="form-label">Price</label>
                                    <input type="number" class="form-control" id="price" name="price">
                                </div>

                                <div class="col-md-2">
                                    <label for="quantity_stock" class="form-label">Quantity in Stock</label>
                                    <input type="number" class="form-control" id="quantity_stock" name="quantity_stock">
                                </div>

                                <div class="col-md-2">
                                    <label for="reorder_point" class="form-label">Reorder Point</label>
                                    <input type="number" class="form-control" id="reorder_point" name="reorder_point">
                                </div>

                                <div class="col-md-2">
                                    <label for="quantity_stock" class="form-label">Unit</label>
                                    <select class="form-control" id="unit" name="unit">
                                        <option value="" disabled>Unit</option>
                                        <option value="Pcs">Pieces</option>
                                        <option value="Set">Set</option>
                                        <option value="Roll">Roll</option>
                                        <option value="Pack">Pack</option>
                                      
                                    </select>
                                </div>


                                 
                                <div class="col-md-4">
                                    <label for="condition" class="form-label">Condition</label>
                                    <select name="condition" id="condition" class="form-select">
                                        <option selected>Select Condition</option>
                                        <option value="New">New</option>
                                        <option value="Replacement">Replacement</option>
                                        <option value="Generic">Generic</option>
                                    </select>
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
        <div class="col-lg-4">
            <?php
// Function to format the date into a human-readable form
function get_time_label($timestamp) {
    // Format the timestamp as a date (e.g., 'Y-m-d H:i:s')
    return date('Y-m-d H:i:s', strtotime($timestamp));
}

// Fetch recent product logs (limit to 5 most recent for example)
$sql = "SELECT parts_name, parts_number, quantity_stock, status, action, date_inserted FROM product_logs ORDER BY date_inserted DESC LIMIT 5";
$result = $conn->query($sql);

$activity_items = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $activity_items[] = $row;
    }
}
            ?>
  <div class="card">


    <div class="card-body">
        <h5 class="card-title">Recent Activity <span>| Today</span></h5>

        <div class="activity">
            <?php
            if (!empty($activity_items)) {
                foreach ($activity_items as $activity) {
                    // Get time difference from now
                    $formatted_date = get_time_label($activity['date_inserted']); // A function to format date

                    // Get badge color based on the action type
                    $badge_color = ($activity['action'] === 'registration') ? 'success' : 'info';
                    ?>
                    <div class="activity-item d-flex">
                        <div class="activite-label"><?= $formatted_date ?></div>
                        <i class='bi bi-circle-fill activity-badge text-<?= $badge_color ?> align-self-start'></i>
                        <div class="activity-content">
                            <?= $activity['action'] === 'registration' ? 'Product <strong>' . $activity['parts_name'] . '</strong> registered with stock: ' . $activity['quantity_stock'] : 'Product <strong>' . $activity['parts_name'] . '</strong> updated with stock: ' . $activity['quantity_stock'] ?>
                        </div>
                    </div><!-- End activity item-->
                    <?php
                }
            } else {
                echo "<div class='activity-item d-flex'><div class='activite-label'>No recent activity</div></div>";
            }
            ?>
        </div>

    </div>
</div><!-- End Recent Activity -->


     
        </div><!-- End Right side columns -->



  </div>
</section>

</main><!-- End #main -->

<?php
    include("../layout/footer.php");
?>
 <script>
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function(){
                var output = document.getElementById('image_preview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        function resetImagePreview() {
            document.getElementById('image_preview').src = "";
        }

        $(document).ready(function() {
            $('#parts_datatable').DataTable();
        });


    </script>