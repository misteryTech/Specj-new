<?php
include("../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $parts_number = $_POST['parts_number'];
    $batch_group = $_POST['batch_group'];
    $price = $_POST['price'];
    $unit = $_POST['unit'];
    $condition = $_POST['condition'];
    $stock = $_POST['stock'];
    $reorder_point = $_POST['reorder_point'];
    $date_expired = $_POST['date_expired'];

    $sql = "INSERT INTO stocks (product_id, parts_number, batch_group, price, unit, `condition`, stock, reorder_point, date_expired) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssdsssis", $product_id, $parts_number, $batch_group, $price, $unit, $condition, $stock, $reorder_point, $date_expired);

    if ($stmt->execute()) {
        header("Location: ../product_details.php?batch_number=$product_id");
        exit();
    } else {
        header("Location: ../product_details.php?batch_number='$product_id'");
        exit();
    }
}
?>
