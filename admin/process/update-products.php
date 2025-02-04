<?php
include("../connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $part_id = trim($_POST['part_id']);
    $edit_name = trim($_POST['edit_name']);
    $edit_parts_number = trim($_POST['edit_parts_number']);
    $edit_date_expired = trim($_POST['edit_date_expired']);
    $edit_category = trim($_POST['edit_category']);
    $edit_manufacturer = trim($_POST['edit_manufacturer']);
    $edit_condition = trim($_POST['edit_condition']);
    $edit_quantity_stock = trim($_POST['edit_quantity_stock']);
    $edit_reorder_point = trim($_POST['edit_reorder_point']);
    $edit_price = trim($_POST['edit_price']);

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("UPDATE parts_registration 
                            SET parts_name=?, parts_number=?, date_expired=?, category=?, 
                                manufacturer=?, `condition`=?, quantity_stock=?, reorder_point=?, price=? 
                            WHERE id=?");

    $stmt->bind_param("ssssssiiii", 
                      $edit_name, $edit_parts_number, $edit_date_expired, $edit_category, 
                      $edit_manufacturer, $edit_condition, $edit_quantity_stock, $edit_reorder_point, 
                      $edit_price, $part_id);

    if ($stmt->execute()) {
        echo "<script>alert('Part updated successfully'); window.location.href='../product-list.php';</script>";
    } else {
        echo "<script>alert('Error updating part'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
