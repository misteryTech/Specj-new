<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Detect if running locally or on the server
$is_local = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']);

// Define database credentials only if not already defined
if (!defined('DB_HOST')) {
    define('DB_HOST', $is_local ? 'localhost' : 'localhost'); // Update for online host if needed
}
if (!defined('DB_USER')) {
    define('DB_USER', $is_local ? 'root' : 'u499793037_specjgarage');
}
if (!defined('DB_PASS')) {
    define('DB_PASS', $is_local ? '' : 'm5P#nZJ$dPZ#');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', $is_local ? 'specj-new' : 'u499793037_specjgarage');
}

// Create MySQL connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("❌ Database Connection Failed: " . $conn->connect_error);
}

// Optional: Uncomment to confirm connection
// echo "✅ Connected to " . ( $is_local ? "Local" : "Online" ) . " Database";

?>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Detect if running locally or on the server
$is_local = in_array($_SERVER['HTTP_HOST'], ['localhost', '127.0.0.1']);

// Define database credentials only if not already defined
if (!defined('DB_HOST')) {
    define('DB_HOST', $is_local ? 'localhost' : 'localhost'); // Update for online host if needed
}
if (!defined('DB_USER')) {
    define('DB_USER', $is_local ? 'root' : 'u499793037_specjgarage');
}
if (!defined('DB_PASS')) {
    define('DB_PASS', $is_local ? '' : 'm5P#nZJ$dPZ#');
}
if (!defined('DB_NAME')) {
    define('DB_NAME', $is_local ? 'specj-new' : 'u499793037_specjgarage');
}

// Create MySQL connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Check connection
if ($conn->connect_error) {
    die("❌ Database Connection Failed: " . $conn->connect_error);
}

// Optional: Uncomment to confirm connection
// echo "✅ Connected to " . ( $is_local ? "Local" : "Online" ) . " Database";

?>
