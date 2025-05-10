<?php

// Validate and sanitize email input
$email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);

if (!$email) {
    exit("Invalid email address.");
}

// Generate token and expiration
$token = bin2hex(random_bytes(16));
$token_hash = hash("sha256", $token);
$expiry = date("Y-m-d H:i:s", time() + 60 * 30);

// Connect to database
$mysqli = require __DIR__ . "/database.php";

// Prepare and execute update query
$sql = "UPDATE users
        SET reset_token_hash = ?,
            reset_token_expires_at = ?
        WHERE email = ?";

$stmt = $mysqli->prepare($sql);
$stmt->bind_param("sss", $token_hash, $expiry, $email);
$stmt->execute();

if ($mysqli->affected_rows) {
    try {
        $mail = require __DIR__ . "/mailer.php";

        $mail->setFrom("noreply@example.com", "iNVAX Support");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset Request";
        $mail->isHTML(true);
        $mail->Body = <<<HTML
            <p>Hello,</p>
            <p>We received a request to reset your password. Click the link below to reset it:</p>
            <p><a href="http://localhost/inventorysys/reset-password.php?token=$token">Reset your password</a></p>
            <p>If you did not request this, you can safely ignore this email.</p>
            <p>– iNVAX Team</p>
        HTML;
        $mail->SMTPDebug = 2; // Add this
        $mail->Debugoutput = 'html'; // And this
        $mail->send();
        echo "Message sent, please check your inbox.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
    }
} else {
    // Optional: avoid exposing whether the email exists for security reasons
    echo "Message sent, please check your inbox.";
}
