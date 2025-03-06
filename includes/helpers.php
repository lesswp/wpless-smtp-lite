<?php
if (!defined('ABSPATH')) {
    exit;
}

function wpless_smtp_send_test_email() {
    if (!current_user_can('manage_options')) {
        wp_die('Unauthorized');
    }

    $nonce = isset($_POST['_wpnonce']) ? sanitize_text_field(wp_unslash($_POST['_wpnonce'])) : '';

    if (!wp_verify_nonce($nonce, 'wpless_smtp_test_email')) {
        wp_die('Security check failed.');
    }

    $email = isset($_POST['email']) ? sanitize_email(wp_unslash($_POST['email'])) : '';

    if (!is_email($email)) {
        echo "Invalid email address.";
        wp_die();
    }

    $server_name = isset($_SERVER['SERVER_NAME']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_NAME'])) : '';
    $server_addr = isset($_SERVER['SERVER_ADDR']) ? sanitize_text_field(wp_unslash($_SERVER['SERVER_ADDR'])) : '';

    if ($server_name === 'localhost' || $server_addr === '127.0.0.1') {
        echo "Failed to send test email.<br><pre>Invalid address: (From): wordpress@localhost</pre>";
        wp_die();
    }

    $subject = "Test Email from WPLess SMTP Lite";
    $message = "This is a test email sent using your SMTP settings.";
    $headers = ["Content-Type: text/html; charset=UTF-8"];

    $sent = wp_mail($email, $subject, $message, $headers);
    echo $sent ? "Test email sent successfully!" : "Failed to send test email.";
    wp_die();
}
add_action('wp_ajax_wpless_smtp_send_test_email', 'wpless_smtp_send_test_email');
