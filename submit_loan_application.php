<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set parameters
$station = $_POST['station'];
$loaning_date = $_POST['loaning_date'];
$refund_date = $_POST['refund_date'];
$location = $_POST['location'];
$sub_location = $_POST['sub_location'];
$name = $_POST['name'];
$village = $_POST['village'];
$id_no = $_POST['id_no'];
$marital_status = $_POST['marital_status'];
$phone_no = $_POST['phone_no'];
$occupation = $_POST['occupation'];
$family = $_POST['family'];
$loan_applied = $_POST['loan_applied'];
$loan_in_words = $_POST['loan_in_words'];
$one_week_pay = $_POST['one_week_pay'];
$two_weeks_pay = $_POST['two_weeks_pay'];
$securities = $_POST['securities'];
$securities_particulars = $_POST['securities_particulars'];
$loan_purpose = $_POST['loan_purpose'];
$guarantor_name = $_POST['guarantor_name'];
$guarantor_id = $_POST['guarantor_id'];
$guarantor_phone = $_POST['guarantor_phone'];
$guarantor_sign = $_POST['guarantor_sign'];
$deponent_name = $_POST['deponent_name'];
$deponent_address = $_POST['deponent_address'];
$deponent_id = $_POST['deponent_id'];
$deponent_sign = $_POST['deponent_sign'];
$sworn_at = $_POST['sworn_at'];
$sworn_date = $_POST['sworn_date'];
$commissioner_oaths = $_POST['commissioner_oaths'];
$status = 'Pending'; // Default status

// Check if ID number or phone number already exists
$check_query = $conn->prepare("SELECT id FROM loan_applications WHERE id_no = ? OR phone_no = ?");
$check_query->bind_param("ss", $id_no, $phone_no);
$check_query->execute();
$check_query->store_result();

if ($check_query->num_rows > 0) {
    echo "Error: A record with this ID number or phone number already exists.";
} else {
    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO loan_applications (station, loaning_date, refund_date, location, sub_location, name, village, id_no, marital_status, phone_no, occupation, family, loan_applied, loan_in_words, one_week_pay, two_weeks_pay, securities, securities_particulars, loan_purpose, guarantor_name, guarantor_id, guarantor_phone, guarantor_sign, deponent_name, deponent_address, deponent_id, deponent_sign, sworn_at, sworn_date, commissioner_oaths,status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?)");
    $stmt->bind_param("sssssssssssssssssssssssssssssss", $station, $loaning_date, $refund_date, $location, $sub_location, $name, $village, $id_no, $marital_status, $phone_no, $occupation, $family, $loan_applied, $loan_in_words, $one_week_pay, $two_weeks_pay, $securities, $securities_particulars, $loan_purpose, $guarantor_name, $guarantor_id, $guarantor_phone, $guarantor_sign, $deponent_name, $deponent_address, $deponent_id, $deponent_sign, $sworn_at, $sworn_date, $commissioner_oaths,$status);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to the status page with the application ID
        $application_id = $stmt->insert_id;
        header("Location: loan_status.php?id=$application_id");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$check_query->close();
$conn->close();
?>