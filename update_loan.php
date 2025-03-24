<?php
// update_loan.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the ID and data from the POST request
$id = $_POST['id'];
$data = json_decode($_POST['data'], true);

// Update the application details in the database
$sql = "UPDATE loan_applications SET 
    full_name = ?, 
    email = ?, 
    phone_number = ?, 
    loan_amount = ?, 
    purpose = ?, 
    status = ? 
    WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "ssssssi",
    $data['full_name'],
    $data['email'],
    $data['phone_number'],
    $data['loan_amount'],
    $data['purpose'],
    $data['status'],
    $id
);

if ($stmt->execute()) {
    echo "Success";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>