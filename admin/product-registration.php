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
                             
                                <div class="col-md-9">
                                <img id="image_preview" src="images/default-placeholder.png" 
     style="width: 200px; height: 200px; object-fit: cover; border: 2px solid #ddd; 
            border-radius: 10px; padding: 5px; display: block; ">
                                    <label for="parts_image" class="form-label">Product Picture (Optional)</label>
                                    <input type="file" class="form-control" id="parts_image" name="parts_image" onchange="previewImage(event)">
                                </div>




                                 <div class="col-md-6">
                                    <label for="parts_name" class="form-label">Parts Name</label>
                                    <input type="text" class="form-control" placeholder="Enter Parts Name" list="parts_list" id="parts_name" name="parts_name">
                                    <datalist id="parts_list"></datalist>
                                </div>

                                <div class="col-md-4">
                                    <label for="slug" class="form-label">Slug</label>
                                    <input type="text" class="form-control" id="slug" name="slug" readonly>
                                </div>

                                <div class="col-md-4">
                                    <label for="batch_number" class="form-label">Batch Number</label>
                                    <input type="text" class="form-control" id="batch_number" name="batch_number" readonly>
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

                                <div class="col-md-6">
                                    <label for="category" class="form-label">Category</label> 
                                    <a href="category.php" class="btn btn-primary mb-3">Add Category</a>
                                    <select class="form-control" id="category" name="category">
    <option value="">Select Category</option>
    <?php
    
    // Fetch categories from the database
    $sql = "SELECT id, category_name FROM category";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['category_name'] . '">' . $row['category_name'] . '</option>';
        }
    } else {
        echo '<option value="">No categories found</option>';
    }

    ?>
</select>

                                </div>

                                <div class="col-md-6">
                                    <label for="manufacturer" class="form-label">Brand Name</label>
                                    <a href="branding.php" class="btn btn-primary mb-3">Add Brand</a>
                                    <select class="form-control" id="manufacturer" name="manufacturer">
                                    <option value="">Select Category</option>
    <?php
    
    // Fetch categories from the database
    $sql = "SELECT id, brand_name FROM branding";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['brand_name'] . '">' . $row['brand_name'] . '</option>';
        }
    } else {
        echo '<option value="">No Brand found</option>';
    }

    ?>
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

$(document).ready(function() {
    // Fetch registered parts for autocomplete
    $.ajax({
        url: "verification/fetch_parts.php",
        type: "GET",
        dataType: "json",
        success: function(response) {
            if (response.length > 0) {
                let dataList = $("#parts_list");
                dataList.empty(); // Clear previous options
                
                response.forEach(function(item) {
                    dataList.append(`<option value="${item}">`);
                });
            }
        },
        error: function(xhr, status, error) {
            console.error("Error:", error);
        }
    });

    // When a part is selected, fetch slug, batch number, and image
    $("#parts_name").on("input", function() {
        let partName = $(this).val().trim();

        if (partName.length < 2) return;

        $.ajax({
            url: "verification/fetch_part_details.php",
            type: "GET",
            data: { parts_name: partName },
            dataType: "json",
            success: function(response) {
                if (response.error) {
                    console.error(response.error);
                } else {
                    $("#slug").val(response.slug);
                    $("#batch_number").val(response.batch_number);
                    $("#image_preview").attr("src", response.image);
                }
            },
            error: function(xhr, status, error) {
                console.error("Error:", error);
            }
        });
    });
});

// Preview uploaded image
function previewImage(event) {
    let reader = new FileReader();
    reader.onload = function() {
        let output = document.getElementById('image_preview');
        output.src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}



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


    </script>