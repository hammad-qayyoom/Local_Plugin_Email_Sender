<?php
require_once('../../config.php');
require_login();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url(new moodle_url('/local/emailplugin/index.php'));
$PAGE->set_title(get_string('pluginname', 'local_emailplugin'));
$PAGE->set_heading(get_string('pluginname', 'local_emailplugin'));

echo $OUTPUT->header();

// Predefined email addresses
$email_options = [
    'hammadqayyom006@gmail.com' => 'Hammad006',
    'hammadqayyoom0@gmail.com' => 'Hammad0',
    'hafizhammad903@gmail.com' => 'Hammad903',
    'hammadqayyom018@gmail.com' => 'Hammad018',
    'hammadqayyom002@gmail.com' => 'Hammad002'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_emails = required_param_array('email', PARAM_EMAIL);
    $subject = required_param('subject', PARAM_TEXT);
    $message = required_param('message', PARAM_TEXT);

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                        // Set mailer to use SMTP
        $mail->Host       = 'smtp.gmail.com'; // Specify main and backup SMTP servers
        $mail->SMTPAuth   = true;               // Enable SMTP authentication
        $mail->Username   = 'hammadqayyoom.fonerep@gmail.com';    // SMTP username
        $mail->Password   = 'psbsrjcfvrrojgtq';    // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption, `PHPMailer::ENCRYPTION_SMTPS` also accepted
        $mail->Port       = 587;                // TCP port to connect to

        // Recipients
        $mail->setFrom($USER->email, 'Moodle Plugin');
        foreach ($selected_emails as $to) {
            $mail->addAddress($to);                 // Add a recipient
        }

        // Content
        $mail->isHTML(false);                  // Set email format to plain text
        $mail->Subject = $subject;
        $mail->Body    = $message;

        $mail->send();
        echo html_writer::div(get_string('emailsuccess', 'local_emailplugin'), 'alert alert-success');
    } catch (Exception $e) {
        echo html_writer::div(get_string('emailfail', 'local_emailplugin') . ' Mailer Error: ' . $mail->ErrorInfo, 'alert alert-danger');
    }
}

echo '<form method="POST">';
echo '<div class="form-group">';
echo '<label for="email">'.get_string('selectemail', 'local_emailplugin').'</label>';
echo '<select class="form-control" id="email" name="email[]" multiple required>';
foreach ($email_options as $email => $label) {
    echo '<option value="' . $email . '">' . $label . '</option>';
}
echo '</select>';
echo '</div>';
echo '<div class="form-group">';
echo '<label for="subject">'.get_string('emailsubject', 'local_emailplugin').'</label>';
echo '<input type="text" class="form-control" id="subject" name="subject" required>';
echo '</div>';
echo '<div class="form-group">';
echo '<label for="message">'.get_string('emailbody', 'local_emailplugin').'</label>';
echo '<textarea class="form-control" id="message" name="message" rows="3" required></textarea>';
echo '</div>';
echo '<button type="submit" class="btn btn-primary">'.get_string('sendemail', 'local_emailplugin').'</button>';
echo '</form>';

echo $OUTPUT->footer();
?>
