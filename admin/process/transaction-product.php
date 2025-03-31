<?php
include("../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'] ?? '';
    $last_name = $_POST['last_name'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $purchase_date = $_POST['schedule'] ?? '';
    $total_price = $_POST['total_price'] ?? '0'; 
    $transaction_type = $_POST['product_transaction'] ?? '';

    // Decode the selected products JSON
    $selectedProducts = json_decode($_POST['selectedproduct'], true);

    if (!$selectedProducts || count($selectedProducts) === 0) {
        echo "<script>alert('Error: No products selected.'); window.history.back();</script>";
        exit();
    }

    try {
        $conn->autocommit(false); // Begin Transaction

        // Insert into transactions table
        $stmt = $conn->prepare("INSERT INTO transactions (firstname, lastname, mobileno, date_completed, total_amount, type_transaction) 
                                VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssds", $first_name, $last_name, $mobile, $purchase_date, $total_price, $transaction_type);
        $stmt->execute();
        $transaction_id = $conn->insert_id; // Get last inserted ID

        // Insert transaction items
        $stmt_product = $conn->prepare("INSERT INTO transaction_items (transaction_id, product_id, batch_group, quantity, price, subtotal) 
                                        VALUES (?, ?, ?, ?, ?, ?)");
        $stmt_update_stock = $conn->prepare("UPDATE stocks SET stock = stock - ? WHERE product_id = ? AND batch_group = ?");

        foreach ($selectedProducts as $product) {
            if (!isset($product['id']) || empty($product['id'])) {
                throw new Exception("Error: Product ID is missing.");
            }

            foreach ($product['batches'] as $batch) {
                // Validate stock before deducting
                $stockCheckSql = "SELECT stock FROM stocks WHERE product_id = ? AND batch_group = ?";
                $stmt_check_stock = $conn->prepare($stockCheckSql);
                $stmt_check_stock->bind_param("ss", $product['id'], $batch['batch_group']);
                $stmt_check_stock->execute();
                $result = $stmt_check_stock->get_result();

                if ($result->num_rows === 0) {
                    throw new Exception("Error: Stock not found for product ID " . $product['id']);
                }

                $row = $result->fetch_assoc();
                if ($row['stock'] < $batch['quantity']) {
                    throw new Exception("Error: Insufficient stock for product ID " . $product['id']);
                }

                // Insert into transaction_items table
                $stmt_product->bind_param("issidd", $transaction_id, $product['id'], $batch['batch_group'], $batch['quantity'], $batch['price'], $batch['subtotal']);
                $stmt_product->execute();

                // Update stock table
                $stmt_update_stock->bind_param("iss", $batch['quantity'], $product['id'], $batch['batch_group']);
                $stmt_update_stock->execute();
            }
        }

        $conn->commit(); // Commit transaction

        echo "<script>
                alert('Transaction successful! Stocks have been released.');
                window.location.href = '../walkin-product1.php';
              </script>";
    } catch (Exception $e) {
        $conn->rollback(); // Rollback transaction on error
        echo "<script>alert('Error: " . $e->getMessage() . "'); window.history.back();</script>";
    }
}
?>
