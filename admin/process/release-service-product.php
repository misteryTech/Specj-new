<?php
include("../connection.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$firstname = $_SESSION['firstname'];
$lastname = $_SESSION['lastname'];
$transaction = "Online";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedproduct = json_decode($_POST['selectedproduct'], true);
    $product_transaction = $_POST['product_transaction'];
    $services_id =  $_POST["services_id"];

    // Validation: Check if no products are selected
    if (empty($selectedproduct)) {
        echo "<script>alert('No product selected. Please select at least one product to proceed.');</script>";
        echo "<script>window.location.href='../product-list.php';</script>";
        exit();
    }

    // Begin transaction
    $conn->begin_transaction();

    try {
        $totalAmount = 0;

        // Calculate total amount and validate products
        foreach ($selectedproduct as $product) {
            $productId = $product['productId'];
            $quantity = $product['quantity'];

            $productQuery = "SELECT price FROM parts_registration WHERE id = ?";
            $stmt = $conn->prepare($productQuery);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $stmt->bind_result($price);

            if (!$stmt->fetch()) {
                throw new Exception("Invalid product ID: $productId");
            }

            $totalAmount += $price * $quantity;
            $stmt->close();
        }

        // Insert transaction details
        $transactionQuery = "INSERT INTO transactions (user_id, firstname, lastname, total_amount, created_at, type_transaction, transaction) 
                             VALUES (?, ?, ?, ?, NOW(), ?, ?)";
        $stmt = $conn->prepare($transactionQuery);
        $stmt->bind_param("issdss", $userId, $firstname, $lastname, $totalAmount, $transaction, $product_transaction);
        $stmt->execute();
        $transactionId = $stmt->insert_id;
        $stmt->close();

        // Insert each selected product into `product_transaction`
        foreach ($selectedproduct as $product) {
            $productId = $product['productId'];
            $quantity = $product['quantity'];

            $detailQuery = "INSERT INTO product_transaction (transaction_id, product_id, quantity, service_id) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($detailQuery);
            $stmt->bind_param("iiii", $transactionId, $productId, $quantity, $services_id);
            $stmt->execute();
            $stmt->close();
        }

        // Commit the transaction
        $conn->commit();

        echo "<script>alert('Transaction Successful.');</script>";
        echo "<script>window.location.href='../products-list.php';</script>";
    } catch (Exception $e) {
        // Rollback the transaction on failure
        $conn->rollback();
        echo "<script>alert('Transaction failed: " . addslashes($e->getMessage()) . "');</script>";
        echo "<script>window.location.href='../products-list.php';</script>";
    }
}
?>
