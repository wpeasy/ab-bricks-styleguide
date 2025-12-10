<?php
/**
 * Advanced Themer Colors Helper.
 *
 * Provides access to AT Color Manager color palettes and variations.
 *
 * @package AB\ATStyleGuide
 */

namespace AB\ATStyleGuide;

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * AT Colors Helper class.
 */
class ATColors {

	/**
	 * Shade variation suffixes for lighter shades.
	 */
	public const LIGHT_SHADES = [ 'l-1', 'l-2', 'l-3', 'l-4', 'l-5', 'l-6' ];

	/**
	 * Shade variation suffixes for darker shades.
	 */
	public const DARK_SHADES = [ 'd-1', 'd-2', 'd-3', 'd-4', 'd-5', 'd-6' ];

	/**
	 * Get all color palettes from Advanced Themer.
	 *
	 * @return array Array of palettes.
	 */
	public static function get_palettes(): array {
		return get_option( 'bricks_color_palette', [] );
	}

	/**
	 * Get all root colors (excluding variations) from all enabled palettes.
	 *
	 * @return array Array of root colors with palette info.
	 */
	public static function get_root_colors(): array {
		$palettes    = self::get_palettes();
		$root_colors = [];

		foreach ( $palettes as $palette ) {
			// Skip disabled palettes.
			if ( isset( $palette['status'] ) && 'disabled' === $palette['status'] ) {
				continue;
			}

			$palette_name   = $palette['name'] ?? 'Unnamed Palette';
			$palette_prefix = $palette['prefix'] ?? '';

			if ( empty( $palette['colors'] ) ) {
				continue;
			}

			foreach ( $palette['colors'] as $color ) {
				// Skip variation colors (they contain shade suffixes).
				if ( self::is_shade_variation( $color['name'] ?? '' ) ) {
					continue;
				}

				$color_id   = $color['id'] ?? '';
				$color_name = $color['name'] ?? '';

				if ( empty( $color_id ) ) {
					continue;
				}

				$root_colors[ $color_id ] = [
					'id'             => $color_id,
					'name'           => $color_name,
					'label'          => ucwords( str_replace( [ '-', '_' ], ' ', $color_name ) ),
					'palette_name'   => $palette_name,
					'palette_prefix' => $palette_prefix,
					'raw'            => $color['raw'] ?? '',
					'hex'            => $color['hex'] ?? '',
					'rawValue'       => $color['rawValue'] ?? [],
					'shadeChildren'  => $color['shadeChildren'] ?? false,
				];
			}
		}

		return $root_colors;
	}

	/**
	 * Get root colors formatted for Bricks select control.
	 *
	 * @return array Associative array of color_id => label.
	 */
	public static function get_root_colors_for_select(): array {
		$root_colors = self::get_root_colors();
		$options     = [
			'' => esc_html__( '— Select Color —', 'advanced-themer-style-guide' ),
		];

		foreach ( $root_colors as $color_id => $color ) {
			$label = $color['label'];

			// Add palette name if there are multiple palettes.
			if ( ! empty( $color['palette_name'] ) ) {
				$label = $color['palette_name'] . ' → ' . $label;
			}

			$options[ $color_id ] = $label;
		}

		return $options;
	}

	/**
	 * Get a specific root color by ID.
	 *
	 * @param string $color_id The color ID.
	 * @return array|null Color data or null if not found.
	 */
	public static function get_root_color( string $color_id ): ?array {
		$root_colors = self::get_root_colors();
		return $root_colors[ $color_id ] ?? null;
	}

	/**
	 * Get all variations for a root color.
	 *
	 * @param string $color_id The root color ID.
	 * @return array Array of variation colors.
	 */
	public static function get_color_variations( string $color_id ): array {
		$root_color = self::get_root_color( $color_id );

		if ( ! $root_color || empty( $root_color['shadeChildren'] ) ) {
			return [];
		}

		$palettes   = self::get_palettes();
		$variations = [];
		$color_name = $root_color['name'];

		foreach ( $palettes as $palette ) {
			if ( empty( $palette['colors'] ) ) {
				continue;
			}

			foreach ( $palette['colors'] as $color ) {
				$name = $color['name'] ?? '';

				// Check if this is a variation of the root color.
				if ( self::is_variation_of( $name, $color_name ) ) {
					$shade_suffix = self::get_shade_suffix( $name, $color_name );

					$variations[ $shade_suffix ] = [
						'id'       => $color['id'] ?? '',
						'name'     => $name,
						'suffix'   => $shade_suffix,
						'raw'      => $color['raw'] ?? '',
						'hex'      => $color['hex'] ?? '',
						'rawValue' => $color['rawValue'] ?? [],
					];
				}
			}
		}

		// Sort variations by shade order.
		$ordered = [];
		$order   = array_merge( array_reverse( self::LIGHT_SHADES ), [ 'base' ], self::DARK_SHADES );

		foreach ( $order as $suffix ) {
			if ( 'base' === $suffix ) {
				$ordered['base'] = [
					'id'       => $root_color['id'],
					'name'     => $root_color['name'],
					'suffix'   => 'base',
					'raw'      => $root_color['raw'],
					'hex'      => $root_color['hex'],
					'rawValue' => $root_color['rawValue'],
				];
			} elseif ( isset( $variations[ $suffix ] ) ) {
				$ordered[ $suffix ] = $variations[ $suffix ];
			}
		}

		return $ordered;
	}

	/**
	 * Check if a color name is a shade variation.
	 *
	 * @param string $name The color name.
	 * @return bool True if it's a shade variation.
	 */
	public static function is_shade_variation( string $name ): bool {
		$all_shades = array_merge( self::LIGHT_SHADES, self::DARK_SHADES );

		foreach ( $all_shades as $shade ) {
			if ( str_ends_with( $name, '-' . $shade ) ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Check if a color name is a variation of a root color.
	 *
	 * @param string $variation_name The potential variation name.
	 * @param string $root_name      The root color name.
	 * @return bool True if it's a variation of the root.
	 */
	public static function is_variation_of( string $variation_name, string $root_name ): bool {
		$all_shades = array_merge( self::LIGHT_SHADES, self::DARK_SHADES );

		foreach ( $all_shades as $shade ) {
			if ( $variation_name === $root_name . '-' . $shade ) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Get the shade suffix from a variation name.
	 *
	 * @param string $variation_name The variation color name.
	 * @param string $root_name      The root color name.
	 * @return string The shade suffix (e.g., 'l-1', 'd-2').
	 */
	public static function get_shade_suffix( string $variation_name, string $root_name ): string {
		$prefix = $root_name . '-';

		if ( str_starts_with( $variation_name, $prefix ) ) {
			return substr( $variation_name, strlen( $prefix ) );
		}

		return '';
	}

	/**
	 * Get the CSS variable name for a color.
	 *
	 * @param array $color The color data.
	 * @return string The CSS variable (e.g., 'var(--primary-blue)').
	 */
	public static function get_css_variable( array $color ): string {
		return $color['raw'] ?? '';
	}

	/**
	 * Get the resolved color value (hex or from rawValue).
	 *
	 * @param array  $color The color data.
	 * @param string $mode  'light' or 'dark'.
	 * @return string The color value.
	 */
	public static function get_color_value( array $color, string $mode = 'light' ): string {
		// Try rawValue first.
		if ( ! empty( $color['rawValue'][ $mode ] ) ) {
			return $color['rawValue'][ $mode ];
		}

		// Fall back to hex.
		if ( ! empty( $color['hex'] ) ) {
			return $color['hex'];
		}

		return '';
	}
}
