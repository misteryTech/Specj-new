<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loginIdentifier = $_POST['loginIdentifier'] ?? '';
    $password = $_POST['password'] ?? '';

    // Prepare and bind the SQL statement to check for username or email
    $stmt = $conn->prepare("
        SELECT id, firstname, lastname, username, email, role, password
        FROM users
        WHERE username = ? OR email = ?
    ");
    $stmt->bind_param("ss", $loginIdentifier, $loginIdentifier);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the provided password against the hashed password in the database
        if ($password === $user['password']) { // Replace with password_verify if using hashed passwords
            // Set session variables
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname'] = $user['lastname'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            // Redirect based on user role
            if ($user['role'] === 'admin') {
                header("Location: ../admin/dashboard.php"); // Admin dashboard
            } else {
                header("Location: ../user/dashboard.php"); // User dashboard
            }
            exit();
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href = '../login.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href = '../customer_login.php';</script>";
        exit();
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>
