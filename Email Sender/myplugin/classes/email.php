<?php
namespace local_myplugin;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

defined('MOODLE_INTERNAL') || die;

class email {
    public static function send_email($to, $subject, $body) {
        $mail = new PHPMailer(true);
        
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com'; // Set the SMTP server to send through
            $mail->SMTPAuth   = true;
            $mail->Username   = 'hammadqayyoom.fonerep@gmail.com'; // SMTP username
            $mail->Password   = 'psbsrjcfvrrojgtq'; // SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('hammadqayyoom0@gmail.com', 'Mailer');
            $mail->addAddress($to);

            // Content
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
