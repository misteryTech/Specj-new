<?php
include("../connection.php"); // Include database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $parts_name = trim($_POST["parts_name"]);
    $manufacturer = $_POST["manufacturer"];
    $category = $_POST["category"];
    $services_type = $_POST["services_type"];
    $description = $_POST["description"];

    // Check if the part already exists
    $stmt = $conn->prepare("SELECT batch_number, slug, image FROM parts_registrations WHERE parts_name = ?");
    $stmt->bind_param("s", $parts_name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        // Part exists, use existing batch_number and slug
        $batch_number = $row["batch_number"];
        $slug = $row["slug"];
        $image = $row["image"]; // Keep existing image
    } else {
        // Part does not exist, generate new batch_number and slug
        $datePart = date("ymd"); // Example: 240319 (Year-Month-Day)
        $randomPart = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 3)); // Random 3-char
        $batch_number = "BATCH-" . $datePart . "-" . $randomPart;
        
        // ✅ Generate slug (first 3 letters + random number)
        $slug = strtoupper(substr($parts_name, 0, 3)) . "-" . rand(1000, 9999);

        // Handle Image Upload
        if (!empty($_FILES["parts_image"]["name"])) {
            $uploadDir = "uploads/";
            $imageFileType = pathinfo($_FILES["parts_image"]["name"], PATHINFO_EXTENSION);
            $imageName = uniqid("IMG_", true) . "." . $imageFileType;
            $imagePath = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES["parts_image"]["tmp_name"], $imagePath)) {
                $image = "uploads/" . $imageName; // Save relative path
            } else {
                $image = "images/default-placeholder.png"; // Default image if upload fails
            }
        } else {
            $image = "images/default-placeholder.png"; // No image uploaded
        }

        // Insert new record
        $insertStmt = $conn->prepare("INSERT INTO parts_registrations (parts_name, slug, batch_number, manufacturer, category, services_type, description, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $insertStmt->bind_param("ssssssss", $parts_name, $slug, $batch_number, $manufacturer, $category, $services_type, $description, $image);
        $insertStmt->execute();
        $insertStmt->close();
    }

    $stmt->close();
    $conn->close();

// Redirect back with success message (use JavaScript alert instead)
echo "<script>
    alert('✅ Product registered successfully!');
    window.location.href = '../product_information.php';
</script>";
exit();

}
?>
