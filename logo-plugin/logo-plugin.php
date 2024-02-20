<?php
/*
Plugin Name: logo
Description: Customizes the header by changing the logo.
Version: 1.0
Author: Ahmed Moustafa
*/

// Constants
define('LOGO_MENU_TITLE', 'logo Settings');
define('LOGO_MENU_NAME', 'logo');

// Enqueue custom  styles
function logo_enqueue_styles() {
    wp_register_style('plugin', plugin_dir_url(__FILE__) . 'assets/css/plugin.css', array(), '1.0.0', 'all');
    wp_enqueue_style('plugin');
}
add_action('wp_enqueue_scripts', 'logo_enqueue_styles');

// Enqueue custom scripts
function logo_enqueue_scripts($hook) {
    if ('toplevel_page_logo-settings' !== $hook) {
        return;
    }
    wp_enqueue_script('logo-main', plugin_dir_url(__FILE__) . 'assets/js/main.js', array('jquery'), '1.0.0', true);
}
add_action('admin_enqueue_scripts', 'logo_enqueue_scripts');

// Add custom logo to wp_body_open hook
function custom_logo() {
    $attachment_id = get_option('logo_attachment_id'); // Get the attachment ID from options

    if ($attachment_id) {
        $attachment_url = wp_get_attachment_url($attachment_id); // Get the URL of the attachment

        echo '<div class="site-branding py-auto">';
        echo '<a href="' . esc_url(home_url('/')) . '" rel="home">';
        echo '<img src="' . esc_url($attachment_url) . '" alt="Logo">';
        echo '</a>';
        echo '</div>';
    } else {
        echo '<!-- No custom logo set -->';
    }
}
add_action('wp_body_open', 'custom_logo');

// Save uploaded logo file
function save_logo_file() {
    if (isset($_FILES['logo_file'])) {
        $uploaded_file = $_FILES['logo_file'];
        $upload_overrides = array('test_form' => false);
        $movefile = wp_handle_upload($uploaded_file, $upload_overrides);

        if ($movefile && !isset($movefile['error'])) {
            $file_path = $movefile['file']; 

            // Delete the old logo from media library
            $old_logo_id = get_option('logo_attachment_id');
            if ($old_logo_id) {
                wp_delete_attachment($old_logo_id, true); 
            }
            
            // Get the MIME type of the image
            $file_type = wp_check_filetype(basename($file_path), null);

            // Prepare an array of post data for the attachment.
            $attachment = array(
                'post_mime_type' => $file_type['type'],
                'post_title'     => sanitize_file_name(basename($file_path)),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );

            // Insert the attachment
            $attach_id = wp_insert_attachment($attachment, $file_path);

            // Generate attachment metadata and update the attachment
            $attach_data = wp_generate_attachment_metadata($attach_id, $file_path);
            wp_update_attachment_metadata($attach_id, $attach_data);

            // Set the attachment ID as an option for future deletion
            update_option('logo_attachment_id', $attach_id);

            // Set the attachment URL as the logo URL
            $attachment_url = wp_get_attachment_url($attach_id) . '?=' . time();
            update_option('custom_logo_url', $attachment_url);
        } 
    }
}
add_action('admin_init', 'save_logo_file');
// Create settings page and fields
function logo_settings_page() {
    add_menu_page(
        'logo Settings',
        'Logo',
        'manage_options',
        'logo-settings',
        'logo_settings_page_content'
    );
    register_setting('logo_settings_group', 'custom_logo_url');
}
add_action('admin_menu', 'logo_settings_page');

// Settings page content
function logo_settings_page_content() {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html(LOGO_MENU_TITLE); ?></h1>
        <form method="post" action="options.php" enctype="multipart/form-data">
            <?php
            settings_fields('logo_settings_group');
            do_settings_sections('logo-settings');
            ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Custom Logo URL</th>
                    <td>
                        <input type="text" name="custom_logo_url" id="custom_logo_url" value="<?php echo esc_attr(get_option('custom_logo_url')); ?>" />
                        <input type="button" id="upload_logo_button" class="button-secondary" value="Upload Logo">
                        <p class="description">Enter the URL of the custom logo image or upload a new one.</p>
                    </td>
                </tr>
                <tr valign="top" id="logo_upload_row" style="display: none;">
                    <th scope="row">Upload Logo</th>
                    <td>
                        <input type="file" name="logo_file" id="logo_file" accept="image/*">
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}