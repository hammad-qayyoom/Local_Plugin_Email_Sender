<?php
defined('MOODLE_INTERNAL') || die;

if ($hassiteconfig) {
    $settings = new admin_settingpage('local_myplugin', get_string('pluginname', 'local_myplugin'));

    // Add settings elements
    $settings->add(new admin_setting_configtext('local_myplugin/email', get_string('email', 'local_myplugin'), '', '', PARAM_TEXT));

    // Add the settings page to the admin tree
    $ADMIN->add('localplugins', $settings);

    // Load form library and email class
    require_once($CFG->libdir . '/formslib.php');
    require_once($CFG->dirroot . '/local/myplugin/classes/email.php');

    // Define the form for sending emails
    class email_form extends moodleform {
        public function definition() {
            $mform = $this->_form;

            // Define the list of predefined email addresses
            $predefined_emails = [
                'hammadqayyom006@gmail.com' => 'Email 1',
                'hammadqayyoom0@gmail.com' => 'Email 2',
                'hammadqayyoom.fonerep@gmail.com' => 'Email 3',
                'email4@example.com' => 'Email 4',
                'email5@example.com' => 'Email 5'
            ];

            // Add multi-select dropdown for selecting email addresses
            $mform->addElement('select', 'recipients', get_string('recipients', 'local_myplugin'), $predefined_emails, ['multiple' => 'multiple']);
            $mform->setType('recipients', PARAM_TEXT);

            // Add message field
            $mform->addElement('textarea', 'message', get_string('message', 'local_myplugin'), 'wrap="virtual" rows="10" cols="50"');
            $mform->setType('message', PARAM_TEXT);

            // Add submit button
            $mform->addElement('submit', 'send', get_string('send', 'local_myplugin'));
        }
    }

    // Instantiate the form
    $mform = new email_form(null, ['section' => 'local_myplugin']);

    if ($data = $mform->get_data()) {
        // Ensure recipients is an array
        if (!empty($data->recipients) && is_array($data->recipients)) {
            // Send email to each selected address
            foreach ($data->recipients as $recipient) {
                $result = \local_myplugin\email::send_email($recipient, 'Plugin Test Email', $data->message);
                // Optionally handle results or errors here
                if ($result) {
                    // Log successful send
                    error_log("Email sent to: $recipient");
                } else {
                    // Log failure
                    error_log("Failed to send email to: $recipient");
                }
            }
        }
    }

    // Display the form
    $mform->display();
}
