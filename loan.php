<?php
// loan.php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form data
$idnumber = $_POST['id_number'];
$name = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$amount = $_POST['amount'];
$purpose = $_POST['purpose'];
$status = 'Pending'; // Default status

// Check if the ID number or email already exists
$check_sql = "SELECT * FROM applications WHERE id_number = ? OR email = ?";
$stmt = $conn->prepare($check_sql);
$stmt->bind_param("ss", $idnumber, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // ID number or email already exists
    
    echo "
    <script>
                    alert('An application with the provided ID number or email already exists.');
                    window.location.href = 'loan_form.html';
                  </script>";

} else {
    // Insert the form data into the database
    $sql = "INSERT INTO applications (id_number, full_name, email, phone_number, loan_amount, purpose, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssss", $idnumber, $name, $email, $phone, $amount, $purpose, $status);

    if ($stmt->execute()) {
        // Redirect to the status page with the application ID
        $application_id = $stmt->insert_id;
        header("Location: loan_status.php?id=$application_id");
    } else {
        echo "Error: " . $stmt->error;
    }
}

$stmt->close();
$conn->close();
?>