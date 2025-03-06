=== WPLess SMTP Lite ===
Contributors: wpless  
Tags: smtp, email, mail, wp mail, email smtp  
Requires at least: 5.6  
Tested up to: 6.4  
Requires PHP: 7.2  
Stable tag: 1.0.0  
License: GPLv2 or later  
License URI: https://www.gnu.org/licenses/gpl-2.0.html  
Donate link: https://paypal.me/officialanujpandey  

WPLess SMTP Lite allows you to send WordPress emails using an SMTP server, ensuring reliable email delivery.

== Description ==

WPLess SMTP Lite is a lightweight SMTP plugin that lets you configure an SMTP server for sending emails from WordPress.  
It ensures that your emails are delivered properly instead of being marked as spam.  

**Features:**  
- Configure SMTP settings (Host, Port, Username, Password, Encryption)  
- Option to force a custom sender name and email  
- Automatic port selection based on encryption type  
- Send a test email to verify SMTP settings  
- Lightweight and follows WordPress standards  

This plugin helps resolve issues where WordPress emails are not delivered due to server restrictions or spam filters.  

== Installation ==

1. Upload the plugin folder to `/wp-content/plugins/wpless-smtp-lite` directory, or install via the WordPress Plugin Installer.  
2. Activate the plugin through the 'Plugins' menu in WordPress.  
3. Go to **Settings → WPLess SMTP Lite** and enter your SMTP details.  
4. Save changes and send a test email to verify your configuration.  

== Frequently Asked Questions ==

= Why are my emails not sending? =  
Ensure you have entered the correct SMTP details, including host, port, username, and password. Also, verify that your hosting provider allows external SMTP connections.  

= Can I use Gmail SMTP? =  
Yes, but you may need to enable "Less Secure Apps" or use an App Password in your Google Account.  

= Does this plugin work on localhost? =  
No, SMTP email sending typically does not work on localhost unless you configure an external mail server.  

== Screenshots ==

1. **SMTP Settings Page** - Configure SMTP settings in a simple interface.  
2. **Test Email Feature** - Verify SMTP settings by sending a test email.  

== Changelog ==

= 1.0.0 =  
* Initial release.  
* Basic SMTP settings support.  
* Option to force sender name and email.  
* Test email functionality added.  

== Upgrade Notice ==

= 1.0.0 =  
First release of WPLess SMTP Lite. No upgrade required.  

== License ==  
This plugin is licensed under GPLv2 or later.  
