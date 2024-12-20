<?php
// Include database connection
include("../connection.php"); // Replace with your actual DB connection file

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $service_name = $_POST['service_name'];
    $service_type = $_POST['service_type']; // 'Motorcycle' is the default value

    $category = $_POST['category'];
    $price = $_POST['price'];

    // Prepare the SQL insert query
    $sql = "INSERT INTO motorcycle_services (service_name, service_type, category, price) 
            VALUES (?, ?, ?, ?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters to the statement
        $stmt->bind_param("sssd", $service_name, $service_type, $category, $price);

        // Execute the statement
        if ($stmt->execute()) {
           
        echo "<script>alert('Registration Successful.');</script>";
        echo "<script>window.location.href='../services.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Error preparing the statement: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>
