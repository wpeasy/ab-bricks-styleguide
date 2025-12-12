<?php
/**
 * Colors Item Element for Bricks Builder.
 *
 * Individual color swatch grid with base, dark, light, and transparency variations.
 *
 * @package AB\ATStyleGuide
 */

namespace AB\ATStyleGuide\Elements;

use AB\ATStyleGuide\ATColors;

defined( 'ABSPATH' ) || exit;

/**
 * Colors Item Element.
 */
class ColorsItem extends \Bricks\Element {

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
	public $name = 'at-colors-item';

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
	public $scripts = [ 'atColorsItemInit' ];

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Color Item', 'advanced-themer-style-guide' );
	}

	/**
	 * Get element keywords.
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'color', 'swatch', 'palette', 'item' ];
	}

	/**
	 * Set control groups.
	 *
	 * @return void
	 */
	public function set_control_groups(): void {
		$this->control_groups['color'] = [
			'title' => esc_html__( 'Color Selection', 'advanced-themer-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['variations'] = [
			'title' => esc_html__( 'Variations', 'advanced-themer-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['display'] = [
			'title' => esc_html__( 'Display', 'advanced-themer-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['swatchStyle'] = [
			'title' => esc_html__( 'Swatch Style', 'advanced-themer-style-guide' ),
			'tab'   => 'content',
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
			'content'  => esc_html__( 'Colors are loaded from Advanced Themer Color Manager.', 'advanced-themer-style-guide' ),
			'required' => [ 'atColor', '=', '' ],
		];

		// Variations group - which columns to show.
		$this->controls['hideDarkVariants'] = [
			'group'    => 'variations',
			'label'    => esc_html__( 'Hide Dark Variants Column', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideLightVariants'] = [
			'group'    => 'variations',
			'label'    => esc_html__( 'Hide Light Variants Column', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideTransparencyVariants'] = [
			'group'    => 'variations',
			'label'    => esc_html__( 'Hide Transparency Variants Column', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['variationCount'] = [
			'group'       => 'variations',
			'label'       => esc_html__( 'Variation Count', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'min'         => 1,
			'max'         => 6,
			'default'     => 6,
			'description' => esc_html__( 'Number of variations per column (1-6)', 'advanced-themer-style-guide' ),
		];

		// Display controls.
		$this->controls['hideColorName'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Color Name', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		// Swatch style controls.
		$this->controls['swatchSize'] = [
			'group'       => 'swatchStyle',
			'label'       => esc_html__( 'Variant Swatch Size', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => 'var(--at-space--xl)',
			'css'         => [
				[
					'property' => 'width',
					'selector' => '.atsg-colors-item__swatch',
				],
				[
					'property' => 'height',
					'selector' => '.atsg-colors-item__swatch',
				],
				[
					'property'  => 'min-width',
					'selector'  => '.atsg-colors-item__swatch',
					'important' => true,
				],
			],
		];

		$this->controls['baseSize'] = [
			'group'       => 'swatchStyle',
			'label'       => esc_html__( 'Base Swatch Width', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => 'var(--at-space--xl)',
			'css'         => [
				[
					'property'  => 'width',
					'selector'  => '.atsg-colors-item__base-column',
					'important' => true,
				],
				[
					'property'  => 'width',
					'selector'  => '.atsg-colors-item__base',
					'important' => true,
				],
			],
		];

		$this->controls['swatchBorderRadius'] = [
			'group'       => 'swatchStyle',
			'label'       => esc_html__( 'Border Radius', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => 'var(--at-radius--m)',
			'css'         => [
				[
					'property' => 'border-radius',
					'selector' => '.atsg-colors-item__swatch',
				],
				[
					'property' => 'border-radius',
					'selector' => '.atsg-colors-item__base',
				],
			],
		];

		$this->controls['gridGap'] = [
			'group'       => 'swatchStyle',
			'label'       => esc_html__( 'Grid Gap', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => '0.25em',
			'css'         => [
				[
					'property' => 'gap',
					'selector' => '.atsg-colors-item__grid',
				],
				[
					'property' => 'gap',
					'selector' => '.atsg-colors-item__column',
				],
			],
		];

		$this->controls['labelTypography'] = [
			'group' => 'swatchStyle',
			'label' => esc_html__( 'Label Typography', 'advanced-themer-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.atsg-colors-item__label',
				],
			],
		];
	}

	/**
	 * Render element.
	 *
	 * @return void
	 */
	public function render(): void {
		$settings = $this->settings;

		$color_id = $settings['atColor'] ?? '';

		if ( empty( $color_id ) ) {
			if ( bricks_is_builder() ) {
				echo '<div class="atsg-colors-item__placeholder">';
				echo esc_html__( 'Please select a color from Advanced Themer', 'advanced-themer-style-guide' );
				echo '</div>';
			}
			return;
		}

		$root_color = ATColors::get_root_color( $color_id );

		if ( ! $root_color ) {
			if ( bricks_is_builder() ) {
				echo '<div class="atsg-colors-item__placeholder">';
				echo esc_html__( 'Selected color not found.', 'advanced-themer-style-guide' );
				echo '</div>';
			}
			return;
		}

		// Check if this color has shade variations (contextual colors don't).
		$has_shades = ! empty( $root_color['shadeChildren'] );

		// Settings - only show variants if the color has shadeChildren.
		$show_dark         = $has_shades && ! isset( $settings['hideDarkVariants'] );
		$show_light        = $has_shades && ! isset( $settings['hideLightVariants'] );
		$show_transparency = $has_shades && ! isset( $settings['hideTransparencyVariants'] );
		$show_color_name   = ! isset( $settings['hideColorName'] );
		$variation_count   = intval( $settings['variationCount'] ?? 6 );
		$variation_count   = max( 1, min( 6, $variation_count ) );

		// Get color name/prefix for building CSS variables.
		$color_name   = $root_color['name'];
		$color_prefix = $root_color['palette_prefix'] ?? '';
		$css_var_base = $root_color['raw']; // e.g., var(--primary)

		// Build the CSS variable prefix (without var() wrapper).
		// Extract variable name from raw value like "var(--primary)".
		preg_match( '/var\(([^)]+)\)/', $css_var_base, $matches );
		$var_name = $matches[1] ?? '--' . $color_name;

		$root_classes = [ 'atsg-colors-item' ];
		if ( ! $has_shades ) {
			$root_classes[] = 'atsg-colors-item--no-variants';
		}

		$this->set_attribute( '_root', 'class', $root_classes );
		$this->set_attribute( '_root', 'data-color', esc_attr( $color_id ) );
		$this->set_attribute( '_root', 'data-color-name', esc_attr( $root_color['label'] ) );
		$this->set_attribute( '_root', 'data-has-shades', $has_shades ? 'true' : 'false' );

		$output = "<div {$this->render_attributes( '_root' )}>";

		// Color name label above the grid.
		if ( $show_color_name ) {
			$output .= '<div class="atsg-colors-item__label">' . esc_html( $root_color['label'] ) . '</div>';
		}

		// Grid container.
		$output .= '<div class="atsg-colors-item__grid">';

		// Column 1: Base color (full height).
		$output .= '<div class="atsg-colors-item__base-column">';
		$output .= $this->render_swatch( $var_name, 'base', $root_color['label'], true );
		$output .= '</div>';

		// Column 2: Dark variants.
		if ( $show_dark ) {
			$output .= '<div class="atsg-colors-item__column atsg-colors-item__column--dark" data-variant="dark">';
			for ( $i = 1; $i <= $variation_count; $i++ ) {
				$suffix   = "d-{$i}";
				$var      = "{$var_name}-{$suffix}";
				$label    = $root_color['label'] . ' ' . strtoupper( $suffix );
				$output  .= $this->render_swatch( $var, $suffix, $label, false );
			}
			$output .= '</div>';
		}

		// Column 3: Light variants.
		if ( $show_light ) {
			$output .= '<div class="atsg-colors-item__column atsg-colors-item__column--light" data-variant="light">';
			for ( $i = 1; $i <= $variation_count; $i++ ) {
				$suffix   = "l-{$i}";
				$var      = "{$var_name}-{$suffix}";
				$label    = $root_color['label'] . ' ' . strtoupper( $suffix );
				$output  .= $this->render_swatch( $var, $suffix, $label, false );
			}
			$output .= '</div>';
		}

		// Column 4: Transparency variants.
		if ( $show_transparency ) {
			$output .= '<div class="atsg-colors-item__column atsg-colors-item__column--transparency" data-variant="transparency">';
			for ( $i = 1; $i <= $variation_count; $i++ ) {
				$suffix   = "t-{$i}";
				$var      = "{$var_name}-{$suffix}";
				$label    = $root_color['label'] . ' ' . strtoupper( $suffix );
				$output  .= $this->render_swatch( $var, $suffix, $label, false );
			}
			$output .= '</div>';
		}

		$output .= '</div>'; // .atsg-colors-item__grid

		$output .= '</div>'; // .atsg-colors-item

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Render a single swatch with data attributes for the context menu.
	 *
	 * @param string $css_var   The CSS variable name (without var()).
	 * @param string $suffix    The variation suffix (base, d-1, l-1, t-1, etc.).
	 * @param string $label     The display label.
	 * @param bool   $is_base   Whether this is the base color.
	 * @return string HTML output.
	 */
	private function render_swatch( string $css_var, string $suffix, string $label, bool $is_base ): string {
		$class = $is_base ? 'atsg-colors-item__base' : 'atsg-colors-item__swatch';

		$output  = '<div class="' . esc_attr( $class ) . '"';
		$output .= ' style="background-color: var(' . esc_attr( $css_var ) . ');"';
		$output .= ' data-var="' . esc_attr( $css_var ) . '"';
		$output .= ' data-suffix="' . esc_attr( $suffix ) . '"';
		$output .= ' data-label="' . esc_attr( $label ) . '"';
		$output .= ' tabindex="0"';
		$output .= ' role="button"';
		$output .= ' aria-label="' . esc_attr( $label ) . '"';
		$output .= '>';

		// Context menu (hidden by default, shown on hover/click).
		$output .= '<div class="atsg-colors-item__menu">';
		$output .= '<div class="atsg-colors-item__menu-header">' . esc_html( $label ) . '</div>';
		$output .= '<button type="button" class="atsg-colors-item__menu-var" data-action="copy-var" data-var-value="' . esc_attr( 'var(' . $css_var . ')' ) . '">';
		$output .= '<code>' . esc_html( 'var(' . $css_var . ')' ) . '</code>';
		$output .= '</button>';
		$output .= '<div class="atsg-colors-item__menu-actions">';
		$output .= '<button type="button" class="atsg-colors-item__menu-btn" data-action="copy-hex">';
		$output .= '<span class="atsg-colors-item__menu-btn-icon">📋</span> ';
		$output .= esc_html__( 'Copy', 'advanced-themer-style-guide' );
		$output .= ' <span class="atsg-colors-item__menu-value"></span>';
		$output .= '</button>';
		$output .= '<div class="atsg-colors-item__menu-more">';
		$output .= '<button type="button" class="atsg-colors-item__menu-btn atsg-colors-item__menu-btn--secondary" data-action="copy-rgb">';
		$output .= esc_html__( 'RGB', 'advanced-themer-style-guide' );
		$output .= '</button>';
		$output .= '<button type="button" class="atsg-colors-item__menu-btn atsg-colors-item__menu-btn--secondary" data-action="copy-hsl">';
		$output .= esc_html__( 'HSL', 'advanced-themer-style-guide' );
		$output .= '</button>';
		$output .= '<button type="button" class="atsg-colors-item__menu-btn atsg-colors-item__menu-btn--secondary" data-action="copy-oklch">';
		$output .= esc_html__( 'OKLCH', 'advanced-themer-style-guide' );
		$output .= '</button>';
		$output .= '</div>'; // .atsg-colors-item__menu-more
		$output .= '</div>'; // .atsg-colors-item__menu-actions

		// Contrast checker section.
		$output .= '<div class="atsg-colors-item__menu-contrast">';
		$output .= '<div class="atsg-colors-item__menu-contrast-header">' . esc_html__( 'Contrast', 'advanced-themer-style-guide' ) . '</div>';
		$output .= '<div class="atsg-colors-item__menu-contrast-row">';
		$output .= '<span class="atsg-colors-item__menu-contrast-label">' . esc_html__( 'White text', 'advanced-themer-style-guide' ) . '</span>';
		$output .= '<span class="atsg-colors-item__menu-contrast-value" data-contrast="white"></span>';
		$output .= '<span class="atsg-colors-item__menu-contrast-badge" data-contrast-badge="white"></span>';
		$output .= '</div>';
		$output .= '<div class="atsg-colors-item__menu-contrast-row">';
		$output .= '<span class="atsg-colors-item__menu-contrast-label">' . esc_html__( 'Black text', 'advanced-themer-style-guide' ) . '</span>';
		$output .= '<span class="atsg-colors-item__menu-contrast-value" data-contrast="black"></span>';
		$output .= '<span class="atsg-colors-item__menu-contrast-badge" data-contrast-badge="black"></span>';
		$output .= '</div>';
		$output .= '</div>'; // .atsg-colors-item__menu-contrast

		$output .= '</div>'; // .atsg-colors-item__menu

		$output .= '</div>';

		return $output;
	}

	/**
	 * Enqueue element styles.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {
		wp_register_style(
			'at-colors-item',
			false,
			[],
			AT_STYLE_GUIDE_VERSION
		);
		wp_add_inline_style( 'at-colors-item', $this->get_element_css() );
		wp_enqueue_style( 'at-colors-item' );
	}

	/**
	 * Get inline CSS for the element.
	 *
	 * @return string
	 */
	private function get_element_css(): string {
		return '
			.atsg-colors-item {
				display: flex;
				flex-direction: column;
				gap: var(--at-space--xs, 0.75rem);
			}

			.atsg-colors-item__placeholder {
				padding: var(--at-space--l, 2rem);
				background: var(--at-neutral-t-6, #f3f4f6);
				border: var(--at-border-width, 2px) dashed var(--at-border-color, #d1d5db);
				border-radius: var(--at-radius--s, 8px);
				text-align: center;
				color: var(--at-neutral-d-2, #6b7280);
			}

			.atsg-colors-item__label {
				font-size: var(--at-text--m, 1.125rem);
				font-weight: 600;
				color: var(--at-neutral-d-4, #1f2937);
			}

			.atsg-colors-item__grid {
				display: flex;
				flex-wrap: nowrap;
				gap: var(--at-space--2xs, 4px);
			}

			.atsg-colors-item__base-column {
				display: flex;
				flex-shrink: 0;
			}

			.atsg-colors-item__base {
				width: var(--at-space--xl, 80px);
				min-height: 100%;
				border-radius: var(--at-radius--m, 8px);
				box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.1);
				position: relative;
				cursor: pointer;
				transition: box-shadow 0.2s ease;
			}

			.atsg-colors-item__base:hover,
			.atsg-colors-item__base:focus {
				box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.1), 0 0 0 3px rgba(59, 130, 246, 0.5);
				outline: none;
			}

			.atsg-colors-item__column {
				display: flex;
				flex-direction: column;
				flex-shrink: 0;
				gap: var(--at-space--2xs, 4px);
			}

			.atsg-colors-item__swatch {
				width: var(--at-space--xl, 48px);
				height: var(--at-space--xl, 48px);
				border-radius: var(--at-radius--m, 8px);
				box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.1);
				position: relative;
				cursor: pointer;
				transition: box-shadow 0.2s ease;
			}

			.atsg-colors-item__swatch:hover,
			.atsg-colors-item__swatch:focus {
				box-shadow: inset 0 0 0 1px rgba(0, 0, 0, 0.1), 0 0 0 3px rgba(59, 130, 246, 0.5);
				outline: none;
				z-index: 10;
			}

			/* Click hint - shown on hover */
			.atsg-colors-item__hint {
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				background: rgba(0, 0, 0, 0.7);
				color: #fff;
				font-size: 10px;
				font-weight: 600;
				text-transform: uppercase;
				letter-spacing: 0.05em;
				padding: 3px 6px;
				border-radius: 3px;
				opacity: 0;
				transition: opacity 0.15s ease;
				pointer-events: none;
			}

			.atsg-colors-item__swatch:hover .atsg-colors-item__hint,
			.atsg-colors-item__base:hover .atsg-colors-item__hint {
				opacity: 1;
			}

			/* Transparency pattern background for transparent swatches */
			.atsg-colors-item__column:last-child .atsg-colors-item__swatch {
				background-image:
					linear-gradient(45deg, #ccc 25%, transparent 25%),
					linear-gradient(-45deg, #ccc 25%, transparent 25%),
					linear-gradient(45deg, transparent 75%, #ccc 75%),
					linear-gradient(-45deg, transparent 75%, #ccc 75%);
				background-size: 8px 8px;
				background-position: 0 0, 0 4px, 4px -4px, -4px 0px;
			}

			.atsg-colors-item__column:last-child .atsg-colors-item__swatch::after {
				content: "";
				position: absolute;
				inset: 0;
				border-radius: inherit;
				background-color: inherit;
			}

			/* Context Menu - positioned by JavaScript */
			.atsg-colors-item__menu {
				position: fixed;
				background: var(--at-white, #ffffff);
				border-radius: var(--at-radius--s, 8px);
				box-shadow: var(--at-shadow--l, 0 10px 25px rgba(0, 0, 0, 0.15));
				padding: var(--at-space--xs, 0.75rem);
				min-width: 180px;
				opacity: 0;
				visibility: hidden;
				transition: opacity 0.15s ease;
				z-index: 9999;
				pointer-events: none;
			}

			.atsg-colors-item__menu-header {
				font-weight: 600;
				font-size: var(--at-text--s, 0.875rem);
				color: var(--at-neutral-d-4, #1f2937);
				margin-bottom: var(--at-space--3xs, 0.25rem);
			}

			.atsg-colors-item__menu-var {
				display: block;
				width: 100%;
				margin-bottom: var(--at-space--xs, 0.75rem);
				padding: 0;
				border: none;
				background: transparent;
				cursor: pointer;
				text-align: left;
			}

			.atsg-colors-item__menu-var:hover code {
				background: var(--at-neutral-t-4, #d1d5db);
			}

			.atsg-colors-item__menu-var.copied code {
				background: var(--at-success, #10b981);
				color: var(--at-white, #ffffff);
			}

			.atsg-colors-item__menu-var code {
				font-size: var(--at-text--2xs, 0.75rem);
				color: var(--at-neutral-d-2, #6b7280);
				background: var(--at-neutral-t-6, #f3f4f6);
				padding: var(--at-space--3xs, 0.25rem) var(--at-space--2xs, 0.375rem);
				border-radius: var(--at-radius--xs, 4px);
				display: block;
				word-break: break-all;
				transition: background 0.15s ease, color 0.15s ease;
			}

			.atsg-colors-item__menu-actions {
				display: flex;
				flex-direction: column;
				gap: var(--at-space--2xs, 0.5rem);
			}

			.atsg-colors-item__menu-btn {
				display: flex;
				align-items: center;
				gap: var(--at-space--2xs, 0.5rem);
				width: 100%;
				padding: var(--at-space--2xs, 0.5rem) var(--at-space--xs, 0.75rem);
				background: var(--at-primary, #3b82f6);
				color: var(--at-white, #ffffff);
				border: none;
				border-radius: var(--at-radius--xs, 4px);
				font-size: var(--at-text--2xs, 0.75rem);
				font-weight: 500;
				cursor: pointer;
				transition: background 0.2s ease;
				text-align: left;
			}

			.atsg-colors-item__menu-btn:hover {
				background: var(--at-primary-d-1, #2563eb);
			}

			.atsg-colors-item__menu-btn--secondary {
				background: var(--at-neutral-t-5, #e5e7eb);
				color: var(--at-neutral-d-3, #374151);
			}

			.atsg-colors-item__menu-btn--secondary:hover {
				background: var(--at-neutral-t-4, #d1d5db);
			}

			.atsg-colors-item__menu-btn-icon {
				font-size: 1em;
			}

			.atsg-colors-item__menu-value {
				font-family: monospace;
				font-weight: 400;
			}

			.atsg-colors-item__menu-more {
				display: flex;
				gap: var(--at-space--2xs, 0.5rem);
			}

			.atsg-colors-item__menu-more .atsg-colors-item__menu-btn {
				flex: 1;
				justify-content: center;
				padding: var(--at-space--2xs, 0.375rem);
			}

			/* Copied feedback */
			.atsg-colors-item__menu-btn.copied {
				background: var(--at-success, #10b981) !important;
				color: var(--at-white, #ffffff) !important;
			}

			/* Contrast checker section */
			.atsg-colors-item__menu-contrast {
				margin-top: var(--at-space--xs, 0.75rem);
				padding-top: var(--at-space--xs, 0.75rem);
				border-top: 1px solid var(--at-neutral-t-5, #e5e7eb);
			}

			.atsg-colors-item__menu-contrast-header {
				font-size: var(--at-text--2xs, 0.75rem);
				font-weight: 600;
				color: var(--at-neutral-d-2, #6b7280);
				text-transform: uppercase;
				letter-spacing: 0.05em;
				margin-bottom: var(--at-space--2xs, 0.5rem);
			}

			.atsg-colors-item__menu-contrast-row {
				display: flex;
				align-items: center;
				gap: var(--at-space--2xs, 0.5rem);
				font-size: var(--at-text--2xs, 0.75rem);
				margin-bottom: var(--at-space--3xs, 0.25rem);
			}

			.atsg-colors-item__menu-contrast-row:last-child {
				margin-bottom: 0;
			}

			.atsg-colors-item__menu-contrast-label {
				flex: 1;
				color: var(--at-neutral-d-2, #6b7280);
			}

			.atsg-colors-item__menu-contrast-value {
				font-family: monospace;
				font-weight: 500;
				color: var(--at-neutral-d-4, #1f2937);
				min-width: 3.5em;
				text-align: right;
			}

			.atsg-colors-item__menu-contrast-badge {
				display: inline-flex;
				align-items: center;
				justify-content: center;
				padding: 2px 6px;
				border-radius: 3px;
				font-size: 10px;
				font-weight: 600;
				text-transform: uppercase;
				min-width: 4em;
				text-align: center;
			}

			.atsg-colors-item__menu-contrast-badge[data-level="AAA"] {
				background: var(--at-success, #10b981);
				color: var(--at-white, #ffffff);
			}

			.atsg-colors-item__menu-contrast-badge[data-level="AA"] {
				background: var(--at-success, #10b981);
				color: var(--at-white, #ffffff);
			}

			.atsg-colors-item__menu-contrast-badge[data-level="AA-large"] {
				background: var(--at-warning, #f59e0b);
				color: var(--at-white, #ffffff);
			}

			.atsg-colors-item__menu-contrast-badge[data-level="fail"] {
				background: var(--at-error, #ef4444);
				color: var(--at-white, #ffffff);
			}

			.atsg-colors-item__menu-contrast-note {
				font-size: var(--at-text--2xs, 0.75rem);
				font-style: italic;
				color: var(--at-neutral-d-1, #9ca3af);
			}

			/* Swatch contrast badges */
			.atsg-colors-item__contrast-badges {
				position: absolute;
				bottom: 3px;
				right: 3px;
				display: flex;
				gap: 2px;
				pointer-events: none;
			}

			.atsg-colors-item__contrast-badge {
				font-size: 8px;
				font-weight: 700;
				line-height: 1;
				width: 12px;
				height: 12px;
				display: flex;
				align-items: center;
				justify-content: center;
				border-radius: 2px;
			}

			.atsg-colors-item__contrast-badge--white {
				color: #ffffff;
			}

			.atsg-colors-item__contrast-badge--black {
				color: #000000;
			}

			/* Pass - green background */
			.atsg-colors-item__contrast-badge[data-level="AAA"],
			.atsg-colors-item__contrast-badge[data-level="AA"] {
				background: var(--at-success, #10b981);
			}

			/* Large text only - orange background */
			.atsg-colors-item__contrast-badge[data-level="AA-large"] {
				background: var(--at-warning, #f59e0b);
			}

			/* Fail - red background */
			.atsg-colors-item__contrast-badge[data-level="fail"] {
				background: var(--at-error, #ef4444);
			}

			/* Colors without variants (contextual colors) */
			.atsg-colors-item--no-variants .atsg-colors-item__base {
				width: 80px;
				height: 80px;
				min-height: 80px;
			}

			/* =================================
			   STACKED LAYOUT
			   Base on top, variants in horizontal rows below
			   ================================= */
			.atsg-colors[data-layout="stacked"] .atsg-colors-item__grid {
				flex-direction: column;
				gap: var(--at-space--xs, 0.75rem);
			}

			.atsg-colors[data-layout="stacked"] .atsg-colors-item__base-column {
				width: 100%;
			}

			.atsg-colors[data-layout="stacked"] .atsg-colors-item__base {
				width: 100%;
				height: var(--at-space--3xl, 120px);
				min-height: var(--at-space--3xl, 120px);
			}

			.atsg-colors[data-layout="stacked"] .atsg-colors-item__column {
				flex-direction: row;
				flex-wrap: wrap;
			}

			.atsg-colors[data-layout="stacked"] .atsg-colors-item__swatch {
				flex: 1 1 auto;
				min-width: var(--at-space--xl, 48px);
			}

			/* =================================
			   COMPACT LAYOUT
			   Smaller swatches, labels on hover only
			   ================================= */
			.atsg-colors[data-layout="compact"] .atsg-colors-item {
				gap: var(--at-space--3xs, 0.25rem);
			}

			.atsg-colors[data-layout="compact"] .atsg-colors-item__label {
				font-size: var(--at-text--xs, 0.75rem);
				opacity: 0;
				max-height: 0;
				overflow: hidden;
				margin: 0;
				transition: opacity 0.2s ease, max-height 0.2s ease, margin 0.2s ease;
			}

			.atsg-colors[data-layout="compact"] .atsg-colors-item:hover .atsg-colors-item__label {
				opacity: 1;
				max-height: 2em;
				margin-bottom: var(--at-space--3xs, 0.25rem);
			}

			.atsg-colors[data-layout="compact"] .atsg-colors-item__grid {
				gap: 2px;
			}

			.atsg-colors[data-layout="compact"] .atsg-colors-item__column {
				gap: 2px;
			}

			.atsg-colors[data-layout="compact"] .atsg-colors-item__base {
				width: var(--at-space--l, 32px);
				border-radius: var(--at-radius--xs, 4px);
			}

			.atsg-colors[data-layout="compact"] .atsg-colors-item__swatch {
				width: var(--at-space--m, 24px);
				height: var(--at-space--m, 24px);
				border-radius: var(--at-radius--xs, 4px);
			}

			/* Hide hint in compact mode - too small */
			.atsg-colors[data-layout="compact"] .atsg-colors-item__hint {
				display: none;
			}

			/* Smaller menu in compact mode */
			.atsg-colors[data-layout="compact"] .atsg-colors-item__menu {
				min-width: 160px;
				padding: var(--at-space--2xs, 0.5rem);
			}

			.atsg-colors[data-layout="compact"] .atsg-colors-item__menu-header {
				font-size: var(--at-text--xs, 0.75rem);
			}

			/* =================================
			   COMPACT VERTICAL LAYOUT
			   Combines compact sizing with stacked/vertical arrangement
			   ================================= */
			.atsg-colors[data-layout="compact-vertical"] .atsg-colors-item {
				gap: var(--at-space--3xs, 0.25rem);
			}

			.atsg-colors[data-layout="compact-vertical"] .atsg-colors-item__label {
				font-size: var(--at-text--xs, 0.75rem);
				opacity: 0;
				max-height: 0;
				overflow: hidden;
				margin: 0;
				transition: opacity 0.2s ease, max-height 0.2s ease, margin 0.2s ease;
			}

			.atsg-colors[data-layout="compact-vertical"] .atsg-colors-item:hover .atsg-colors-item__label {
				opacity: 1;
				max-height: 2em;
				margin-bottom: var(--at-space--3xs, 0.25rem);
			}

			.atsg-colors[data-layout="compact-vertical"] .atsg-colors-item__grid {
				flex-direction: column;
				gap: 2px;
			}

			.atsg-colors[data-layout="compact-vertical"] .atsg-colors-item__base-column {
				width: 100%;
			}

			.atsg-colors[data-layout="compact-vertical"] .atsg-colors-item__base {
				width: 100%;
				height: var(--at-space--xl, 48px);
				min-height: var(--at-space--xl, 48px);
				border-radius: var(--at-radius--xs, 4px);
			}

			.atsg-colors[data-layout="compact-vertical"] .atsg-colors-item__column {
				flex-direction: row;
				flex-wrap: wrap;
				gap: 2px;
			}

			.atsg-colors[data-layout="compact-vertical"] .atsg-colors-item__swatch {
				flex: 1 1 auto;
				min-width: var(--at-space--m, 24px);
				width: var(--at-space--m, 24px);
				height: var(--at-space--m, 24px);
				border-radius: var(--at-radius--xs, 4px);
			}

			/* Hide hint in compact-vertical mode - too small */
			.atsg-colors[data-layout="compact-vertical"] .atsg-colors-item__hint {
				display: none;
			}

			/* Smaller menu in compact-vertical mode */
			.atsg-colors[data-layout="compact-vertical"] .atsg-colors-item__menu {
				min-width: 160px;
				padding: var(--at-space--2xs, 0.5rem);
			}

			.atsg-colors[data-layout="compact-vertical"] .atsg-colors-item__menu-header {
				font-size: var(--at-text--xs, 0.75rem);
			}

			/* =================================
			   MOBILE RESPONSIVE
			   Switch to stacked layout on small screens
			   ================================= */
			@media screen and (max-width: 600px) {
				/* Default layout - switch to stacked on mobile */
				.atsg-colors[data-layout="default"] .atsg-colors-item__grid {
					flex-direction: column !important;
					gap: var(--at-space--xs, 0.75rem);
				}

				.atsg-colors[data-layout="default"] .atsg-colors-item__base-column {
					width: 100%;
				}

				.atsg-colors[data-layout="default"] .atsg-colors-item__base {
					width: 100% !important;
					height: var(--at-space--2xl, 80px);
					min-height: var(--at-space--2xl, 80px);
				}

				.atsg-colors[data-layout="default"] .atsg-colors-item__column {
					flex-direction: row;
					flex-wrap: wrap;
				}

				.atsg-colors[data-layout="default"] .atsg-colors-item__swatch {
					flex: 1 1 auto;
					min-width: var(--at-space--l, 40px);
				}

				/* Compact layout - make swatches smaller on mobile */
				.atsg-colors[data-layout="compact"] .atsg-colors-item__grid {
					flex-wrap: wrap !important;
				}

				.atsg-colors[data-layout="compact"] .atsg-colors-item__swatch {
					width: var(--at-space--s, 20px);
					height: var(--at-space--s, 20px);
				}
			}
		';
	}
}
