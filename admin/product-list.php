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

                    <table class="table table-striped" id="service_datatable">
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



          <!-- Right side columns -->
          <div class="col-lg-5">

<div class="card">
    <div class="card-body">
        <h5 class="card-title">Out Stocks Parts</h5>

        <table class="table table-striped" id="service_datatable">
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
while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>" . $row['parts_name'] . "</td>
            <td>" . $row['quantity_stock'] . "</td>
            <td>" . $row['reorder_point'] . "</td>
            <td>
                <a href='edit-service.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'>Restock</a>
            
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
