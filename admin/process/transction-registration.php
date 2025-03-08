<?php
include("../connection.php");
session_start();

// Check if the user is logged in by verifying the session
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: ../login.php");
    exit();
}

$transaction = "Walkin";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedServices = json_decode($_POST['selectedServices'], true);
    $product_transaction = $_POST['product_transaction'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $schedule = $_POST['schedule'];
    $status = "Scheduled";

    // Validation: Check if no services are selected
    if (empty($selectedServices)) {
        echo "<script>alert('No services selected. Please select at least one service to proceed.');</script>";
        echo "<script>window.location.href='../services-list.php';</script>";
        exit();
    }

    $conn->begin_transaction();

    try {
        $totalAmount = 0;

        // Step 1: Check and calculate the total amount for selected services
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

        // Step 2: Check if the user exists, or create a new user
        $userId = null;
        $checkUserSql = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($checkUserSql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($userId);

        if (!$stmt->fetch()) {
            // If user does not exist, register the user
            $stmt->close();

            $registerUserSql = "INSERT INTO users (firstname, lastname, email, created_at, username) VALUES (?, ?, ?, NOW(), ?)";
            $stmt = $conn->prepare($registerUserSql);
            $stmt->bind_param("ssss", $first_name, $last_name, $email, $email);
            $stmt->execute();
            $userId = $stmt->insert_id;
        }
        $stmt->close();

        // Step 3: Insert transaction details
        $transactionSql = "INSERT INTO transactions (user_id, firstname, lastname, total_amount, created_at, type_transaction, `transaction`, `status`) VALUES (?, ?, ?, ?, NOW(), ?, ?, ?)";
        $stmt = $conn->prepare($transactionSql);
        $stmt->bind_param("issdsss", $userId, $first_name, $last_name, $totalAmount, $transaction, $product_transaction, $status);
        $stmt->execute();
        $transactionId = $stmt->insert_id;
        $stmt->close();

        // Step 4: Insert each selected service into `services_transaction`
        foreach ($selectedServices as $serviceId) {
            $detailSql = "INSERT INTO services_transaction (transaction_id, service_id, set_schedule,`status`) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($detailSql);
            $stmt->bind_param("iiss", $transactionId, $serviceId, $schedule, $status);
            $stmt->execute();
            $stmt->close();
        }

        $conn->commit();

        echo "<script>alert('Transaction Successful.');</script>";
        echo "<script>window.location.href='../walkin-service.php';</script>";
    } catch (Exception $e) {
        $conn->rollback();
        echo "<script>alert('Transaction failed: " . addslashes($e->getMessage()) . "');</script>";
        echo "<script>window.location.href='../walkin-service.php';</script>";
    }
}
?>
