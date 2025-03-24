<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check Application Status</title>
    <link rel="stylesheet" href=".vscode/styles.css">
     <script src="moita.js" type="text/javascript"></script>
    <!-- Add your favicon here -->
    <link rel="icon" href="images/urlicon.ico" type="image/x-icon">
</head>

<body>
    <div class="header-menu-container">
        <div class="header1">
            <img src="images/Logo2.png" alt="LOGO">
        </div>

        <div class="menu">
            <ul>
                <a href="index.html">Home</a> 
                <a href="about.html">About Us</a> 
                <a href="services.html">Services</a> 
                <a href="downloads.html">Downloads</a> 
                <a href="contact.html">Contact Us</a> 
                <a href="help.html">Help</a> 
                <a href="logout.php">Logout</a>
            </ul>

        </div>
    </div>


    <div class="form-container">
        <h2>Check Application Status</h2>
        <form action="check_status.php" method="post">
            <label for="id">ID Number</label>
            <input type="text" id="id_no" name="id_no" required>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" required>
            <button type="submit">Check Status</button>
        </form>
    </div>

    <div class="result-container">
        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['id_no']) && isset($_POST['name'])) {
                $id_no = $_POST['id_no'];
                $fullname = $_POST['name'];

                // Database connection
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "mydb";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Retrieve the application details from the database
                $sql = "SELECT * FROM loan_applications WHERE id_no = ? AND name = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $id_no, $fullname);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<div class='table-container'>";
                    echo "<table>";
                    echo "<tr><th>ID_Number</th><th>Station</th><th>Loaning Date</th><th>Refund Date</th><th>Location</th><th>Sub-Location</th><th>Name</th><th>Village</th><th>ID No</th><th>Marital Status</th><th>Phone No</th><th>Occupation</th><th>Family</th><th>Loan Applied</th><th>Loan in Words</th><th>1 Week Pay</th><th>2 Weeks Pay</th><th>Securities</th><th>Securities Particulars</th><th>Loan Purpose</th><th>Guarantor Name</th><th>Guarantor ID</th><th>Guarantor Phone</th><th>Guarantor Sign</th><th>Deponent Name</th><th>Deponent Address</th><th>Deponent ID</th><th>Deponent Sign</th><th>Sworn At</th><th>Sworn Date</th><th>Commissioner for Oaths</th><th>Status</th></tr>";
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['station'] . "</td>";
                        echo "<td>" . $row['loaning_date'] . "</td>";
                        echo "<td>" . $row['refund_date'] . "</td>";
                        echo "<td>" . $row['location'] . "</td>";
                        echo "<td>" . $row['sub_location'] . "</td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['village'] . "</td>";
                        echo "<td>" . $row['id_no'] . "</td>";
                        echo "<td>" . $row['marital_status'] . "</td>";
                        echo "<td>" . $row['phone_no'] . "</td>";
                        echo "<td>" . $row['occupation'] . "</td>";
                        echo "<td>" . $row['family'] . "</td>";
                        echo "<td>" . $row['loan_applied'] . "</td>";
                        echo "<td>" . $row['loan_in_words'] . "</td>";
                        echo "<td>" . $row['one_week_pay'] . "</td>";
                        echo "<td>" . $row['two_weeks_pay'] . "</td>";
                        echo "<td>" . $row['securities'] . "</td>";
                        echo "<td>" . $row['securities_particulars'] . "</td>";
                        echo "<td>" . $row['loan_purpose'] . "</td>";
                        echo "<td>" . $row['guarantor_name'] . "</td>";
                        echo "<td>" . $row['guarantor_id'] . "</td>";
                        echo "<td>" . $row['guarantor_phone'] . "</td>";
                        echo "<td>" . $row['guarantor_sign'] . "</td>";
                        echo "<td>" . $row['deponent_name'] . "</td>";
                        echo "<td>" . $row['deponent_address'] . "</td>";
                        echo "<td>" . $row['deponent_id'] . "</td>";
                        echo "<td>" . $row['deponent_sign'] . "</td>";
                        echo "<td>" . $row['sworn_at'] . "</td>";
                        echo "<td>" . $row['sworn_date'] . "</td>";
                        echo "<td>" . $row['commissioner_oaths'] . "</td>";
                         echo "<td>" . $row['status'] . "</td>";
                        echo "</tr>";
                    }
                    echo "</table>";
                    echo "</div>";
                } else {
                    echo "<p>No application found with the provided email and full name.</p>";
                }

                $stmt->close();
                $conn->close();
            } else {
                echo "<p>Please enter both email and full name.</p>";
            }
        }
        ?>
    </div>
<div class="mission">
            
                <h2>OUR MISSION</h2>
                <p>Our mission is to provide financial services to underserved communities,
                    supporting economic growth and financial inclusion.</p>
            </div>
    <div class="footer">
        <address>
            <h2 id="contact">CONTACT US:</h2>
            <p id="contact">Ololmasani Capital Limited | Ololmasani Takitech Centre, Narok County, Kenya | P.O. Box
                13 - 20404, Ndanai | Email: olmf@gmail.com</p>
        </address>
    </div>
</body>

</html>