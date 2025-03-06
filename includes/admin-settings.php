<?php
if (!defined('ABSPATH')) {
    exit;
}

// Add SMTP settings menu
function wpless_smtp_add_menu() {
    add_options_page(
        'WPLess SMTP Lite',
        'WPLess SMTP Lite',
        'manage_options',
        'wpless-smtp-lite',
        'wpless_smtp_settings_page'
    );
}
add_action('admin_menu', 'wpless_smtp_add_menu');

// Render settings page
function wpless_smtp_settings_page() {
    $options = get_option('wpless_smtp_options');
    ?>
    <div class="wrap">
        <h1>WPLess SMTP Lite</h1>
        <form method="post" action="options.php">
            <?php
            settings_fields('wpless_smtp_settings');
            do_settings_sections('wpless-smtp-lite');
            submit_button();
            ?>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let forceCheckbox = document.getElementById("wpless_smtp_force");
            let forcedFields = document.getElementById("wpless_smtp_forced_fields");

            function toggleForcedFields() {
                forcedFields.style.display = forceCheckbox.checked ? "block" : "none";
            }

            forceCheckbox.addEventListener("change", toggleForcedFields);
            toggleForcedFields(); // Initialize on page load
        });
    </script>
    <style>
        #wpless_smtp_forced_fields { margin-left: 20px; }
    </style>
    <?php
}

function wpless_smtp_register_settings() {
register_setting('wpless_smtp_settings', 'wpless_smtp_options', 'wpless_smtp_sanitize_settings');
    add_settings_section('wpless_smtp_main', 'SMTP Settings', null, 'wpless-smtp-lite');

    add_settings_field('host', 'SMTP Host', 'wpless_smtp_host_field', 'wpless-smtp-lite', 'wpless_smtp_main');
    add_settings_field('port', 'SMTP Port', 'wpless_smtp_port_field', 'wpless-smtp-lite', 'wpless_smtp_main');
    add_settings_field('username', 'SMTP Username', 'wpless_smtp_username_field', 'wpless-smtp-lite', 'wpless_smtp_main');
    add_settings_field('password', 'SMTP Password', 'wpless_smtp_password_field', 'wpless-smtp-lite', 'wpless_smtp_main');
    add_settings_field('encryption', 'Encryption', 'wpless_smtp_encryption_field', 'wpless-smtp-lite', 'wpless_smtp_main');
    add_settings_field('force_name_email', 'Force Name & Email', 'wpless_smtp_force_field', 'wpless-smtp-lite', 'wpless_smtp_main');
    add_settings_field('forced_fields', '', 'wpless_smtp_forced_fields', 'wpless-smtp-lite', 'wpless_smtp_main');
    add_settings_field('test_email', 'Test Email', 'wpless_smtp_test_email_field', 'wpless-smtp-lite', 'wpless_smtp_main');
}
add_action('admin_init', 'wpless_smtp_register_settings');
function wpless_smtp_sanitize_settings($input) {
    $sanitized = [];

    $sanitized['host'] = isset($input['host']) ? sanitize_text_field($input['host']) : '';
    $sanitized['port'] = isset($input['port']) ? absint($input['port']) : '';
    $sanitized['username'] = isset($input['username']) ? sanitize_text_field($input['username']) : '';
    $sanitized['password'] = isset($input['password']) ? sanitize_text_field($input['password']) : '';
    $sanitized['encryption'] = isset($input['encryption']) ? sanitize_text_field($input['encryption']) : '';
    $sanitized['force'] = isset($input['force']) ? (bool) $input['force'] : false;
    $sanitized['forced_email'] = isset($input['forced_email']) ? sanitize_email($input['forced_email']) : '';
    $sanitized['forced_name'] = isset($input['forced_name']) ? sanitize_text_field($input['forced_name']) : '';

    return $sanitized;
}

function wpless_smtp_test_email_field() {
    $admin_email = get_option('admin_email');
    ?>
    <input type="email" id="wpless_smtp_test_email" value="<?php echo esc_attr($admin_email); ?>">
    <button type="button" id="wpless_smtp_test_button" class="button">Send Test Email</button>
    <p id="wpless_smtp_test_result"></p>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        let sendButton = document.getElementById("wpless_smtp_test_button");
        let emailInput = document.getElementById("wpless_smtp_test_email");
        let result = document.getElementById("wpless_smtp_test_result");

        sendButton.addEventListener("click", function () {
            let email = emailInput.value;
let nonce = "<?php echo esc_attr(wp_create_nonce('wpless_smtp_test_email')); ?>";

		result.innerText = "Sending...";

            fetch("<?php echo esc_url(admin_url('admin-ajax.php')); ?>", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "action=wpless_smtp_send_test_email&email=" + encodeURIComponent(email) + "&_wpnonce=" + nonce
            })
            .then(response => response.text())
            .then(data => { result.innerHTML = data; })
            .catch(error => { result.innerText = "Error sending email."; console.error(error); });
        });
    });
</script>


    <?php
}


function wpless_smtp_force_field() {
    $options = get_option('wpless_smtp_options');
    echo '<input type="checkbox" id="wpless_smtp_force" name="wpless_smtp_options[force]" value="1" ' . checked($options['force'] ?? '', '1', false) . '>';
}

function wpless_smtp_forced_fields() {
    $options = get_option('wpless_smtp_options');
    ?>
    <div id="wpless_smtp_forced_fields">
        <label>Forced Sender Email:</label>
        <input type="email" name="wpless_smtp_options[forced_email]" value="<?php echo esc_attr($options['forced_email'] ?? ''); ?>"><br><br>

        <label>Forced Sender Name:</label>
        <input type="text" name="wpless_smtp_options[forced_name]" value="<?php echo esc_attr($options['forced_name'] ?? ''); ?>">
    </div>
    <?php
}


// Field Callbacks
function wpless_smtp_host_field() {
    $options = get_option('wpless_smtp_options');
    echo '<input type="text" name="wpless_smtp_options[host]" value="' . esc_attr($options['host'] ?? '') . '">';
}
function wpless_smtp_port_field() {
    $options = get_option('wpless_smtp_options');
    echo '<input type="text" name="wpless_smtp_options[port]" value="' . esc_attr($options['port'] ?? '') . '">';
}
function wpless_smtp_username_field() {
    $options = get_option('wpless_smtp_options');
    echo '<input type="text" name="wpless_smtp_options[username]" value="' . esc_attr($options['username'] ?? '') . '">';
}
function wpless_smtp_password_field() {
    $options = get_option('wpless_smtp_options');
    echo '<input type="password" name="wpless_smtp_options[password]" value="' . esc_attr($options['password'] ?? '') . '">';
}
function wpless_smtp_encryption_field() {
    $options = get_option('wpless_smtp_options');
    ?>
    <select id="wpless_smtp_encryption" name="wpless_smtp_options[encryption]">
        <option value="none" <?php selected($options['encryption'] ?? '', 'none'); ?>>None</option>
        <option value="ssl" <?php selected($options['encryption'] ?? '', 'ssl'); ?>>SSL</option>
        <option value="tls" <?php selected($options['encryption'] ?? '', 'tls'); ?>>TLS</option>
    </select>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let encryptionField = document.getElementById("wpless_smtp_encryption");
            let portField = document.querySelector("input[name='wpless_smtp_options[port]']");

            function updatePort() {
                let selected = encryptionField.value;
                if (selected === "ssl") {
                    portField.value = "465";
                } else if (selected === "tls") {
                    portField.value = "587";
                } else {
                    portField.value = "25"; // Default fallback
                }
            }

            encryptionField.addEventListener("change", updatePort);
        });
    </script>
    <?php
}
