<?php
/**
 * Main Plugin class.
 *
 * @package AB\ATStyleGuide
 */

namespace AB\ATStyleGuide;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin main class.
 */
class Plugin {

	/**
	 * Plugin instance.
	 *
	 * @var Plugin|null
	 */
	private static ?Plugin $instance = null;

	/**
	 * Get plugin instance.
	 *
	 * @return Plugin
	 */
	public static function get_instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Constructor.
	 */
	private function __construct() {
		$this->init_hooks();
	}

	/**
	 * Initialize hooks.
	 *
	 * @return void
	 */
	private function init_hooks(): void {
		// Register Bricks elements.
		add_action( 'init', [ $this, 'register_bricks_elements' ], 11 );

		// Enqueue assets.
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_frontend_assets' ] );
	}

	/**
	 * Register Bricks Builder elements.
	 *
	 * @return void
	 */
	public function register_bricks_elements(): void {
		// Check if Bricks elements class exists.
		if ( ! class_exists( '\Bricks\Elements' ) ) {
			return;
		}

		// Register elements.
		$elements = [
			'color-swatch' => Elements\ColorSwatch::class,
		];

		foreach ( $elements as $name => $class ) {
			$file = AT_STYLE_GUIDE_PLUGIN_DIR . 'src/Elements/' . str_replace( '_', '', ucwords( str_replace( '-', '_', $name ), '_' ) ) . '.php';

			if ( class_exists( $class ) ) {
				\Bricks\Elements::register_element( $file, $name, $class );
			}
		}
	}

	/**
	 * Enqueue frontend assets.
	 *
	 * @return void
	 */
	public function enqueue_frontend_assets(): void {
		// Only load on frontend when Bricks is rendering.
		if ( ! function_exists( 'bricks_is_builder_preview' ) ) {
			return;
		}

		$dist_path = AT_STYLE_GUIDE_PLUGIN_DIR . 'assets/svelte/dist/';
		$dist_url  = AT_STYLE_GUIDE_PLUGIN_URL . 'assets/svelte/dist/';

		// Enqueue main Svelte app if it exists.
		if ( file_exists( $dist_path . 'main.js' ) ) {
			wp_enqueue_script(
				'at-style-guide-svelte',
				$dist_url . 'main.js',
				[],
				AT_STYLE_GUIDE_VERSION,
				true
			);

			// Localize script with data.
			wp_localize_script(
				'at-style-guide-svelte',
				'atStyleGuideData',
				[
					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'at_style_guide_nonce' ),
				]
			);
		}

		// Enqueue CSS if it exists.
		if ( file_exists( $dist_path . 'main.css' ) ) {
			wp_enqueue_style(
				'at-style-guide-styles',
				$dist_url . 'main.css',
				[],
				AT_STYLE_GUIDE_VERSION
			);
		}
	}
}
