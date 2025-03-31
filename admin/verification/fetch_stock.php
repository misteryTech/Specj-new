<?php
include("../connection.php");

header('Content-Type: application/json'); // Ensure response is JSON

// // Enable error reporting for debugging
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

if (!isset($_GET['product_id']) || empty($_GET['product_id'])) {
    echo json_encode(["error" => "Invalid product ID"]);
    exit;
}
$product_id = $_GET['product_id']; // Get product ID from request

$sql = "SELECT s.stock, s.price, s.unit, s.date_expired, s.product_id , pr.batch_number, s.batch_group
        FROM stocks s 
        INNER JOIN parts_registrations pr ON pr.batch_number = s.product_id
        WHERE s.product_id = ? AND (s.date_expired IS NULL OR s.date_expired > CURDATE())";

// Check if the SQL statement is valid
$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo json_encode(["error" => "SQL Prepare Error: " . $conn->error]);
    exit;
}

// Bind parameter and check for errors
if (!$stmt->bind_param("s", $product_id)) {
    echo json_encode(["error" => "Binding Parameter Error: " . $stmt->error]);
    exit;
}

// Execute query and check for errors
if (!$stmt->execute()) {
    echo json_encode(["error" => "Execution Error: " . $stmt->error]);
    exit;
}

$result = $stmt->get_result();

// Fetch data and handle errors
$stockData = [];
while ($row = $result->fetch_assoc()) {
    unset($row['date_expired']); // Remove expiration date from response
    $stockData[] = $row;
}

// If no stock data found, return an error message
if (empty($stockData)) {
    echo json_encode(["error" => "No stock data found or all stocks are expired."]);
    exit;
}

// Return the stock data as JSON
echo json_encode($stockData);
?>
