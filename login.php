<?php

// Create connection
$conn = new mysqli("localhost", "root", "", "mydb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Hash the password
        $password = md5($password);

        // Prepare and execute the query
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?");
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $role = $user['role'];

            // Redirect based on user role
            if ($role === 'admin') {
                echo "<script>
                        alert('You have logged in as an Admin.');
                        window.location.href = 'view_all_loans.php';
                      </script>";
            } else if ($role === 'user') {
                echo "<script>
                        alert('Login successful! Welcome, User.');
                        window.location.href = 'loan_form.html';
                      </script>";
            } else if ($role === 'applicant') {
                echo "<script>
                        alert('Login successful! Welcome, Applicant.');
                        window.location.href = 'loan_form.html';
                      </script>";
            } else {
                echo "<script>
                        alert('Login successful!');
                        window.location.href = 'loan_form.html';
                      </script>";
            }
        } else {
            echo "<script>
                    alert('Invalid email or password.');
                    window.location.href = 'services.html';
                  </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
                alert('Email and password are required.');
                window.location.href = 'services.html';
              </script>";
    }
} else {
    echo "<script>
            alert('Invalid request method.');
            window.location.href = 'services.html';
          </script>";
}

$conn->close();
?>

