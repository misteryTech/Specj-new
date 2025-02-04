<?php
include("../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parts_id = $_POST['parts_id'];
    $stocks = $_POST['stocks'];
    $stocks_added = $_POST['stocks_added'];

    $total_stocks = $stocks + $stocks_added ;


    $stmt = $conn->prepare("UPDATE parts_registration SET quantity_stock=? WHERE id=?");
    $stmt->bind_param("si", $total_stocks, $parts_id);

    if ($stmt->execute()) {
        echo "<script>alert('Stocks updated successfully'); window.location.href='../product-list.php';</script>";
    } else {
        echo "<script>alert('Error updating service'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
