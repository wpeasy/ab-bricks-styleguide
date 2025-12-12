<?php
/**
 * Plugin Name: Advanced Themer Style Guide
 * Description: Adds Svelte based Elements to Bricks Builder for creating Style Guides based on Advanced Themer
 * Version: 0.0.7-beta
 * Author: WP Easy
 * Author URI: https://wpeasy.au
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: advanced-themer-style-guide
 * Domain Path: /languages
 * Requires at least: 6.0
 * Tested up to: 6.7
 * Requires PHP: 7.4
 */

namespace AB\ATStyleGuide;

defined( 'ABSPATH' ) || exit;

// Plugin constants.
define( 'AT_STYLE_GUIDE_VERSION', '0.0.7-beta' );
define( 'AT_STYLE_GUIDE_PLUGIN_FILE', __FILE__ );
define( 'AT_STYLE_GUIDE_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'AT_STYLE_GUIDE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Load Composer autoloader.
if ( file_exists( AT_STYLE_GUIDE_PLUGIN_PATH . 'vendor/autoload.php' ) ) {
	require_once AT_STYLE_GUIDE_PLUGIN_PATH . 'vendor/autoload.php';
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

	// Check if Advanced Themer is active.
	if ( ! is_advanced_themer_active() ) {
		add_action( 'admin_notices', __NAMESPACE__ . '\\missing_at_notice' );
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
 * Check if Advanced Themer plugin is active.
 *
 * @return bool
 */
function is_advanced_themer_active(): bool {
	// Check for AT constant (defined in bricks-advanced-themer.php).
	if ( defined( 'BRICKS_ADVANCED_THEMER_PATH' ) ) {
		return true;
	}

	// Fallback: Check for AT classes.
	if ( class_exists( 'AT__Global_Colors' ) || class_exists( 'AT__Admin' ) ) {
		return true;
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
		<p><?php esc_html_e( 'Advanced Themer Style Guide requires Bricks Builder to be installed and activated.', 'advanced-themer-style-guide' ); ?></p>
	</div>
	<?php
}

/**
 * Admin notice for missing Advanced Themer.
 *
 * @return void
 */
function missing_at_notice(): void {
	?>
	<div class="notice notice-error">
		<p><?php esc_html_e( 'Advanced Themer Style Guide requires Advanced Themer for Bricks to be installed and activated.', 'advanced-themer-style-guide' ); ?></p>
	</div>
	<?php
}
