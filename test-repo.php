<?php
/**
 * Plugin Name: Test Repo Plugin
 * Plugin URI: https://github.com/Newar9807/test-repo
 * Description: A test plugin for demonstrating automated version management.
 * Version: 1.0.1
 * Author: Your Name
 * Author URI: https://github.com/Newar9807
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: test-repo
 * Domain Path: /languages
 * Requires at least: 5.0
 * Tested up to: 6.4
 * Requires PHP: 7.4
 * Network: false
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('TEST_REPO_VERSION', '1.0.1');
define('TEST_REPO_PLUGIN_URL', plugin_dir_url(__FILE__));
define('TEST_REPO_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('TEST_REPO_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main plugin class
 */
class TestRepoPlugin {
    
    /**
     * Plugin version
     */
    const VERSION = '1.0.1';
    
    /**
     * Single instance of the plugin
     */
    private static $instance = null;
    
    /**
     * Get single instance of the plugin
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->init_hooks();
    }
    
    /**
     * Initialize hooks
     */
    private function init_hooks() {
        add_action('init', array($this, 'init'));
        add_action('admin_menu', array($this, 'add_admin_menu'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    /**
     * Initialize plugin
     */
    public function init() {
        // Load text domain for translations
        load_plugin_textdomain('test-repo', false, dirname(TEST_REPO_PLUGIN_BASENAME) . '/languages');
        
        // Initialize plugin functionality here
        $this->load_dependencies();
    }
    
    /**
     * Load plugin dependencies
     */
    private function load_dependencies() {
        // Load additional files here if needed
    }
    
    /**
     * Add admin menu
     */
    public function add_admin_menu() {
        add_options_page(
            __('Test Repo Settings', 'test-repo'),
            __('Test Repo', 'test-repo'),
            'manage_options',
            'test-repo-settings',
            array($this, 'admin_page')
        );
    }
    
    /**
     * Admin page callback
     */
    public function admin_page() {
        ?>
        <div class="wrap">
            <h1><?php echo esc_html(get_admin_page_title()); ?></h1>
            <div class="notice notice-info">
                <p><?php printf(__('Test Repo Plugin Version: %s', 'test-repo'), self::VERSION); ?></p>
            </div>
            <form method="post" action="options.php">
                <?php
                settings_fields('test_repo_settings');
                do_settings_sections('test_repo_settings');
                ?>
                <table class="form-table">
                    <tr>
                        <th scope="row"><?php _e('Plugin Status', 'test-repo'); ?></th>
                        <td><?php _e('Active and running', 'test-repo'); ?></td>
                    </tr>
                </table>
                <?php submit_button(); ?>
            </form>
        </div>
        <?php
    }
    
    /**
     * Plugin activation
     */
    public function activate() {
        // Activation logic here
        add_option('test_repo_version', self::VERSION);
        
        // Create database tables if needed
        $this->create_tables();
        
        // Set default options
        $this->set_default_options();
    }
    
    /**
     * Plugin deactivation
     */
    public function deactivate() {
        // Deactivation logic here
        // Note: Don't delete data on deactivation, only on uninstall
    }
    
    /**
     * Create database tables
     */
    private function create_tables() {
        // Add table creation logic if needed
    }
    
    /**
     * Set default options
     */
    private function set_default_options() {
        $default_options = array(
            'test_repo_enabled' => true,
            'test_repo_debug' => false,
        );
        
        foreach ($default_options as $option_name => $option_value) {
            if (get_option($option_name) === false) {
                add_option($option_name, $option_value);
            }
        }
    }
    
    /**
     * Get plugin version
     */
    public static function get_version() {
        return self::VERSION;
    }
}

/**
 * Initialize the plugin
 */
function test_repo_init() {
    return TestRepoPlugin::get_instance();
}

// Start the plugin
add_action('plugins_loaded', 'test_repo_init');

/**
 * Uninstall hook
 */
register_uninstall_hook(__FILE__, 'test_repo_uninstall');

/**
 * Plugin uninstall
 */
function test_repo_uninstall() {
    // Clean up options
    delete_option('test_repo_version');
    delete_option('test_repo_enabled');
    delete_option('test_repo_debug');
    
    // Drop custom tables if any
    // global $wpdb;
    // $wpdb->query("DROP TABLE IF EXISTS {$wpdb->prefix}test_repo_data");
} 
