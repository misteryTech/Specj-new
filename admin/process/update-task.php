<?php
include("../connection.php"); // Ensure database connection is included
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["transaction_id"])) {
    $transaction_id = intval($_POST["transaction_id"]);
    $date_completed = date("Y-m-d H:i:s"); // Get current date and time

    // Update queries
    $updateTransaction = "UPDATE transactions SET status = 'Completed', date_completed = ? WHERE id = ?";
    $updateServiceTransaction = "UPDATE services_transaction SET status = 'Completed' WHERE transaction_id = ?";

    // Prepare statements
    $stmt1 = $conn->prepare($updateTransaction);
    $stmt2 = $conn->prepare($updateServiceTransaction);

    // Check if preparation was successful
    if (!$stmt1 || !$stmt2) {
        die("Prepare failed: " . $conn->error);
    }

    // Bind parameters
    $stmt1->bind_param("si", $date_completed, $transaction_id);
    $stmt2->bind_param("i", $transaction_id);

    // Execute queries
    if ($stmt1->execute() && $stmt2->execute()) {
        $_SESSION["success"] = "Task marked as completed successfully.";
    } else {
        $_SESSION["error"] = "Error updating task: " . $conn->error;
    }

    // Close statements and connection
    $stmt1->close();
    $stmt2->close();
    $conn->close();

    // Redirect back
    header("Location: ../scheduled-page.php");
    exit();
} else {
    $_SESSION["error"] = "Invalid request.";
    header("Location: ../scheduled-page.php");
    exit();
}
