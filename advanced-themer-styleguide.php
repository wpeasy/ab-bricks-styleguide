<?php
/**
 * Plugin Name: Advanced Themer Style Guide
 * Description: Adds Svelte based Elements to Bricks Builder for creating Style Guides based on Advanced Themer
 * Version: 0.0.1-beta
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

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Plugin constants.
define( 'AT_STYLE_GUIDE_VERSION', '0.0.1-beta' );
define( 'AT_STYLE_GUIDE_PLUGIN_FILE', __FILE__ );
define( 'AT_STYLE_GUIDE_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'AT_STYLE_GUIDE_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Load Composer autoloader.
if ( file_exists( AT_STYLE_GUIDE_PLUGIN_DIR . 'vendor/autoload.php' ) ) {
	require_once AT_STYLE_GUIDE_PLUGIN_DIR . 'vendor/autoload.php';
}

/**
 * Initialize the plugin.
 *
 * @return void
 */
function init(): void {
	// Check if Bricks Builder is active.
	if ( ! defined( 'BRICKS_VERSION' ) ) {
		add_action( 'admin_notices', __NAMESPACE__ . '\\missing_bricks_notice' );
		return;
	}

	// Check if Advanced Themer is active.
	if ( ! is_advanced_themer_active() ) {
		add_action( 'admin_notices', __NAMESPACE__ . '\\missing_at_notice' );
		return;
	}

	// Initialize the plugin.
	Plugin::get_instance();
}
add_action( 'plugins_loaded', __NAMESPACE__ . '\\init' );

/**
 * Check if Advanced Themer plugin is active.
 *
 * @return bool
 */
function is_advanced_themer_active(): bool {
	// Check for AT class or option that indicates AT is active.
	if ( class_exists( 'AT__Init' ) || class_exists( '\AT__Init' ) ) {
		return true;
	}

	// Alternative check: AT stores colors in this option.
	$palettes = get_option( 'bricks_color_palette', [] );
	if ( ! empty( $palettes ) ) {
		// Check if any palette has the AT structure (brxc_ prefix).
		foreach ( $palettes as $palette ) {
			if ( isset( $palette['id'] ) && str_starts_with( $palette['id'], 'brxc_' ) ) {
				return true;
			}
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
