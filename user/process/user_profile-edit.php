<?php
include("../connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $customer_id = $_POST['customer_id'];
    $editFirstname = $_POST['edit_firstname'];
    $editLastname = $_POST['edit_lastname'];
    $edit_email = $_POST['edit_email'];
    $edit_username = $_POST['edit_username'];
    $edit_password = $_POST['edit_password'];

    $stmt = $conn->prepare("UPDATE users SET firstname = ?, lastname = ?, email =? , username = ?, password = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $editFirstname, $editLastname, $edit_email, $edit_username, $edit_password, $customer_id);

    if ($stmt->execute()) {


        echo"<script>alert('Successfully Edit Customer');</script>";
        echo"<script>window.location.href='../profile.php'</script>";

    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
