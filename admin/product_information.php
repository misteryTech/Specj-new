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
  <h1>Motorcycle Product Information</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Forms</li>
      <li class="breadcrumb-item active">Motorcycle Parts</li>
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
                              <form class="row g-3" action="process/parts_registration.php" method="POST" enctype="multipart/form-data">
                             
                              <div class="col-md-6">
    <label for="parts_name" class="form-label">Parts Name</label>
    <input type="text" class="form-control" placeholder="Enter Parts Name" list="parts_list" id="parts_name" name="parts_name">
    <datalist id="parts_list"></datalist>

    <label for="slug" class="form-label mt-2">Slug</label>
    <input type="text" class="form-control" id="slug" name="slug" readonly>

    <label for="batch_number" class="form-label  mt-2">Batch Number</label>
    <input type="text" class="form-control" id="batch_number" name="batch_number" readonly>

    <!-- Message Box for Alerts -->
    <div id="message_box" class="mt-2"></div>

    <!-- Hidden Part Link -->
    <div id="part_link" style="display: none; margin-top: 10px;"></div>
</div>

<div class="col-md-6">
    <img id="image_preview" src="images/default-placeholder.png" 
        style="width: 200px; height: 200px; object-fit: cover; border: 2px solid #ddd; 
                border-radius: 10px; padding: 5px; display: block;">
    
    <label for="parts_image" class="form-label">Product Picture (Optional)</label>
    <input type="file" class="form-control" id="parts_image" name="parts_image" onchange="previewImage(event)">


</div>


                                <div class="col-md-6">
                                    <label for="manufacturer" class="form-label">Brand Name</label>
                                    <a href="branding.php" class="btn btn-primary mb-3">Add Brand</a>
                                    <select class="form-control" id="manufacturer" name="manufacturer">
                                    <option value="">Select Brand</option>
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
                                    <label for="services_type" class="form-label">Services Type</label>
                                    <select name="services_type" id="services_type" class="form-select">
                                        <option selected>Select Type Of Vehicle</option>
                                        <option value="Car">Car</option>
                                        <option value="Motorcycle">Motorcycle</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label for="condition" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="description" name="description" >
                                </div>

                                <div class="text-center">
                              <!-- Submit Button (Initially Disabled) -->
                                    <button type="submit" id="submit_btns" class="btn btn-primary mt-3">Submit</button>
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
?><script>


$(document).ready(function () {
    let submitButton = $("#submit_btns");
    let messageBox = $("#message_box");
    let partLink = $("#part_link");
    let typingTimer;
    const debounceDelay = 300; // Delay to prevent excessive AJAX calls

    // Fetch registered parts for autocomplete
    $.ajax({
        url: "verification/fetch_parts.php",
        type: "GET",
        dataType: "json",
        success: function (response) {
            if (response.length > 0) {
                let dataList = $("#parts_list");
                dataList.empty();
                response.forEach(function (item) {
                    dataList.append(`<option value="${item}">`);
                });
            }
        },
        error: function (xhr, status, error) {
            console.error("Error:", error);
        }
    });

    // Debounce function to reduce AJAX calls
    function debounce(func, delay) {
        clearTimeout(typingTimer);
        typingTimer = setTimeout(func, delay);
    }

    // Check if part exists when typing
    $("#parts_name").on("input", function () {
        let partName = $(this).val().trim();

        if (partName.length < 2) return;

        debounce(function () {
            $.ajax({
                url: "verification/fetch_part_details.php",
                type: "GET",
                data: { parts_name: partName },
                dataType: "json",
                success: function (response) {
                    if (!response.found) { 
                        // Part not found, generate slug & batch number
                        let generatedSlug = generateSlug(partName);
                        let generatedBatch = generateBatchNumber();

                        $("#slug").val(generatedSlug);
                        $("#batch_number").val(generatedBatch);
                        $("#image_preview").attr("src", "images/default-placeholder.png");

                        partLink.hide();
                        messageBox.html(`<div class="alert alert-warning">⚠️ Part not found. You can proceed with registration.</div>`);

                        submitButton.prop("disabled", false); // Enable submit button
                    } else {
                        // Part exists, populate details
                        $("#slug").val(response.slug);
                        $("#batch_number").val(response.batch_number);
                        $("#image_preview").attr("src", response.image || "images/default-placeholder.png");

                        let partUrl = `product_details.php?batch_number=${response.batch_number}`;
                        partLink.html(`<a href="${partUrl}" target="_blank" class="btn btn-success">🔗 View Part Details</a>`).show();

                        messageBox.html(`<div class="alert alert-success">✅ Part found. You can update or review.</div>`);

                        submitButton.prop("disabled", true); // 🔴 Disable submit button for existing part
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Error:", error);
                    messageBox.html(`<div class="alert alert-danger">❌ Server error. Please try again later.</div>`);
                }
            });
        }, debounceDelay);
    });

    function generateSlug(name) {
        let randomNum = Math.floor(1000 + Math.random() * 9000); // Random 4-digit number
        return name.substring(0, 3).toUpperCase() + "-" + randomNum;
    }

    function generateBatchNumber() {
        let date = new Date().toISOString().slice(0, 10).replace(/-/g, ""); // YYYYMMDD format
        let randomNum = Math.floor(1000 + Math.random() * 9000);
        return `${date}-${randomNum}`;
    }

});


    // Preview uploaded image
    function previewImage(event) {
        let reader = new FileReader();
        reader.onload = function () {
            $("#image_preview").attr("src", reader.result);
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    // Reset image preview
    function resetImagePreview() {
        $("#image_preview").attr("src", "images/default-placeholder.png");
    }

</script>
