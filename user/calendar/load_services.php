<?php
// Start the session at the very beginning
session_start();

// Include the database connection
include("../connection.php");

// Check if the user is logged in by verifying the session
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: ../login.php");
    exit(); // Stop further execution
}
$user_id = $_SESSION['user_id'];


header('Content-Type: application/json');

// Query to fetch scheduled services with status "scheduled"
$query = "
    SELECT T.*, ST.*


    FROM transactions AS T
    INNER JOIN services_transaction AS ST ON ST.transaction_id = T.id
    WHERE T.user_id = '$user_id' AND T.transaction = 'Services'
"; // Adjust table and column names as per your schema

$result = $conn->query($query);

$events = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'title' => $row['transaction'] , // Combine service name and price
            'tranSaction' => $row['transaction'] ,
            'start' => $row['set_schedule'] ,
            'totalAmount' => $row['total_amount']// Scheduled date in YYYY-MM-DD format    
        ];
    }
}

echo json_encode($events);

// Close the connection
$conn->close();
?>
