<?php
include("../connection.php");
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

$transaction = "Walkin";
$status = "Released";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selectedproduct = json_decode($_POST['selectedproduct'], true);
    $product_transaction = $_POST['product_transaction'];
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $schedule = $_POST['schedule'];
    $status = "Scheduled";

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

        // Calculate total amount, validate products, and update stock
        foreach ($selectedproduct as $product) {
            $productId = $product['productId'];
            $quantity = $product['quantity'];

            // Get product details
            $productQuery = "SELECT price, quantity_stock FROM parts_registration WHERE id = ?";
            $stmt = $conn->prepare($productQuery);
            $stmt->bind_param("i", $productId);
            $stmt->execute();
            $stmt->bind_result($price, $quantity_stock);

            if (!$stmt->fetch()) {
                throw new Exception("Invalid product ID: $productId");
            }
            $stmt->close();

            // Check if enough stock is available
            if ($quantity_stock < $quantity) {
                throw new Exception("Insufficient stock for product ID: $productId");
            }

            // Calculate total amount
            $totalAmount += $price * $quantity;

            // Update stock
            $updateStockQuery = "UPDATE parts_registration SET quantity_stock = quantity_stock - ? WHERE id = ?";
            $stmt = $conn->prepare($updateStockQuery);
            $stmt->bind_param("ii", $quantity, $productId);
            $stmt->execute();
            $stmt->close();
        }

        // Insert transaction details
        $transactionQuery = "INSERT INTO transactions (firstname, lastname, total_amount, created_at, type_transaction, `transaction`) 
                             VALUES (?, ?, ?, NOW(), ?, ?)";
        $stmt = $conn->prepare($transactionQuery);
        $stmt->bind_param("ssdss", $first_name, $last_name, $totalAmount, $transaction, $product_transaction);
        $stmt->execute();
        $transactionId = $stmt->insert_id;
        $stmt->close();

        // Insert each selected product into `product_transaction`
        foreach ($selectedproduct as $product) {
            $productId = $product['productId'];
            $quantity = $product['quantity'];

            $detailQuery = "INSERT INTO product_transaction (transaction_id, product_id, quantity, `status`) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($detailQuery);
            $stmt->bind_param("iiis", $transactionId, $productId, $quantity, $status);
            $stmt->execute();
            $stmt->close();
        }

        // Commit the transaction
        $conn->commit();

        echo "<script>alert('Transaction Successful.');</script>";
        echo "<script>window.location.href='../walkin-product.php';</script>";
    } catch (Exception $e) {
        // Rollback the transaction on failure
        $conn->rollback();
        echo "<script>alert('Transaction failed: " . addslashes($e->getMessage()) . "');</script>";
        echo "<script>window.location.href='../walkin-product.php';</script>";
    }
}
?>
