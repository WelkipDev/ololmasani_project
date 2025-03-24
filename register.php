<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['village']) && isset($_POST['gender']) && isset($_POST['phone']) && isset($_POST['role']) && isset($_POST['password']) && isset($_POST['confirmpassword'])) {
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $village = $_POST['village'];
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $role = $_POST['role'];
        $password = $_POST['password'];
        $confirmpassword = $_POST['confirmpassword'];

        // Check if passwords match
        if ($password !== $confirmpassword) {
            echo "<script>
                    alert('Passwords do not match.');
                    window.location.href = 'sign-up.html';
                  </script>";
            exit();
        }

        // Hash the password
        $password = password_hash($password, PASSWORD_BCRYPT);

        // Check if the email or phone number already exists
        $check_sql = "SELECT * FROM users WHERE email = ? OR phone = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ss", $email, $phone);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email or phone number already exists
            echo "<script>
                    alert('A user with the provided email or phone number already exists.');
                    window.location.href = 'sign-up.html';
                  </script>";
        } else {
            // Insert the form data into the database
            $sql = "INSERT INTO users (firstname, lastname, email, village, gender, phone, role, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssssss", $firstname, $lastname, $email, $village, $gender, $phone, $role, $password);

            if ($stmt->execute()) {
                echo "<script>
                        alert('Registration successful!');
                        window.location.href = 'services.html';
                      </script>";
            } else {
                echo "<script>
                        alert('Registration failed. Please try again.');
                        window.location.href = 'sign-up.html';
                      </script>";
            }
        }

        $stmt->close();
    } else {
        echo "<script>
                alert('All fields are required.');
                window.location.href = 'sign-up.html';
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid request method.');
            window.location.href = 'sign-up.html';
          </script>";
}

$conn->close();
?>
