<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require('PHPMailer/PHPMailer.php');
require('PHPMailer/SMTP.php');
require('PHPMailer/Exception.php');

function sendEmail($to, $subject, $body, $pdfData = null)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = "kkanjariya630@rku.ac.in";  // Gmail username
        $mail->Password   = "yvhprhctdcqnzjeo";         // Gmail app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Sender & Recipient
        $mail->setFrom('kiritkanjariya69@gmail.com', 'Student Demo Website');
        $mail->addReplyTo("kiritkanjariya69@gmail.com", "Student Demo Website");
        $mail->addAddress($to);

        // Email Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        // Attach PDF if exists
        if ($pdfData) {
            $mail->addStringAttachment($pdfData, 'invoice.pdf');
        }

        $mail->SMTPDebug = 0;
        return $mail->send();
    } catch (Exception $e) {
        return "Email failed: " . $mail->ErrorInfo;
    }
}
