<?php
include("../connection.php");

// Check if the required POST data is present
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'], $_POST['quantity_release'], $_POST['transaction_id'])) {
    $productId = intval($_POST['product_id']);
    $quantityRelease = intval($_POST['quantity_release']);
    $transactionId = intval($_POST['transaction_id']);

    // Ensure valid input
    if ($productId <= 0 || $quantityRelease <= 0 || $transactionId <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
        exit();
    }

    // Get the current stock of the product
    $stockQuery = "SELECT quantity_stock FROM parts_registration WHERE id = ?";
    if ($stmt = $conn->prepare($stockQuery)) {
        $stmt->bind_param("i", $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $product = $result->fetch_assoc();

            if ($product['quantity_stock'] >= $quantityRelease) {
                // Update the stock after releasing the quantity
                $newQuantity = $product['quantity_stock'] - $quantityRelease;
                $updateStockQuery = "UPDATE parts_registration SET quantity_stock = ? WHERE id = ?";
                
                if ($updateStmt = $conn->prepare($updateStockQuery)) {
                    $updateStmt->bind_param("ii", $newQuantity, $productId);
                    $updateStmt->execute();

                    // Update the transaction status
                    $transactionQuery = "UPDATE product_transaction SET status = 'Released' WHERE transaction_id = ? AND product_id = ?";
                    
                    if ($transactionStmt = $conn->prepare($transactionQuery)) {
                        $transactionStmt->bind_param("ii", $transactionId, $productId);
                        $transactionStmt->execute();

                        // Check if the update affected any rows (to ensure transaction was registered)
                        if ($transactionStmt->affected_rows > 0) {
                            echo json_encode(['success' => true, 'message' => 'Product released successfully.']);
                        } else {
                            echo json_encode(['success' => false, 'message' => 'Transaction not registered or already updated.']);
                        }
                    } else {
                        echo json_encode(['success' => false, 'message' => 'Error updating transaction status.']);
                    }

                    $transactionStmt->close();
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error updating stock.']);
                }

                $updateStmt->close();
            } else {
                echo json_encode(['success' => false, 'message' => 'Insufficient stock to release.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid product ID.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error fetching product details.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Missing parameters.']);
}

$conn->close();
?>
