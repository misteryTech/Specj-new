<?php
include("../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = $_POST['product_id'];
    $batch_group = $_POST['batch_group'];

    // Update stock condition to "expired"
    $sql = "UPDATE stocks SET `condition` = 'expired' WHERE product_id = ? AND batch_group = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $product_id, $batch_group);

    if ($stmt->execute()) {
        header("Location: ../expired-list.php");
        exit();
    } else {
        header("Location: ../expired-list.php");
        exit();
    }
}
?>
