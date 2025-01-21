<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = htmlspecialchars($_POST['form_name']);
    $email = htmlspecialchars($_POST['form_email']);
    $subject = htmlspecialchars($_POST['form_subject']);
    $phone = htmlspecialchars($_POST['form_phone']);
    $message = htmlspecialchars($_POST['form_message']);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.yourdomain.com'; // Replace with your SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'your-email@yourdomain.com'; // Replace with your email
        $mail->Password = 'your-email-password'; // Replace with your email password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Email Content
        $mail->setFrom($email, $name);
        $mail->addAddress('your-receiving-email@yourdomain.com'); // Replace with your recipient email
        $mail->Subject = $subject;
        $mail->Body = "Name: $name\nEmail: $email\nPhone: $phone\nMessage:\n$message";

        $mail->send();
        echo "Message sent successfully!";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    echo "Invalid request";
}