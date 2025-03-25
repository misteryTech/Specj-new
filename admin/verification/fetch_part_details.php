<?php
include("../connection.php");

// Set the response header to JSON
header("Content-Type: application/json");

try {
    // Get the parts_name from request
    $parts_name = isset($_GET["parts_name"]) ? trim($_GET["parts_name"]) : '';

    if (empty($parts_name)) {
        echo json_encode(["error" => "No part name provided"]);
        exit;
    }

    // Prepare SQL query to check if part name exists in database
    $query = "SELECT slug, batch_number, image FROM parts_registrations WHERE parts_name = ? LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $parts_name);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // If part exists, return existing details
        $image = !empty($row["image"]) ? "process/" . $row["image"] : "images/default-placeholder.png";

        $response = [
            "found" => true, // Indicate that the part exists
            "slug" => $row["slug"],
            "batch_number" => $row["batch_number"],
            "image" => $image
        ];
    } else {
        // If part does not exist, generate new details
        $slug = strtoupper(substr($parts_name, 0, 3)) . "-" . random_int(1000, 9999);
        $batch_number = date("Ymd") . "-" . random_int(1000, 9999);

        $response = [
            "found" => false, // Indicate that the part does not exist
            "slug" => $slug,
            "batch_number" => $batch_number,
            "image" => "images/default-placeholder.png"
        ];
    }

    $stmt->close();
    $conn->close();

    // Return the JSON response
    echo json_encode($response);
} catch (Exception $e) {
    // Handle exceptions
    echo json_encode(["error" => "Server error: " . $e->getMessage()]);
}
?>
