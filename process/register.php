<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Additional fields
    $role = $_POST['role'] ?? 'user'; // Default role as 'user'
    $archive = $_POST['archive'] ?? 0; // Default archive as 0 (not archived)
    $confirm = $_POST['confirm'] ?? 0; // Default confirm as 0 (not confirmed)

    // Secure the password (hashing for security)


    // Prepare and bind the statement
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, username, password, role, archive, confirm) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssii", $firstname, $lastname, $email, $username, $password, $role, $archive, $confirm);

    // Execute the query
    if ($stmt->execute()) {
        echo "User successfully registered.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
