<?php

    // Database connection (replace with your DB credentials)
    $conn = new mysqli('localhost', 'root', '', 'specj-new');

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    ?>