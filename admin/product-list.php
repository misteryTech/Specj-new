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
  <h1>Vehicle Parts</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="product-list">Product</a></li>
      <li class="breadcrumb-item">List of Product</li>
      <li class="breadcrumb-item active">Parts</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section">
  <div class="row">
        <!-- Right side columns -->
        <div class="col-lg-7">

            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Parts List</h5>

                    <table class="table table-striped" id="product_table">
    <thead>
        <tr>
            <th>Parts Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
           
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Fetch services from the database (including the ID)
        $sql = "SELECT * FROM parts_registration ORDER BY parts_name ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['parts_name'] . "</td>
                        <td>" . $row['category'] . "</td>
                        <td>" . $row['price'] . "</td>
                        <td>" . $row['quantity_stock'] . "</td>
                    
                        <td><button class='btn btn-warning btn-sm edit-btn' 
                                       data-id='{$row['id']}' 
                                  data-name='{$row['parts_name']}'
                                  data-category='{$row['category']}'
                                  data-parts_number='{$row['parts_number']}'
                                  data-date_expired='{$row['date_expired']}'
                                  data-manufacturer='{$row['manufacturer']}'
                                  data-quantity_stock='{$row['quantity_stock']}'
                                  data-reorder_point='{$row['reorder_point']}'
                                  data-condition='{$row['condition']}'
                                  data-price='{$row['price']}'>Edit</button>

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



          <!-- Right side columns -->
          <div class="col-lg-5">

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Out Stocks Parts</h5>

        <table class="table table-striped" id="product_table">
<thead>
<tr>
<th>Parts Name</th>
<th>Stocks</th>
<th>Reorder Point</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php
// Fetch services from the database (including the ID)
$sql = "SELECT * FROM parts_registration  WHERE quantity_stock <= reorder_point ORDER BY parts_name ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
while ($rows = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . $rows['parts_name'] . "</td>
            <td>" . $rows['quantity_stock'] . "</td>
            <td>" . $rows['reorder_point'] . "</td>
            <td>
               <button class='btn btn-success btn-sm restock-btn' 
                                       data-id='{$rows['id']}' 
                                       data-quantity_stock='{$rows['quantity_stock']}' 
                                       >Restock</button>
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
</div>

</div><!-- End Right side columns -->



   <!-- Edit Modal -->
   <div class="modal fade" id="editModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Part</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <form id="editForm" method="POST" action="process/update-products.php">
            <div class="modal-body">
              <input type="hidden" name="part_id" id="part_id">
              <div class="mb-3">
                <label for="edit_name" class="form-label">Part Name</label>
                <input type="text" class="form-control" id="edit_name" name="edit_name" required>
              </div>

              <div class="mb-3">
                <label for="edit_parts_number" class="form-label">Part Number</label>
                <input type="text" class="form-control" id="edit_parts_number" name="edit_parts_number" required>
              </div>

              <div class="mb-3">
                <label for="edit_date_expired" class="form-label">Date Expired</label>
                <input type="date" class="form-control" id="edit_date_expired" name="edit_date_expired" required>
              </div>




              <div class="mb-3">
                <label for="edit_category" class="form-label">Category</label>
                <select class="form-control" id="edit_category" name="edit_category">
                  <option value="">Select a Category</option>
                  <?php
                    $cat_sql = "SELECT DISTINCT category FROM parts_registration";
                    $cat_result = $conn->query($cat_sql);
                    while ($cat = $cat_result->fetch_assoc()) {
                        echo "<option value='{$cat['category']}'>{$cat['category']}</option>";
                    }
                  ?>
                </select>
              </div>
              <div class="mb-3">
                <label for="edit_manufacturer" class="form-label">Manufacturer</label>
                <select class="form-control" id="edit_manufacturer" name="edit_manufacturer">
                  <option value="">Select a Manufacturer</option>
                  <?php
                    $man_sql = "SELECT DISTINCT manufacturer FROM parts_registration";
                    $man_result = $conn->query($man_sql);
                    while ($man = $man_result->fetch_assoc()) {
                        echo "<option value='{$man['manufacturer']}'>{$man['manufacturer']}</option>";
                    }
                  ?>
                </select>
              </div>


              <div class="mb-3">
                <label for="edit_condition" class="form-label">Condition</label>
            

                <select class="form-control" id="edit_condition" name="edit_condition">

                <option value="">Select a category</option>
                <option value="Replacement">Replacement</option>
                <option value="New">New</option>

                </select>
              </div>


              <div class="mb-3">
                <label for="edit_quantity_stock" class="form-label">Stock Quantity</label>
                <input type="number" class="form-control" id="edit_quantity_stock" name="edit_quantity_stock" required>
              </div>

              <div class="mb-3">
                <label for="edit_reorder_point" class="form-label">Reorder Point</label>
                <input type="number" class="form-control" id="edit_reorder_point" name="edit_reorder_point" required>
              </div>

              <div class="mb-3">
                <label for="edit_price" class="form-label">Price</label>
                <input type="number" class="form-control" id="edit_price" name="edit_price" required>
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




    

   <!-- REstock Modal -->
   <div class="modal fade" id="restockModal" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Product Stocks</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
     


          <form id="editForm" method="POST" action="process/update-stocks.php">
            <div class="modal-body">
              <input type="hidden" name="parts_id" id="parts_id">
              <div class="mb-3">
                <label for="stocks" class="form-label">Stocks</label>
                <input type="text" class="form-control" id="stocks" name="stocks" >
              </div>

              <div class="mb-3">
                <label for="stocks_added" class="form-label">Stocks Added</label>
                <input type="text" class="form-control" id="stocks_added" name="stocks_added" required>
              </div>


            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
          </form>



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
   document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".edit-btn").forEach(button => {
      button.addEventListener("click", function () {
        document.getElementById("part_id").value = this.dataset.id;
        document.getElementById("edit_name").value = this.dataset.name;
        document.getElementById("edit_parts_number").value = this.dataset.parts_number;
        document.getElementById("edit_date_expired").value = this.dataset.date_expired;
        document.getElementById("edit_category").value = this.dataset.category;
        document.getElementById("edit_manufacturer").value = this.dataset.manufacturer;
        document.getElementById("edit_reorder_point").value = this.dataset.reorder_point;
        document.getElementById("edit_quantity_stock").value = this.dataset.quantity_stock;
        document.getElementById("edit_price").value = this.dataset.price;
        document.getElementById("edit_condition").value = this.dataset.condition;

        let editModal = new bootstrap.Modal(document.getElementById("editModal"));
        editModal.show();
      });
    });



    document.querySelectorAll(".restock-btn").forEach(button =>{
        button.addEventListener("click", function () {

            document.getElementById("parts_id").value = this.dataset.id;
            document.getElementById("stocks").value = this.dataset.quantity_stock;


            let restockModal = new bootstrap.Modal(document.getElementById("restockModal"));
            restockModal.show();


        });
    });
  });

    </script>
