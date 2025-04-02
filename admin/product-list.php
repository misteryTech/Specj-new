<?php
    include("../layout/header.php");
    include("connection.php");
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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Parts List</h5>

                    <table class="table table-striped" id="product_table">
                        <thead>
                            <tr>
                                <th>Parts Name</th>
                                <th>Category</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM parts_registrations WHERE archive = 'No' ORDER BY parts_name ASC";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>
                                            <td>" . htmlspecialchars($row['parts_name']) . "</td>
                                            <td>" . htmlspecialchars($row['category']) . "</td>
                                            <td>
                                          

                                                <a href='process/archive-products.php?id=" . $row['id'] . "' 
                                                   class='btn btn-danger btn-sm' 
                                                   onclick='return confirm(\"Are you sure you want to archive this product?\")'>
                                                   Archive
                                                </a>
                                            </td>
                                          </tr>";
                                }
                            } else {
                                echo "<tr><td colspan='3'>No services found</td></tr>";
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

<?php include("../layout/footer.php"); ?>

</body>
</html>
