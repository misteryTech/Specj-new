<?php
include("../connection.php");
session_start();

// Check if the user is logged in by verifying the session
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$transaction = "Online";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedServices = json_decode($_POST['selectedServices'], true);

    // Validation: Check if no services are selected
    if (empty($selectedServices)) {
        echo "<script>alert('No services selected. Please select at least one service to proceed.');</script>";
        echo "<script>window.location.href='../services-list.php';</script>";
        exit();
    }

    $conn->begin_transaction();

    try {
        $totalAmount = 0;

        // Calculate total amount and validate services
        foreach ($selectedServices as $serviceId) {
            $serviceSql = "SELECT price FROM motorcycle_services WHERE id = ?";
            $stmt = $conn->prepare($serviceSql);
            $stmt->bind_param("i", $serviceId);
            $stmt->execute();
            $stmt->bind_result($price);

            if (!$stmt->fetch()) {
                throw new Exception("Invalid service ID: $serviceId");
            }

            $totalAmount += $price;
            $stmt->close();
        }

        // Insert transaction details
        $transactionSql = "INSERT INTO transactions (user_id, firstname, lastname, total_amount, created_at, type_transaction) VALUES (?, ?, ?, ?, NOW(), ?)";
        $stmt = $conn->prepare($transactionSql);
        $stmt->bind_param("issds", $userId, $firstname, $lastname, $totalAmount, $transaction);
        $stmt->execute();
        $transactionId = $stmt->insert_id;
        $stmt->close();

        // Insert each selected service into `services_transaction`
        foreach ($selectedServices as $serviceId) {
            $detailSql = "INSERT INTO services_transaction (transaction_id, service_id) VALUES (?, ?)";
            $stmt = $conn->prepare($detailSql);
            $stmt->bind_param("ii", $transactionId, $serviceId);
            $stmt->execute();
            $stmt->close();
        }

        $conn->commit();

        echo "<script>alert('Transaction Successful.');</script>";
        echo "<script>window.location.href='../services-list.php';</script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Transaction failed: " . addslashes($e->getMessage()) . "');</script>";
        echo "<script>window.location.href='../services-list.php';</script>";
    }
}
?>
