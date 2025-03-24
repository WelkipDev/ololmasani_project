<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loan Status</title>
    <link rel="stylesheet" href=".vscode/styles.css">
     <script src="moita.js" type="text/javascript"></script>
    <!-- Add your favicon here -->
    <link rel="icon" href="images/urlicon.ico" type="image/x-icon">
    <script>
        function makeEditable(row) {
            const cells = row.querySelectorAll('td[data-editable="true"]');
            cells.forEach(cell => {
                const input = document.createElement('input');
                input.type = 'text';
                input.value = cell.innerText;
                cell.innerHTML = '';
                cell.appendChild(input);
            });
            row.querySelector('.edit-btn').style.display = 'none';
            row.querySelector('.save-btn').style.display = 'inline';
        }

        function saveChanges(row, id) {
            const cells = row.querySelectorAll('td[data-editable="true"]');
            const data = {};
            cells.forEach(cell => {
                const input = cell.querySelector('input');
                data[cell.getAttribute('data-field')] = input.value;
                cell.innerHTML = input.value;
            });

            // Send the updated data to the server
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'update_loan.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert('Changes saved successfully.');
                } else {
                    alert('An error occurred while saving changes.');
                }
            };
            xhr.send('id=' + id + '&data=' + JSON.stringify(data));

            row.querySelector('.edit-btn').style.display = 'inline';
            row.querySelector('.save-btn').style.display = 'none';
        }
    </script>
</head>

<body>
    <div class="header-menu-container">
        <div class="header1">
            <a href="index.html">
                <img src="images/Logo2.png" alt="LOGO">
            </a>
            </div>

        <div class="menu">
            <ul>
                <li class="menu-item">
                    <a href="index.html">Home</a>

                </li>
                <li class="menu-item">
                    <a href="about.html">About Us</a>

                </li>
                <li class="menu-item">
                    <a href="services.html">Services</a>

                </li>
                <li class="menu-item">
                    <a href="downloads.html">Downloads</a>

                </li>
                <li class="menu-item">
                    <a href="contact.html">Contact Us</a>

                </li>
                <li class="menu-item">
                    <a href="help.html">Help</a>

                </li>
            </ul>
        </div>
    </div>

    <div class="form-container1">
        <h2>Loan Application Status</h2>
        <p>Your loan application has been submitted successfully. We will review your application and get back to you soon.</p>
        <h3>Application Details:</h3>

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

        // Get the application ID from the URL
        $application_id = $_GET['id'];

        // Retrieve the application details from the database
        $sql = "SELECT * FROM loan_applications WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $application_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Output the application details in a table format
            echo "<div class='table-container'>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Station</th><th>Loaning Date</th><th>Refund Date</th><th>Location</th><th>Sub-Location</th><th>Name</th><th>Village</th><th>ID No</th><th>Marital Status</th><th>Phone No</th><th>Occupation</th><th>Family</th><th>Loan Applied</th><th>Loan in Words</th><th>1 Week Pay</th><th>2 Weeks Pay</th><th>Securities</th><th>Securities Particulars</th><th>Loan Purpose</th><th>Guarantor Name</th><th>Guarantor ID</th><th>Guarantor Phone</th><th>Guarantor Sign</th><th>Deponent Name</th><th>Deponent Address</th><th>Deponent ID</th><th>Deponent Sign</th><th>Sworn At</th><th>Sworn Date</th><th>Commissioner for Oaths</th><th>Status</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td data-editable='true' data-field='station'>" . $row['station'] . "</td>";
                echo "<td data-editable='true' data-field='loaning_date'>" . $row['loaning_date'] . "</td>";
                echo "<td data-editable='true' data-field='refund_date'>" . $row['refund_date'] . "</td>";
                echo "<td data-editable='true' data-field='location'>" . $row['location'] . "</td>";
                echo "<td data-editable='true' data-field='sub_location'>" . $row['sub_location'] . "</td>";
                echo "<td data-editable='true' data-field='name'>" . $row['name'] . "</td>";
                echo "<td data-editable='true' data-field='village'>" . $row['village'] . "</td>";
                echo "<td data-editable='true' data-field='id_no'>" . $row['id_no'] . "</td>";
                echo "<td data-editable='true' data-field='marital_status'>" . $row['marital_status'] . "</td>";
                echo "<td data-editable='true' data-field='phone_no'>" . $row['phone_no'] . "</td>";
                echo "<td data-editable='true' data-field='occupation'>" . $row['occupation'] . "</td>";
                echo "<td data-editable='true' data-field='family'>" . $row['family'] . "</td>";
                echo "<td data-editable='true' data-field='loan_applied'>" . $row['loan_applied'] . "</td>";
                echo "<td data-editable='true' data-field='loan_in_words'>" . $row['loan_in_words'] . "</td>";
                echo "<td data-editable='true' data-field='one_week_pay'>" . $row['one_week_pay'] . "</td>";
                echo "<td data-editable='true' data-field='two_weeks_pay'>" . $row['two_weeks_pay'] . "</td>";
                echo "<td data-editable='true' data-field='securities'>" . $row['securities'] . "</td>";
                echo "<td data-editable='true' data-field='securities_particulars'>" . $row['securities_particulars'] . "</td>";
                echo "<td data-editable='true' data-field='loan_purpose'>" . $row['loan_purpose'] . "</td>";
                echo "<td data-editable='true' data-field='guarantor_name'>" . $row['guarantor_name'] . "</td>";
                echo "<td data-editable='true' data-field='guarantor_id'>" . $row['guarantor_id'] . "</td>";
                echo "<td data-editable='true' data-field='guarantor_phone'>" . $row['guarantor_phone'] . "</td>";
                echo "<td data-editable='true' data-field='guarantor_sign'>" . $row['guarantor_sign'] . "</td>";
                echo "<td data-editable='true' data-field='deponent_name'>" . $row['deponent_name'] . "</td>";
                echo "<td data-editable='true' data-field='deponent_address'>" . $row['deponent_address'] . "</td>";
                echo "<td data-editable='true' data-field='deponent_id'>" . $row['deponent_id'] . "</td>";
                echo "<td data-editable='true' data-field='deponent_sign'>" . $row['deponent_sign'] . "</td>";
                echo "<td data-editable='true' data-field='sworn_at'>" . $row['sworn_at'] . "</td>";
                echo "<td data-editable='true' data-field='sworn_date'>" . $row['sworn_date'] . "</td>";
                echo "<td data-editable='true' data-field='commissioner_oaths'>" . $row['commissioner_oaths'] . "</td>";
                echo "<td data-editable='false' data-field='status'>" . $row['status'] . "</td>";
                echo "<td><button class='edit-btn' onclick='makeEditable(this.parentElement.parentElement)'>Edit</button>
                <button class='save-btn' style='display:none;' onclick='saveChanges(this.parentElement.parentElement, " . $row['id'] . ")'>Save</button>
                / <a href='delete_loan.php?id=" . $row['id'] . "' onclick='return confirm(\"Are you sure you want to delete this application?\")'> Delete</a>
                </td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "No application found.";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>
    <div class="mission">
        <h2>OUR MISSION</h2>
        <p>Our mission is to provide financial services to underserved communities, supporting economic growth and financial inclusion.</p>
    </div>
    <div class="footer">
        <address>
            <h2 id="contact">CONTACT US:</h2>
            <p id="contact">Ololmasani Capital Limited | Ololmasani Takitech Centre, Narok County, Kenya | P.O. Box 13 - 20404, Ndanai | Email: olmf@gmail.com</p>
        </address>
    </div>
</body>

</html>