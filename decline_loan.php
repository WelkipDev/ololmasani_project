<?php
// decline_loan.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the application ID from the URL
$application_id = $_GET['id'];

// Update the status of the application to "Declined"
$sql = "UPDATE loan_applications SET status='Declined' WHERE id=$application_id";

if ($conn->query($sql) === TRUE) {
    echo "Application declined successfully.";
} else {
    echo "Error updating record: " . $conn->error;
}

$conn->close();

// Redirect back to the view all loans page
header("Location: view_all_loans.php");
exit();
?>