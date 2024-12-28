<?php
include("../connection.php");

// Check if the required POST data is present
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['service_id'], $_POST['transaction_id'], $_POST['schedule_date'])) {
    $serviceId = intval($_POST['service_id']);
    $transactionId = intval($_POST['transaction_id']);
    $scheduleDate = $_POST['schedule_date'];

    // Ensure valid input
    if ($serviceId <= 0 || $transactionId <= 0 || empty($scheduleDate)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
        exit();
    }

    // Update the service schedule and status
    $updateQuery = "
        UPDATE services_transaction
        SET set_schedule = ?, status = 'Scheduled'
        WHERE service_id = ? AND transaction_id = ?
    ";

    if ($stmt = $conn->prepare($updateQuery)) {
        $stmt->bind_param("sii", $scheduleDate, $serviceId, $transactionId);
        
        // Execute the query
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Service schedule set successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error updating service schedule.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error preparing the query.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters.']);
}

$conn->close();
?>
