
<?php
// Start the session at the very beginning
session_start();

// Include the database connection
include("../process/connection.php");

// Check if the user is logged in by verifying the session
if (!isset($_SESSION['user_id'])) {
    // If not logged in, redirect to login page
    header("Location: ../login.php");
    exit(); // Stop further execution
}

$username = $_SESSION['username'];
$fullname = $_SESSION['firstname']. ' '. $_SESSION['lastname'];
$role = $_SESSION['role'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Specj Garage</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">
  
  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

 <!-- FullCalendar CSS -->
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />

<!-- FullCalendar JS -->
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
<link href='https://fullcalendar.io/releases/fullcalendar/3.10.2/fullcalendar.min.css' rel='stylesheet' />
<script src='https://fullcalendar.io/releases/fullcalendar/3.10.2/lib/jquery.min.js'></script>
<script src='https://fullcalendar.io/releases/fullcalendar/3.10.2/lib/moment.min.js'></script>
<script src='https://fullcalendar.io/releases/fullcalendar/3.10.2/fullcalendar.min.js'></script>


</head>
<?php
  include("../process/connection.php");
?>
<style>
  .dashboard .out-stock .card-icon {
    color: #ffffff;
    background:rgba(230, 81, 55, 0.62);
}


.dashboard .expired-item .card-icon {
    color:rgb(69, 77, 179);
    background:rgba(230, 81, 55, 0.62);
}
</style>