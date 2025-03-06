<?php
session_start();
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $loginIdentifier = trim($_POST['loginIdentifier'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($loginIdentifier) || empty($password)) {
        echo "<script>alert('Please fill in all fields.'); window.location.href = '../customer_login.php';</script>";
        exit();
    }

    // Prepare and bind the SQL statement to check for username or email
    $stmt = $conn->prepare("
        SELECT id, firstname, lastname, username, email, role, password, archive
        FROM users
        WHERE username = ? OR email = ? 
        LIMIT 1
    ");
    $stmt->bind_param("ss", $loginIdentifier, $loginIdentifier);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password (assuming it's hashed in the database)
        if ($password === $user['password']) {
            if (intval($user['archive']) === 0) {
                // Secure session handling
                session_regenerate_id(true);

                // Store user details in session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['firstname'] = $user['firstname'];
                $_SESSION['lastname'] = $user['lastname'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];

                // Redirect based on user role
                if ($user['role'] === 'admin') {
                    header("Location: ../admin/dashboard.php");
                } else {
                    header("Location: ../user/dashboard.php");
                }
                exit();
            } else {
                echo "<script>alert('You have been marked as an inactive user.'); window.location.href = '../customer_login.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('Incorrect password!'); window.location.href = '../customer_login.php';</script>";
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
