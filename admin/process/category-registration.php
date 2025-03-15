<?php
// Include database connection
include("../connection.php"); // Replace with your actual DB connection file

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $category_name = $_POST['category_name'];


    // Prepare the SQL insert query
    $sql = "INSERT INTO category (category_name) 
            VALUES (?)";

    // Prepare the statement
    if ($stmt = $conn->prepare($sql)) {
        // Bind the parameters to the statement
        $stmt->bind_param("s", $category_name);

        // Execute the statement
        if ($stmt->execute()) {
           
        echo "<script>alert('Category Inserted Successfully.');</script>";
        echo "<script>window.location.href='../category.php';</script>";
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
