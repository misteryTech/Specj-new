<?php
include("../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $service_id = $_POST['service_id'];
    $service_name = $_POST['service_name'];
    $category = $_POST['edit_category'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("UPDATE motorcycle_services SET service_name=?, category=?, price=? WHERE id=?");
    $stmt->bind_param("ssdi", $service_name, $category, $price, $service_id);

    if ($stmt->execute()) {
        echo "<script>alert('Service updated successfully'); window.location.href='../services.php';</script>";
    } else {
        echo "<script>alert('Error updating service'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
