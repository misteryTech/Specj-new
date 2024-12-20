<?php

include("../connection.php");
// Fetch services from database based on the brand
if (isset($_GET['brand'])) {
    $brand = $_GET['brand'];
    
  

    // Query to fetch services for the selected brand
    $sql = "SELECT id, service_name, price FROM motorcycle_services WHERE manufacturer = '$brand' ORDER BY service_name ASC";
    $result = $conn->query($sql);
    
    $services = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $services[] = $row;
        }
    }

    // Return the services in JSON format
    echo json_encode(['services' => $services]);

    // Close the connection
    $conn->close();
}
?>
