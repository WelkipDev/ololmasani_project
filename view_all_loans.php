<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>All Loan Applications</title>
  <link rel="stylesheet" href=".vscode/styles.css">
    <script src="moita.js" type="text/javascript"></script>
    <!-- Add your favicon here -->
    <link rel="icon" href="images/urlicon.ico" type="image/x-icon">
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
    <h2>All Loan Applications</h2>

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

    // Retrieve all loan applications from the database
    $sql = "SELECT * FROM loan_applications";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
            // Output the application details in a table format
            echo "<div class='table-container'>";
            echo "<table>";
            echo "<tr><th>ID</th><th>Station</th><th>Loaning Date</th><th>Name</th><th>Village</th><th>ID No</th><th>Phone No</th><th>Occupation</th><th>Loan Applied</th><th>Securities</th><th>Loan Purpose</th><th>Guarantor Name</th><th>Guarantor ID</th><th>Guarantor Phone</th><th>Status</th><th>Actions</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['station'] . "</td>";
                echo "<td>" . $row['loaning_date'] . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['village'] . "</td>";
                echo "<td>" . $row['id_no'] . "</td>";
                echo "<td>" . $row['phone_no'] . "</td>";
                echo "<td>" . $row['occupation'] . "</td>";
                echo "<td>" . $row['loan_applied'] . "</td>";
                echo "<td>" . $row['securities'] . "</td>";
                echo "<td>" . $row['loan_purpose'] . "</td>";
                echo "<td>" . $row['guarantor_name'] . "</td>";
                echo "<td>" . $row['guarantor_id'] . "</td>";
                echo "<td>" . $row['guarantor_phone'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                              
               echo "<td>";
                echo "<a href='approve_loan.php?id=" . $row['id'] . "'>Approve</a> | ";
                echo "<a href='decline_loan.php?id=" . $row['id'] . "'>Decline</a>";
                echo "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "</div>";
        } else {
            echo "No application found.";
        }


    $conn->close();
    
  
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
      <p id="contact">Ololmasani Microfinance Limited | Ololmasani Takitech Centre, Narok County, Kenya | P.O. Box
        13 - 20404, Ndanai | Email: olmf@gmail.com</p>
    </address>
  </div>
</body>

</html>