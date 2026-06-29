<?php
/**
 * Plugin Name: Callbook Three AM
 * Plugin URI:  https://clearchoicechiropractic.com.au
 * Description: Mobile call-to-action bar — shows Call, Book Online, and Email buttons fixed at the bottom of the screen on mobile devices only.
 * Version:     1.0
 * Author:      Three AM
 * Text Domain: callbook
 */

// Prevent direct access.
if (!defined('ABSPATH')) {
    exit;
}

define('CALLBOOK_VERSION', '1.0');
define('CALLBOOK_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('CALLBOOK_PLUGIN_URL', plugin_dir_url(__FILE__));

// ---------------------------------------------------------------------------
//  Admin settings
// ---------------------------------------------------------------------------

/**
 * Register the settings page under Settings > Callbook.
 */
add_action('admin_menu', function () {
    add_options_page(
        'Callbook Settings',
        'Callbook',
        'manage_options',
        'callbook',
        'callbook_settings_page'
    );
});

/**
 * Register the three settings.
 */
add_action('admin_init', function () {
    register_setting('callbook_settings', 'callbook_phone');
    register_setting('callbook_settings', 'callbook_booking_url');
    register_setting('callbook_settings', 'callbook_email');
});

/**
 * Render the settings page.
 */
function callbook_settings_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Callbook Settings', 'callbook'); ?></h1>
        <form method="post" action="options.php">
            <?php settings_fields('callbook_settings'); ?>
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="callbook_phone"><?php esc_html_e('Phone Number', 'callbook'); ?></label>
                    </th>
                    <td>
                        <input type="tel" id="callbook_phone" name="callbook_phone"
                               value="<?php echo esc_attr(get_option('callbook_phone', '08 7260 3439')); ?>"
                               class="regular-text" />
                        <p class="description"><?php esc_html_e('The phone number the "Call Us" button dials (e.g. 08 7260 3439).', 'callbook'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="callbook_booking_url"><?php esc_html_e('Booking URL', 'callbook'); ?></label>
                    </th>
                    <td>
                        <input type="url" id="callbook_booking_url" name="callbook_booking_url"
                               value="<?php echo esc_attr(get_option('callbook_booking_url', 'https://clearchoicechiropractic.com.au/booking/')); ?>"
                               class="regular-text" />
                        <p class="description"><?php esc_html_e('The URL the "Book Online" button opens.', 'callbook'); ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label for="callbook_email"><?php esc_html_e('Email Address', 'callbook'); ?></label>
                    </th>
                    <td>
                        <input type="email" id="callbook_email" name="callbook_email"
                               value="<?php echo esc_attr(get_option('callbook_email', 'hello@clearchoicechiropractic.com.au')); ?>"
                               class="regular-text" />
                        <p class="description"><?php esc_html_e('The email address the mail icon opens.', 'callbook'); ?></p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// ---------------------------------------------------------------------------
//  Front-end output
// ---------------------------------------------------------------------------

/**
 * Enqueue the CSS file.
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style('callbook', CALLBOOK_PLUGIN_URL . 'callbook.css', [], CALLBOOK_VERSION);
});

/**
 * Output the call bar in the footer.
 */
add_action('wp_footer', function () {
    $phone      = get_option('callbook_phone', '08 7260 3439');
    $booking_url = get_option('callbook_booking_url', 'https://clearchoicechiropractic.com.au/booking/');
    $email      = get_option('callbook_email', 'hello@clearchoicechiropractic.com.au');
    ?>
    <div id="callbook" class="mobile-call">
        <a id="cb_call" class="actioncall" href="tel:<?php echo esc_attr($phone); ?>">
            <span style="padding:0 5px 0 0;" class="callbook-icona-telefono"></span>
            <span class="callbook-align">Call Us</span>
        </a>
        <a id="cb_book" class="actionbook" target="_blank" href="<?php echo esc_url($booking_url); ?>">
            <span class="callbook-align">Book Online</span>
            <span style="padding:0 0 0 5px;" class="callbook-icona-calendario"></span>
        </a>
        <div class="callbook_logo">
            <a id="cb_mail" class="icon" href="mailto:<?php echo esc_attr($email); ?>">
                <span class="callbook-icona-busta-lettera"></span>
            </a>
        </div>
        <div class="callbook_under"></div>
    </div>
    <?php
});