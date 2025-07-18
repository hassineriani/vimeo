<?php
/**
 * Plugin Name:       Video Uploads for Vimeo PRO
 * Plugin URI:        https://codeverve.com
 * Description:       Embed and upload videos to Vimeo directly from WordPress
 * Version:           1.9.7
 * Author:            Darko Gjorgjijoski
 * Author URI:        https://darkog.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-vimeo-videos-pro
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined('WPINC')) {
    die;
}

if ( ! function_exists('is_plugin_active')) {
    include_once(ABSPATH.'wp-admin/includes/plugin.php');
}

if ( ! is_plugin_active('wp-vimeo-videos/wp-vimeo-videos.php')) {

    define('WP_VIMEO_VIDEOS_VERSION', '1.9.7');
	define('WP_VIMEO_VIDEOS_DB_PROVERSION', 100 );
    define('WP_VIMEO_VIDEOS_FILE', __FILE__);
    define('WP_VIMEO_VIDEOS_PATH', plugin_dir_path(__FILE__));
    define('WP_VIMEO_VIDEOS_URL', plugin_dir_url(__FILE__));
    define('WP_VIMEO_VIDEOS_BASENAME', plugin_basename(__FILE__));
    define('WP_VIMEO_VIDEOS_MIN_PHP_VERSION', '7.3.0');
    define('WP_VIMEO_VIDEOS_PLUGIN_ID', 561);
    define('WP_VIMEO_VIDEOS_INTEGRATIONS_PATH', trailingslashit(WP_VIMEO_VIDEOS_PATH).'integrations'.DIRECTORY_SEPARATOR);
    define('WP_VIMEO_VIDEOS_INTEGRATIONS_URL', WP_VIMEO_VIDEOS_URL.'integrations/');

    /**
     * Dependency check.
     */
    if ( ! function_exists('curl_version')) {
        add_action('admin_notices', function () {
            $class   = 'notice notice-error is-dismissible';
            $plugin  = 'Video Uploads for Vimeo';
            $message = __('The cURL PHP extension is required in order to run this plugin. Please contact your webhost to enable the cURL PHP extension.', 'wp-vimeo-videos-pro');
            printf('<div class="%1$s"><p><strong>%2$s</strong>: %3$s</p></div>', esc_attr($class), esc_html($plugin), esc_html($message));
        });

        return;
    }

    /**
     * Run on plugin acitvation
     * @return void
     */
    function activate_wp_vimeo_videos()
    {
        require_once plugin_dir_path(__FILE__).'includes/class-wp-dgv-activator.php';
        WP_DGV_Activator::activate();
    }

    /**
     * Run on plugin deactivation
     * @return void
     */
    function deactivate_wp_vimeo_videos()
    {
        require_once plugin_dir_path(__FILE__).'includes/class-wp-dgv-deactivator.php';
        WP_DGV_Deactivator::deactivate();
    }

    register_activation_hook(__FILE__, 'activate_wp_vimeo_videos');
    register_deactivation_hook(__FILE__, 'deactivate_wp_vimeo_videos');

    /**
     * Bootstrap the plugin
     */
    require plugin_dir_path(__FILE__).'includes/class-wp-dgv.php';
    function run_wp_vimeo_videos()
    {
        $plugin = new WP_DGV();
        $plugin->run();
    }

    run_wp_vimeo_videos();
}
