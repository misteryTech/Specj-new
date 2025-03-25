<?php
include("../connection.php");

// Fetch all unique parts_name from parts_registration
$query = "SELECT DISTINCT parts_name FROM parts_registrations ORDER BY parts_name ASC";
$result = $conn->query($query);

$parts = [];

while ($row = $result->fetch_assoc()) {
    $parts[] = $row["parts_name"];
}

$conn->close();

// Return JSON response
header("Content-Type: application/json");
echo json_encode($parts);
?>
