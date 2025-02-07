<?php
include("../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize the ID

    // Update the status to "archived"
    $stmt = $conn->prepare("UPDATE parts_registration SET archive = '0' WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Product Restored successfully'); window.location.href='../archive-product.php';</script>";
    } else {
        echo "<script>alert('Error restring Product'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "<script>alert('Invalid request'); window.history.back();</script>";
}
?>
