<?php
include("../connection.php");

if (isset($_GET['id']) && isset($_GET['archive'])) {
    $id = intval($_GET['id']);
    $currentArchiveStatus = intval($_GET['archive']);

    // Toggle archive status
    $newArchiveStatus = ($currentArchiveStatus == 1) ? 0 : 1;

    // Update database
    $stmt = $conn->prepare("UPDATE motorcycle_services SET archive = ? WHERE id = ?");
    $stmt->bind_param("ii", $newArchiveStatus, $id);

    if ($stmt->execute()) {
        // Redirect back to the page after updating
        header("Location: ../services.php?success=1");
        exit();
    } else {
        echo "Error updating archive status.";
    }

    $stmt->close();
}

$conn->close();
?>
