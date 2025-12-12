<?php
/**
 * Color Swatch Element for Bricks Builder.
 *
 * Displays a color from Advanced Themer with its variations.
 *
 * @package AB\ATStyleGuide
 */

namespace AB\ATStyleGuide\Elements;

use AB\ATStyleGuide\ATColors;
use AB\ATStyleGuide\ATFrameworkDefaults;

defined( 'ABSPATH' ) || exit;

/**
 * Color Swatch Element.
 */
class ColorSwatch extends \Bricks\Element {

	/**
	 * Element category.
	 *
	 * @var string
	 */
	public $category = 'at style guide';

	/**
	 * Element name.
	 *
	 * @var string
	 */
	public $name = 'at-color-swatch';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-palette';

	/**
	 * Element scripts.
	 *
	 * @var array
	 */
	public $scripts = [];

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'AT Color Swatch', 'advanced-themer-style-guide' );
	}

	/**
	 * Get element keywords.
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'color', 'swatch', 'palette', 'style guide', 'advanced themer', 'variations' ];
	}

	/**
	 * Set control groups.
	 *
	 * @return void
	 */
	public function set_control_groups(): void {
		$this->control_groups['color'] = [
			'title' => esc_html__( 'Color Selection', 'advanced-themer-style-guide' ),
		];

		$this->control_groups['variations'] = [
			'title' => esc_html__( 'Variations', 'advanced-themer-style-guide' ),
		];

		$this->control_groups['display'] = [
			'title' => esc_html__( 'Display', 'advanced-themer-style-guide' ),
		];

		$this->control_groups['labels'] = [
			'title' => esc_html__( 'Labels', 'advanced-themer-style-guide' ),
		];
	}

	/**
	 * Set controls.
	 *
	 * @return void
	 */
	public function set_controls(): void {
		// Color Selection group.
		$this->controls['atColor'] = [
			'group'       => 'color',
			'label'       => esc_html__( 'Select Color', 'advanced-themer-style-guide' ),
			'type'        => 'select',
			'options'     => ATColors::get_root_colors_for_select(),
			'placeholder' => esc_html__( 'Select an AT color', 'advanced-themer-style-guide' ),
		];

		$this->controls['colorInfo'] = [
			'group'    => 'color',
			'type'     => 'info',
			'content'  => esc_html__( 'Colors are loaded from Advanced Themer Color Manager. Only root colors (not variations) are shown.', 'advanced-themer-style-guide' ),
			'required' => [ 'atColor', '=', '' ],
		];

		// Variations group.
		$this->controls['showVariations'] = [
			'group'   => 'variations',
			'label'   => esc_html__( 'Show Variations', 'advanced-themer-style-guide' ),
			'type'    => 'checkbox',
			'default' => true,
		];

		$this->controls['showLightShades'] = [
			'group'    => 'variations',
			'label'    => esc_html__( 'Show Light Shades (l-1 to l-6)', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'default'  => true,
			'required' => [ 'showVariations', '!=', '' ],
		];

		$this->controls['showDarkShades'] = [
			'group'    => 'variations',
			'label'    => esc_html__( 'Show Dark Shades (d-1 to d-6)', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'default'  => true,
			'required' => [ 'showVariations', '!=', '' ],
		];

		// Display group.
		$this->controls['layout'] = [
			'group'   => 'display',
			'label'   => esc_html__( 'Layout', 'advanced-themer-style-guide' ),
			'type'    => 'select',
			'options' => [
				'horizontal' => esc_html__( 'Horizontal', 'advanced-themer-style-guide' ),
				'vertical'   => esc_html__( 'Vertical', 'advanced-themer-style-guide' ),
			],
			'default' => 'horizontal',
			'inline'  => true,
		];

		$this->controls['swatchSize'] = [
			'group'       => 'display',
			'label'       => esc_html__( 'Swatch Size', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => 'var(--at-space--xl)',
			'css'         => [
				[
					'property' => 'width',
					'selector' => '.atsg-swatch__item',
				],
				[
					'property' => 'height',
					'selector' => '.atsg-swatch__item',
				],
			],
		];

		$this->controls['baseSizeMultiplier'] = [
			'group'       => 'display',
			'label'       => esc_html__( 'Base Color Size Multiplier', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'default'     => 1.5,
			'step'        => 0.1,
			'min'         => 1,
			'max'         => 3,
			'description' => esc_html__( 'Make the base color larger than variations', 'advanced-themer-style-guide' ),
		];

		$this->controls['swatchBorderRadius'] = [
			'group'       => 'display',
			'label'       => esc_html__( 'Border Radius', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => 'var(--at-radius--s)',
			'css'         => [
				[
					'property' => 'border-radius',
					'selector' => '.atsg-swatch__item',
				],
			],
		];

		$this->controls['gap'] = [
			'group'       => 'display',
			'label'       => esc_html__( 'Gap', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => 'var(--at-space--xs)',
			'css'         => [
				[
					'property' => 'gap',
					'selector' => '.atsg-swatch__row',
				],
			],
		];

		// Labels group.
		$this->controls['showColorName'] = [
			'group'   => 'labels',
			'label'   => esc_html__( 'Show Color Name', 'advanced-themer-style-guide' ),
			'type'    => 'checkbox',
			'default' => true,
		];

		$this->controls['showCssVariable'] = [
			'group'   => 'labels',
			'label'   => esc_html__( 'Show CSS Variable', 'advanced-themer-style-guide' ),
			'type'    => 'checkbox',
			'default' => true,
		];

		$this->controls['showHexValue'] = [
			'group'   => 'labels',
			'label'   => esc_html__( 'Show Hex/Color Value', 'advanced-themer-style-guide' ),
			'type'    => 'checkbox',
			'default' => false,
		];

		$this->controls['showShadeLabel'] = [
			'group'   => 'labels',
			'label'   => esc_html__( 'Show Shade Labels', 'advanced-themer-style-guide' ),
			'type'    => 'checkbox',
			'default' => true,
		];
	}

	/**
	 * Render element.
	 *
	 * @return void
	 */
	public function render(): void {
		// Check for ATF variables.
		if ( ! ATFrameworkDefaults::has_at_variables() ) {
			echo ATFrameworkDefaults::render_warning(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}

		$settings = $this->settings;

		$color_id = $settings['atColor'] ?? '';

		if ( empty( $color_id ) ) {
			if ( bricks_is_builder() ) {
				echo '<div class="atsg-swatch__placeholder">';
				echo esc_html__( 'Please select a color from Advanced Themer', 'advanced-themer-style-guide' );
				echo '</div>';
			}
			return;
		}

		$root_color = ATColors::get_root_color( $color_id );

		if ( ! $root_color ) {
			if ( bricks_is_builder() ) {
				echo '<div class="atsg-swatch__placeholder">';
				echo esc_html__( 'Selected color not found. It may have been deleted from Advanced Themer.', 'advanced-themer-style-guide' );
				echo '</div>';
			}
			return;
		}

		// Settings.
		$show_variations   = $settings['showVariations'] ?? true;
		$show_light_shades = $settings['showLightShades'] ?? true;
		$show_dark_shades  = $settings['showDarkShades'] ?? true;
		$layout            = $settings['layout'] ?? 'horizontal';
		$base_multiplier   = floatval( $settings['baseSizeMultiplier'] ?? 1.5 );
		$show_color_name   = $settings['showColorName'] ?? true;
		$show_css_variable = $settings['showCssVariable'] ?? true;
		$show_hex_value    = $settings['showHexValue'] ?? false;
		$show_shade_label  = $settings['showShadeLabel'] ?? true;

		// Get variations if enabled.
		$variations = [];
		if ( $show_variations && ! empty( $root_color['shadeChildren'] ) ) {
			$all_variations = ATColors::get_color_variations( $color_id );

			foreach ( $all_variations as $suffix => $variation ) {
				// Filter by light/dark preference.
				if ( 'base' === $suffix ) {
					$variations[ $suffix ] = $variation;
				} elseif ( str_starts_with( $suffix, 'l-' ) && $show_light_shades ) {
					$variations[ $suffix ] = $variation;
				} elseif ( str_starts_with( $suffix, 'd-' ) && $show_dark_shades ) {
					$variations[ $suffix ] = $variation;
				}
			}
		} else {
			// Just show base color.
			$variations['base'] = [
				'id'       => $root_color['id'],
				'name'     => $root_color['name'],
				'suffix'   => 'base',
				'raw'      => $root_color['raw'],
				'hex'      => $root_color['hex'],
				'rawValue' => $root_color['rawValue'],
			];
		}

		// Build output.
		$root_classes = [ 'atsg-swatch', 'atsg-swatch--' . $layout ];
		$this->set_attribute( '_root', 'class', $root_classes );

		$output = "<div {$this->render_attributes( '_root' )}>";

		// Color header.
		if ( $show_color_name || $show_css_variable ) {
			$output .= '<div class="atsg-swatch__header">';

			if ( $show_color_name ) {
				$output .= '<h4 class="atsg-swatch__title">' . esc_html( $root_color['label'] ) . '</h4>';
			}

			if ( $show_css_variable ) {
				$output .= '<code class="atsg-swatch__variable">' . esc_html( $root_color['raw'] ) . '</code>';
			}

			$output .= '</div>';
		}

		// Color swatches row.
		$output .= '<div class="atsg-swatch__row">';

		foreach ( $variations as $suffix => $variation ) {
			$is_base     = 'base' === $suffix;
			$item_class  = 'atsg-swatch__item';
			$item_class .= $is_base ? ' atsg-swatch__item--base' : '';

			// Use CSS variable for background.
			$css_var    = $variation['raw'];
			$item_style = "background-color: {$css_var};";

			// Apply base multiplier.
			if ( $is_base && $base_multiplier > 1 ) {
				$item_style .= " transform: scale({$base_multiplier}); z-index: 1;";
			}

			$output .= '<div class="' . esc_attr( $item_class ) . '" style="' . esc_attr( $item_style ) . '"';
			$output .= ' title="' . esc_attr( $css_var ) . '">';

			if ( $show_shade_label && ! $is_base ) {
				$output .= '<span class="atsg-swatch__shade-label">' . esc_html( $suffix ) . '</span>';
			}

			$output .= '</div>';
		}

		$output .= '</div>'; // .atsg-swatch__row

		// Hex value if enabled.
		if ( $show_hex_value ) {
			$hex_value = ATColors::get_color_value( $root_color, 'light' );
			if ( $hex_value ) {
				$output .= '<div class="atsg-swatch__hex">';
				$output .= '<span class="atsg-swatch__hex-label">' . esc_html__( 'Light:', 'advanced-themer-style-guide' ) . '</span> ';
				$output .= '<code>' . esc_html( $hex_value ) . '</code>';

				$dark_value = ATColors::get_color_value( $root_color, 'dark' );
				if ( $dark_value && $dark_value !== $hex_value ) {
					$output .= ' <span class="atsg-swatch__hex-label">' . esc_html__( 'Dark:', 'advanced-themer-style-guide' ) . '</span> ';
					$output .= '<code>' . esc_html( $dark_value ) . '</code>';
				}

				$output .= '</div>';
			}
		}

		$output .= '</div>'; // .atsg-swatch

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Enqueue element styles.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {
		wp_register_style(
			'at-color-swatch',
			false,
			[],
			AT_STYLE_GUIDE_VERSION
		);
		wp_add_inline_style( 'at-color-swatch', $this->get_element_css() );
		wp_enqueue_style( 'at-color-swatch' );
	}

	/**
	 * Get inline CSS for the element.
	 *
	 * @return string
	 */
	private function get_element_css(): string {
		return '
			.atsg-swatch {
				display: flex;
				flex-direction: column;
				gap: var(--at-space--s, 1rem);
			}

			.atsg-swatch__placeholder {
				padding: var(--at-space--l, 2rem);
				background: var(--at-neutral-t-6, #f3f4f6);
				border: var(--at-border-width, 2px) dashed var(--at-border-color, #d1d5db);
				border-radius: var(--at-radius--s, 8px);
				text-align: center;
				color: var(--at-neutral-d-2, #6b7280);
			}

			.atsg-swatch__header {
				display: flex;
				flex-direction: column;
				gap: var(--at-space--3xs, 0.25rem);
			}

			.atsg-swatch__title {
				margin: 0;
				font-size: var(--at-text--m, 1.125rem);
				font-weight: 600;
			}

			.atsg-swatch__variable {
				font-size: var(--at-text--2xs, 0.75rem);
				color: var(--at-neutral-d-2, #6b7280);
				background: var(--at-neutral-t-6, #f3f4f6);
				padding: var(--at-space--3xs, 0.25rem) var(--at-space--xs, 0.5rem);
				border-radius: var(--at-radius--xs, 4px);
				width: fit-content;
			}

			.atsg-swatch__row {
				display: flex;
				flex-wrap: wrap;
				align-items: center;
				gap: var(--at-space--2xs, 8px);
			}

			.atsg-swatch--vertical .atsg-swatch__row {
				flex-direction: column;
			}

			.atsg-swatch__item {
				width: 60px;
				height: 60px;
				border-radius: var(--at-radius--s, 8px);
				box-shadow: var(--at-shadow--s, 0 1px 3px rgba(0, 0, 0, 0.1)), inset 0 0 0 1px rgba(0, 0, 0, 0.05);
				position: relative;
				display: flex;
				align-items: flex-end;
				justify-content: center;
				transition: transform 0.2s ease;
			}

			.atsg-swatch__item:hover {
				box-shadow: var(--at-shadow--m, 0 4px 6px rgba(0, 0, 0, 0.15)), inset 0 0 0 1px rgba(0, 0, 0, 0.05);
			}

			.atsg-swatch__item--base {
				box-shadow: var(--at-shadow--s, 0 2px 4px rgba(0, 0, 0, 0.15)), inset 0 0 0 1px rgba(0, 0, 0, 0.05);
			}

			.atsg-swatch__shade-label {
				font-size: var(--at-text--3xs, 0.625rem);
				font-weight: 500;
				color: rgba(255, 255, 255, 0.9);
				text-shadow: 0 1px 2px rgba(0, 0, 0, 0.3);
				padding: var(--at-space--3xs, 0.125rem) var(--at-space--3xs, 0.25rem);
				background: rgba(0, 0, 0, 0.2);
				border-radius: var(--at-radius--2xs, 2px);
				margin-bottom: 4px;
			}

			.atsg-swatch__hex {
				font-size: var(--at-text--2xs, 0.75rem);
				color: var(--at-neutral-d-2, #6b7280);
			}

			.atsg-swatch__hex code {
				background: var(--at-neutral-t-6, #f3f4f6);
				padding: var(--at-space--3xs, 0.125rem) var(--at-space--2xs, 0.375rem);
				border-radius: var(--at-radius--xs, 4px);
			}

			.atsg-swatch__hex-label {
				font-weight: 500;
			}
		';
	}
}
