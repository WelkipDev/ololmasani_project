<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validate form data
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Email details
        $to = "frpmutaz@gmail.com"; // Recipient email address
        $subject = "New Contact Form Submission";
        $headers = "From: $email\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        // Email body
        $emailBody = "You have received a new message from the contact form:\n\n";
        $emailBody .= "Name: $name\n";
        $emailBody .= "Email: $email\n";
        $emailBody .= "Message:\n$message\n";

        // Send the email
        if (mail($to, $subject, $emailBody, $headers)) {
            echo json_encode(['status' => 'success', 'message' => 'Thank you, ' . $name . '! Your message has been sent successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to send your message. Please try again later.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Please fill in all fields.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById("contactForm");
    const responseMessage = document.getElementById("responseMessage");

    form.addEventListener("submit", function (e) {
        e.preventDefault(); // Prevent the default form submission

        // Collect form data
        const formData = new FormData(form);

        // Send the data using fetch
        fetch("submit_contact.php", {
            method: "POST",
            body: formData,
        })
            .then(response => response.json()) // Parse the JSON response
            .then(data => {
                if (data.status === "success") {
                    responseMessage.style.color = "green";
                    responseMessage.textContent = data.message;
                    form.reset(); // Clear the form
                } else {
                    responseMessage.style.color = "red";
                    responseMessage.textContent = data.message;
                }
            })
            .catch(error => {
                responseMessage.style.color = "red";
                responseMessage.textContent = "An error occurred. Please try again.";
                console.error("Error:", error);
            });
    });
});
</script>