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
  <h1>Services</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item">Forms</li>
      <li class="breadcrumb-item active">List of Services</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
    <div class="col-lg-12">

      <div class="card">
        <div class="card-body">
          <h5 class="card-title">Select Services</h5>

          <!-- Multi Columns Form -->
          <form id="serviceForm" class="row g-3" action="process/transction-registration.php" method="POST">

  
                            <h6>Customer Information</h6>
                            <hr>
                     
                        <div class="col-md-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="first_name" name="first_name" required>
                        </div>

                        <div class="col-md-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="last_name" name="last_name" required>
                        </div>

                     
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                      
                        <div class="col-md-6">
                            <label for="set-sched" class="form-label">Set Schedule</label>
                            <input type="date" class="form-control" id="schedule" name="schedule" required>
                        </div>

          
              <?php
              // Fetch services from the database
              $sql = "SELECT id, service_name, category, price FROM motorcycle_services ORDER BY service_name ASC";
              $result = $conn->query($sql);
              ?>

              <div class="col-md-6">
                  <label for="service" class="form-label">List of Services</label>
                  <select class="form-control" id="service" name="service" onchange="updatePrice()">
                      <option value="">Select Service</option>
                      <?php
                      if ($result->num_rows > 0) {
                          while ($row = $result->fetch_assoc()) {
                              echo "<option value='" . $row['id'] . "' data-price='" . $row['price'] . "'>" . $row['service_name'] . "</option>";
                          }
                      } else {
                          echo "<option value=''>No services available</option>";
                      }
                      ?>
                  </select>
              </div>

              <div class="col-md-6">
                  <label for="price" class="form-label">Price</label>
                  <input type="text" class="form-control" id="price" name="price" readonly>
              </div>

              <div class="col-md-12 text-center">
                  <button type="button" class="btn btn-primary" id="addServiceButton">Add Service</button>
              </div>

              <div class="col-md-12">
                  <h5>Selected Services</h5>
                  <ul id="selectedServicesList" class="list-group"></ul>
              </div>

              <div class="col-md-12 text-end">
                  <h5>Total: ₱ <span id="totalPrice">0</span></h5>
              </div>

              <input type="hidden" id="selectedServices" name="selectedServices">
              <input type="hidden" id="product_transaction" name="product_transaction" value="Services">
              <div class="text-center">
                  <button type="submit" class="btn btn-success">Submit</button>
              </div>
          </form><!-- End Multi Columns Form -->

        </div>
      </div>

    </div>
  </div>
</section>

</main><!-- End #main -->

<?php
include("../layout/footer.php");
?>

<script>
// Function to update the price when a service is selected
function updatePrice() {
    var serviceSelect = document.getElementById('service');
    var selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
    var price = selectedOption.getAttribute('data-price');
    document.getElementById('price').value = price;
}

// Add service functionality
document.getElementById('addServiceButton').addEventListener('click', function() {
    var serviceSelect = document.getElementById('service');
    var selectedOption = serviceSelect.options[serviceSelect.selectedIndex];
    var serviceId = serviceSelect.value;
    var serviceName = selectedOption.textContent;
    var price = parseFloat(selectedOption.getAttribute('data-price'));

    if (serviceId === "") {
        alert("Please select a service to add.");
        return;
    }

    var selectedServicesList = document.getElementById('selectedServicesList');
    
    // Check if the service is already in the list
    if ([...selectedServicesList.children].some(item => item.dataset.serviceId === serviceId)) {
        alert("This service is already added.");
        return;
    }

    // Create a list item for the selected service
    var listItem = document.createElement('li');
    listItem.className = "list-group-item d-flex justify-content-between align-items-center";
    listItem.dataset.serviceId = serviceId;
    listItem.dataset.price = price;
    listItem.innerHTML = `
   ${serviceName} - ₱ ${new Intl.NumberFormat('en-PH', { style: 'decimal', minimumFractionDigits: 2 }).format(price)}
        <button type="button" class="btn btn-sm btn-danger removeService">Remove</button>
    `;

    selectedServicesList.appendChild(listItem);
    updateTotal();
});

// Remove individual service
document.getElementById('selectedServicesList').addEventListener('click', function(e) {
    if (e.target.classList.contains('removeService')) {
        e.target.parentElement.remove();
        updateTotal();
    }
});

// Update total price
function updateTotal() {
    var totalPrice = 0;
    var selectedServices = [];
    document.querySelectorAll("#selectedServicesList li").forEach(item => {
        totalPrice += parseFloat(item.dataset.price);
        selectedServices.push(item.dataset.serviceId);
    });
    // Format the total price with commas
    document.getElementById("totalPrice").textContent = new Intl.NumberFormat('en-PH', { 
        style: 'decimal', 
        minimumFractionDigits: 2 
    }).format(totalPrice);
    // Store the selected services as JSON
    document.getElementById("selectedServices").value = JSON.stringify(selectedServices);
}

</script>
