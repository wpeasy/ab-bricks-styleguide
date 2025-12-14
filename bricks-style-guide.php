<?php
/**
 * Plugin Name: Bricks Style Guide
 * Description: Adds Svelte based Elements to Bricks Builder for creating Style Guides
 * Version: 0.0.16-beta
 * Author: WP Easy
 * Author URI: https://wpeasy.au
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: bricks-style-guide
 * Domain Path: /languages
 * Requires at least: 6.0
 * Tested up to: 6.7
 * Requires PHP: 7.4
 */

namespace AB\BricksSG;

use AB\BricksSG\Framework\FrameworkDetector;

defined( 'ABSPATH' ) || exit;

// Plugin constants.
define( 'BRICKS_SG_VERSION', '0.0.16-beta' );
define( 'BRICKS_SG_PLUGIN_FILE', __FILE__ );
define( 'BRICKS_SG_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'BRICKS_SG_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Load Composer autoloader.
if ( file_exists( BRICKS_SG_PLUGIN_PATH . 'vendor/autoload.php' ) ) {
	require_once BRICKS_SG_PLUGIN_PATH . 'vendor/autoload.php';
}


/**
 * Initialize the plugin.
 *
 * @return void
 */
function init(): void {
	// Check if Bricks Builder theme is active.
	if ( ! is_bricks_active() ) {
		add_action( 'admin_notices', __NAMESPACE__ . '\\missing_bricks_notice' );
		return;
	}

	// Check if a supported CSS framework is active (AT or ACSS).
	if ( ! FrameworkDetector::has_framework() ) {
		add_action( 'admin_notices', __NAMESPACE__ . '\\missing_framework_notice' );
		return;
	}

	// Initialize the plugin.
	Plugin::init();
}
// Use after_setup_theme because Bricks theme must be loaded first.
add_action( 'after_setup_theme', __NAMESPACE__ . '\\init' );

/**
 * Check if Bricks Builder theme is active.
 *
 * @return bool
 */
function is_bricks_active(): bool {
	// Check for BRICKS_VERSION constant (defined in theme's functions.php).
	if ( defined( 'BRICKS_VERSION' ) ) {
		return true;
	}

	// Fallback: Check theme name or template.
	if ( function_exists( 'wp_get_theme' ) ) {
		$theme = wp_get_theme();
		// Check parent theme, theme name, or template slug.
		if ( 'Bricks' === $theme->parent_theme || 'Bricks' === $theme->name || 'bricks' === $theme->get_template() ) {
			return true;
		}
	}

	return false;
}

/**
 * Admin notice for missing Bricks Builder.
 *
 * @return void
 */
function missing_bricks_notice(): void {
	?>
	<div class="notice notice-error">
		<p><?php esc_html_e( 'Bricks Style Guide requires Bricks Builder to be installed and activated.', 'bricks-style-guide' ); ?></p>
	</div>
	<?php
}

/**
 * Admin notice for missing CSS framework.
 *
 * @return void
 */
function missing_framework_notice(): void {
	?>
	<div class="notice notice-error">
		<p><?php esc_html_e( 'Bricks Style Guide requires either Advanced Themer for Bricks or Automatic CSS to be installed and activated.', 'bricks-style-guide' ); ?></p>
	</div>
	<?php
}

/**
 * Check if Advanced Themer plugin is active.
 *
 * @deprecated Use FrameworkDetector::is_at_active() instead.
 * @return bool
 */
function is_advanced_themer_active(): bool {
	return FrameworkDetector::is_at_active();
}
