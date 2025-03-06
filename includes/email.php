<?php
if (!defined('ABSPATH')) {
    exit;
}

function wpless_smtp_setup_mailer($phpmailer) {
    $options = get_option('wpless_smtp_options');

    if (empty($options['host']) || empty($options['port']) || empty($options['username']) || empty($options['password'])) {
        return;
    }

    $phpmailer->isSMTP();
    $phpmailer->Host = $options['host'];
    $phpmailer->SMTPAuth = true;
    $phpmailer->Port = $options['port'];
    $phpmailer->Username = $options['username'];
    $phpmailer->Password = $options['password'];
    $phpmailer->SMTPSecure = $options['encryption'] ?? 'tls';

    // **Fix: Force a proper From email**
    if (!empty($options['force']) && !empty($options['forced_email'])) {
        $phpmailer->From = $options['forced_email'];
        $phpmailer->FromName = $options['forced_name'] ?? 'WordPress';
    } else {
        $phpmailer->From = $options['username']; // Use the SMTP username as the From email
        $phpmailer->FromName = 'WordPress'; // Default From name
    }
}
add_action('phpmailer_init', 'wpless_smtp_setup_mailer');
