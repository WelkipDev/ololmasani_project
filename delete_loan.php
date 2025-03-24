<?php
// delete_loan.php

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

// Delete the application from the database
$sql = "DELETE FROM loan_applications WHERE id = $application_id";

if ($conn->query($sql) === TRUE) {
    echo "<script>
            alert('Application deleted successfully.');
            window.location.href = 'loan_form.html';
          </script>";
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>