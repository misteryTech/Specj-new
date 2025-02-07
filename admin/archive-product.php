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
        <div class="col-lg-12">

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
        $sql = "SELECT * FROM parts_registration WHERE archive= '1' ORDER BY parts_name ASC";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>
                        <td>" . $row['parts_name'] . "</td>
                        <td>" . $row['category'] . "</td>
                        <td>" . $row['price'] . "</td>
                        <td>" . $row['quantity_stock'] . "</td>
                    
                        <td>

                            <a href='process/restore-product.php?id=" . $row['id'] . "' class='btn btn-success btn-sm' onclick='return confirm(\"Are you sure you want to restore this product?\")'>Restore</a>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No product archived</td></tr>";
        }
        ?>
    </tbody>
</table>


                </div>
            </div>

        </div><!-- End Right side columns -->



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
