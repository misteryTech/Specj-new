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

    // Start a transaction to ensure data consistency
    $conn->begin_transaction();

    try {
        // Update the status to 'onprocess' in the transactions table (change to 'Scheduled' as needed)
        $updateTransactionStatusQuery = "
            UPDATE transactions
            SET status = 'Scheduled'
            WHERE id = ?
        ";

        if ($stmt = $conn->prepare($updateTransactionStatusQuery)) {
            $stmt->bind_param("i", $transactionId);  // Corrected binding to match the query
            // Execute the query to set status to 'Scheduled'
            if (!$stmt->execute()) {
                throw new Exception('Error updating transaction status in transactions table.');
            }
            $stmt->close();
        } else {
            throw new Exception('Error preparing the status update query for transactions table.');
        }

        // Update the service schedule and set the status to 'Scheduled' in services_transaction table
        $updateScheduleQuery = "
            UPDATE services_transaction
            SET set_schedule = ?, status = 'Scheduled'
            WHERE service_id = ? AND transaction_id = ?
        ";

        if ($stmt = $conn->prepare($updateScheduleQuery)) {
            $stmt->bind_param("sii", $scheduleDate, $serviceId, $transactionId);  // Corrected parameter binding
            // Execute the query to update the schedule
            if (!$stmt->execute()) {
                throw new Exception('Error updating service schedule in services_transaction table.');
            }
            $stmt->close();
        } else {
            throw new Exception('Error preparing the schedule update query for services_transaction table.');
        }

        // Commit the transaction if both updates are successful
        $conn->commit();

        echo json_encode(['success' => true, 'message' => 'Service schedule set successfully, status updated to Scheduled.']);
    } catch (Exception $e) {
        // Rollback the transaction in case of any errors
        $conn->rollback();
        
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters.']);
}

$conn->close();
?>
