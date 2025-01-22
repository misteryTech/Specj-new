<?php
header('Content-Type: application/json');

include("../connection.php"); // Ensure this file establishes a valid database connection

// Query to fetch scheduled services with status "scheduled"
$query = "
    SELECT 
        ms.service_name, 
        ms.price, 
        st.set_schedule
    FROM services_transaction st
    INNER JOIN motorcycle_services ms ON st.service_id = ms.id
    WHERE st.status = 'scheduled'
"; // Adjust table and column names as per your schema

$result = $conn->query($query);

$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'title' => $row['service_name'] . " (₱" . $row['price'] . ")", // Combine service name and price
            'start' => $row['set_schedule'] // Scheduled date in YYYY-MM-DD format
        ];
    }
}

echo json_encode($events);

// Close the connection
$conn->close();
?>
