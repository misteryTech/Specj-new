<?php
include("../connection.php");

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    // Get form data
    $parts_name = $_POST["parts_name"];
    $parts_number = $_POST["parts_number"];
    $category = $_POST["category"];
    $manufacturer = $_POST["manufacturer"];
    $price = $_POST["price"];
    $quantity_stock = $_POST["quantity_stock"];
    $status = $_POST["condition"];
    $services_type = $_POST["services_type"];
    $date_expired = $_POST["date_expired"];
    $reorder_point = $_POST["reorder_point"];
    $unit = $_POST["unit"];
    $archived = "0"; // Default archive status

    // Handle image upload (optional)
    $target_file = null;
    
    if (isset($_FILES["parts_image"]) && $_FILES["parts_image"]["error"] == 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["parts_image"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is an actual image or fake image
        $check = getimagesize($_FILES["parts_image"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            echo "<script>alert('File is not an image.');</script>";
            $uploadOk = 0;
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "<script>alert('Sorry, file already exists.');</script>";
            echo "<script>window.location.href='../product-registration.php';</script>";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["parts_image"]["size"] > 500000000) {
            echo "<script>alert('Sorry, your file is too large.');</script>";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            echo "<script>alert('Sorry, only JPG, JPEG, PNG & GIF files are allowed.');</script>";
            echo "<script>window.location.href='../product-registration.php';</script>";
            $uploadOk = 0;
        }

        // If the image passes all checks, move it to the target directory
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["parts_image"]["tmp_name"], $target_file)) {
                // Image successfully uploaded
            } else {
                echo "<script>alert('Sorry, there was an error uploading your file.');</script>";
            }
        }
    } else {
        // If no image is uploaded, set a default value (optional, can be NULL or empty)
        $target_file = null; // or $target_file = 'default-image.jpg' if you want a default image
    }

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO parts_registration(parts_name, parts_number, category, manufacturer, price, quantity_stock, services_type, `condition`, image, date_expired, unit, archive, reorder_point) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdisssssss", $parts_name, $parts_number, $category, $manufacturer, $price, $quantity_stock, $services_type, $status, $target_file, $date_expired, $unit, $archived, $reorder_point);

    if ($stmt->execute()) {
        // Log the product registration
        $log_action = 'registration';  // Action can be 'registration' or 'instocking'
        $log_stmt = $conn->prepare("INSERT INTO product_logs(parts_name, parts_number, quantity_stock, status, action) VALUES (?, ?, ?, ?, ?)");
        $log_stmt->bind_param("ssiss", $parts_name, $parts_number, $quantity_stock, $status, $log_action);
        $log_stmt->execute();

        echo "<script>alert('Registration Successful.');</script>";
        echo "<script>window.location.href='../product-registration.php';</script>";
    } else {
        echo "<script>alert('Failed to register.');</script>";
    }

    // Close the statement
    $stmt->close();
    $log_stmt->close();
}

// Close the database connection
$conn->close();
?>
