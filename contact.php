<?php
// Include PHPMailer files manually
require __DIR__ . '/phpmailer/src/PHPMailer.php';
require __DIR__ . '/phpmailer/src/SMTP.php';
require __DIR__ . '/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Collect and sanitize the form inputs
    $name = htmlspecialchars(strip_tags(trim($_POST['name'])));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars(strip_tags(trim($_POST['message'])));

    // Validate the email address
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email address.";
        exit;
    }

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP(); // Use SMTP
        $mail->Host = 'smtp.gmail.com'; // Google Workspace SMTP server
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'contact@logoversedesign.co.uk'; // Your Google Workspace email
        $mail->Password = 'kcxf kqwu uxjw zerk'; // Replace with your App Password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Use STARTTLS encryption
        $mail->Port = 587; // TCP port for SMTP

        // Email settings
        $mail->setFrom('contact@logoversedesign.co.uk', 'Logoverse Contact Form'); // Sender email
        $mail->addAddress('contact@logoversedesign.co.uk'); // Recipient email
        $mail->addReplyTo($email, $name); // Reply-to address

        // Email content
        $mail->isHTML(false); // Use plain text
        $mail->Subject = 'New Contact Form Submission';
        $mail->Body = "You have received a new message from your website contact form.\n\n" .
                      "Name: $name\n" .
                      "Email: $email\n\n" .
                      "Message:\n$message";

        // Attempt to send the email
        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Error: {$mail->ErrorInfo}";
    }
} else {
    // Handle cases where the script is accessed directly
    echo "Invalid request method.";
}
?>
