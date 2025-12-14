<?php
/**
 * Colors Item Element for Bricks Builder.
 *
 * Individual color swatch grid with base, dark, light, and transparency variations.
 * Works with both Advanced Themer and Automatic CSS frameworks.
 *
 * @package AB\BricksSG
 */

namespace AB\BricksSG\Elements;

use AB\BricksSG\ATColors;
use AB\BricksSG\Framework\FrameworkDetector;
use AB\BricksSG\Framework\FrameworkVariables;

defined( 'ABSPATH' ) || exit;

/**
 * Colors Item Element.
 */
class ColorsItem extends \Bricks\Element {

	/**
	 * Element category - set dynamically based on active framework.
	 *
	 * @var string
	 */
	public $category = 'bricks style guide';

	/**
	 * Constructor - set category based on active framework.
	 *
	 * @param \Bricks\Element|null $element The element.
	 */
	public function __construct( $element = null ) {
		$framework_name = FrameworkDetector::get_active_framework_name();
		if ( $framework_name ) {
			$this->category = $framework_name . ' Style Guide';
		}
		parent::__construct( $element );
	}

	/**
	 * Element name.
	 *
	 * @var string
	 */
	public $name = 'bsg-colors-item';

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
	public $scripts = [ 'bsgColorsItemInit' ];

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Color Item', 'bricks-style-guide' );
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
			'title' => esc_html__( 'Color Selection', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['variations'] = [
			'title' => esc_html__( 'Variations', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['display'] = [
			'title' => esc_html__( 'Display', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['swatchStyle'] = [
			'title' => esc_html__( 'Swatch Style', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['typography'] = [
			'title' => esc_html__( 'Typography', 'bricks-style-guide' ),
			'tab'   => 'content',
		];
	}

	/**
	 * Set controls.
	 *
	 * @return void
	 */
	public function set_controls(): void {
		// Get framework-specific example variables.
		$examples       = FrameworkDetector::get_example_variables();
		$is_acss        = FrameworkDetector::is_acss_active();
		$framework_name = FrameworkDetector::get_active_framework_name() ?: 'framework';

		$this->controls['atColor'] = [
			'group'       => 'color',
			'label'       => esc_html__( 'Select Color', 'bricks-style-guide' ),
			'type'        => 'select',
			'options'     => $this->get_colors_for_select(),
			'placeholder' => sprintf(
				/* translators: %s: framework name */
				esc_html__( 'Select a %s color', 'bricks-style-guide' ),
				$framework_name
			),
		];

		$this->controls['colorInfo'] = [
			'group'    => 'color',
			'type'     => 'info',
			'content'  => sprintf(
				/* translators: %s: framework name */
				esc_html__( 'Colors are loaded from %s.', 'bricks-style-guide' ),
				$framework_name
			),
			'required' => [ 'atColor', '=', '' ],
		];

		// Variations group - which columns/shades to show.
		$this->controls['hideDarkVariants'] = [
			'group'    => 'variations',
			'label'    => esc_html__( 'Hide Dark Variants', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideLightVariants'] = [
			'group'    => 'variations',
			'label'    => esc_html__( 'Hide Light Variants', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		// Variation count only applies to AT (which has fixed 6 variations).
		if ( ! $is_acss ) {
			$this->controls['variationCount'] = [
				'group'       => 'variations',
				'label'       => esc_html__( 'Variation Count', 'bricks-style-guide' ),
				'type'        => 'number',
				'min'         => 1,
				'max'         => 6,
				'default'     => 6,
				'description' => esc_html__( 'Number of variations per column (1-6)', 'bricks-style-guide' ),
			];
		}

		$this->controls['hideTransparencyVariants'] = [
			'group'    => 'variations',
			'label'    => esc_html__( 'Hide Transparency Variants', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		// Display controls.
		$this->controls['hideColorName'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Color Name', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		// Swatch style controls.
		$this->controls['swatchSize'] = [
			'group'       => 'swatchStyle',
			'label'       => esc_html__( 'Variant Swatch Size', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => $examples['space_xl'],
			'css'         => [
				[
					'property' => 'width',
					'selector' => '.bsg-colors-item__swatch',
				],
				[
					'property' => 'height',
					'selector' => '.bsg-colors-item__swatch',
				],
				[
					'property'  => 'min-width',
					'selector'  => '.bsg-colors-item__swatch',
					'important' => true,
				],
			],
		];

		$this->controls['baseSize'] = [
			'group'       => 'swatchStyle',
			'label'       => esc_html__( 'Base Swatch Width', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => $examples['space_xl'],
			'css'         => [
				[
					'property'  => 'width',
					'selector'  => '.bsg-colors-item__base-column',
					'important' => true,
				],
				[
					'property'  => 'width',
					'selector'  => '.bsg-colors-item__base',
					'important' => true,
				],
			],
		];

		$this->controls['swatchBorderRadius'] = [
			'group'       => 'swatchStyle',
			'label'       => esc_html__( 'Border Radius', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => $examples['radius_m'],
			'css'         => [
				[
					'property' => 'border-radius',
					'selector' => '.bsg-colors-item__swatch',
				],
				[
					'property' => 'border-radius',
					'selector' => '.bsg-colors-item__base',
				],
			],
		];

		$this->controls['swatchBorder'] = [
			'group' => 'swatchStyle',
			'label' => esc_html__( 'Border', 'bricks-style-guide' ),
			'type'  => 'border',
			'css'   => [
				[
					'property' => 'border',
					'selector' => '.bsg-colors-item__swatch',
				],
				[
					'property' => 'border',
					'selector' => '.bsg-colors-item__base',
				],
			],
		];

		$this->controls['gridGap'] = [
			'group'       => 'swatchStyle',
			'label'       => esc_html__( 'Grid Gap', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => '0.25em',
			'css'         => [
				[
					'property' => 'gap',
					'selector' => '.bsg-colors-item__grid',
				],
				[
					'property' => 'gap',
					'selector' => '.bsg-colors-item__column',
				],
			],
		];

		// Typography group controls.
		$this->controls['labelTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Label Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-colors-item__label',
				],
			],
		];

		$this->controls['menuHeaderTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Menu Header Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-colors-item__menu-header',
				],
			],
		];

		$this->controls['menuCodeTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Menu Code Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-colors-item__menu-var code',
				],
			],
		];

		$this->controls['menuButtonTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Menu Button Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-colors-item__menu-btn',
				],
			],
		];

		$this->controls['contrastLabelTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Contrast Label Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-colors-item__menu-contrast-label',
				],
			],
		];
	}

	/**
	 * Get colors formatted for select control.
	 *
	 * @return array Associative array of color_id => label.
	 */
	private function get_colors_for_select(): array {
		$colors  = ATColors::get_framework_colors();
		$options = [
			'' => esc_html__( '— Select Color —', 'bricks-style-guide' ),
		];

		foreach ( $colors as $color_id => $color ) {
			$label = $color['label'] ?? ucfirst( $color_id );

			// Add palette name if available.
			if ( ! empty( $color['palette_name'] ) && 'ACSS' !== $color['palette_name'] ) {
				$label = $color['palette_name'] . ' → ' . $label;
			}

			$options[ $color_id ] = $label;
		}

		return $options;
	}

	/**
	 * Get a specific color by ID from the active framework.
	 *
	 * @param string $color_id The color ID.
	 * @return array|null Color data or null if not found.
	 */
	private function get_color( string $color_id ): ?array {
		$colors = ATColors::get_framework_colors();
		return $colors[ $color_id ] ?? null;
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
				$framework_name = FrameworkDetector::get_active_framework_name() ?: 'the framework';
				echo '<div class="bsg-colors-item__placeholder">';
				printf(
					/* translators: %s: framework name */
					esc_html__( 'Please select a color from %s', 'bricks-style-guide' ),
					esc_html( $framework_name )
				);
				echo '</div>';
			}
			return;
		}

		$root_color = $this->get_color( $color_id );

		if ( ! $root_color ) {
			if ( bricks_is_builder() ) {
				echo '<div class="bsg-colors-item__placeholder">';
				echo esc_html__( 'Selected color not found.', 'bricks-style-guide' );
				echo '</div>';
			}
			return;
		}

		// Check if this color has shade variations.
		$has_shades = ! empty( $root_color['shadeChildren'] );

		// Settings - only show variants if the color has shadeChildren.
		$show_dark         = $has_shades && ! isset( $settings['hideDarkVariants'] );
		$show_light        = $has_shades && ! isset( $settings['hideLightVariants'] );
		$show_transparency = $has_shades && ! isset( $settings['hideTransparencyVariants'] );
		$show_color_name   = ! isset( $settings['hideColorName'] );

		// Get color shades from the active framework.
		$color_shades = ATColors::get_framework_color_shades( $color_id );

		// Get color name/prefix for building CSS variables.
		$css_var_base = $root_color['raw']; // e.g., var(--primary)

		// Build the CSS variable prefix (without var() wrapper).
		preg_match( '/var\(([^)]+)\)/', $css_var_base, $matches );
		$var_name = $matches[1] ?? '--' . $color_id;

		$root_classes = [ 'bsg-colors-item' ];
		if ( ! $has_shades ) {
			$root_classes[] = 'bsg-colors-item--no-variants';
		}

		$this->set_attribute( '_root', 'class', $root_classes );
		$this->set_attribute( '_root', 'data-color', esc_attr( $color_id ) );
		$this->set_attribute( '_root', 'data-color-name', esc_attr( $root_color['label'] ) );
		$this->set_attribute( '_root', 'data-has-shades', $has_shades ? 'true' : 'false' );

		$output = "<div {$this->render_attributes( '_root' )}>";

		// Color name label above the grid.
		if ( $show_color_name ) {
			$output .= '<div class="bsg-colors-item__label">' . esc_html( $root_color['label'] ) . '</div>';
		}

		// Get framework-specific shade names.
		$light_shades        = ATColors::get_active_light_shades();
		$dark_shades         = ATColors::get_active_dark_shades();
		$transparency_shades = ATColors::get_active_transparency_shades();

		// Check if using ACSS layout (single wrapped column for uneven shade counts).
		$is_acss = FrameworkDetector::is_acss_active();

		// Grid container.
		$grid_class = 'bsg-colors-item__grid';
		if ( $is_acss ) {
			$grid_class .= ' bsg-colors-item__grid--acss';
		}
		$output .= '<div class="' . esc_attr( $grid_class ) . '">';

		// Column 1: Base color (full height).
		$output .= '<div class="bsg-colors-item__base-column">';
		$output .= $this->render_swatch( $var_name, 'base', $root_color['label'], true );
		$output .= '</div>';

		if ( $is_acss ) {
			// ACSS Layout: Variants wrapper with two sections - solids and transparencies.
			$output .= '<div class="bsg-colors-item__variants-wrapper">';

			// Solid shades section (light + dark in a 2-column grid).
			$output .= '<div class="bsg-colors-item__solids">';

			// Light shades first (lightest to darkest).
			if ( $show_light && ! empty( $light_shades ) ) {
				foreach ( array_reverse( $light_shades ) as $suffix ) {
					$var     = "{$var_name}-{$suffix}";
					$label   = $root_color['label'] . ' ' . $this->format_shade_label( $suffix );
					$output .= $this->render_swatch( $var, $suffix, $label, false, 'solid', 'light' );
				}
			}

			// Dark shades (continuing from light to dark).
			if ( $show_dark && ! empty( $dark_shades ) ) {
				foreach ( $dark_shades as $suffix ) {
					$var     = "{$var_name}-{$suffix}";
					$label   = $root_color['label'] . ' ' . $this->format_shade_label( $suffix );
					$output .= $this->render_swatch( $var, $suffix, $label, false, 'solid', 'dark' );
				}
			}

			$output .= '</div>'; // .bsg-colors-item__solids

			// Transparency variants section (smaller, 3-column grid).
			if ( $show_transparency && ! empty( $transparency_shades ) ) {
				$output .= '<div class="bsg-colors-item__transparencies">';
				foreach ( $transparency_shades as $suffix ) {
					$var     = "{$var_name}-{$suffix}";
					$label   = $root_color['label'] . ' ' . $this->format_shade_label( $suffix );
					$output .= $this->render_swatch( $var, $suffix, $label, false, 'trans', 'transparency' );
				}
				$output .= '</div>'; // .bsg-colors-item__transparencies
			}

			$output .= '</div>'; // .bsg-colors-item__variants-wrapper
		} else {
			// AT Layout: Separate columns for dark, light, and transparency.

			// Column 2: Dark variants.
			if ( $show_dark && ! empty( $dark_shades ) ) {
				$output .= '<div class="bsg-colors-item__column bsg-colors-item__column--dark" data-variant="dark">';
				foreach ( $dark_shades as $suffix ) {
					$var     = "{$var_name}-{$suffix}";
					$label   = $root_color['label'] . ' ' . $this->format_shade_label( $suffix );
					$output .= $this->render_swatch( $var, $suffix, $label, false );
				}
				$output .= '</div>';
			}

			// Column 3: Light variants.
			if ( $show_light && ! empty( $light_shades ) ) {
				$output .= '<div class="bsg-colors-item__column bsg-colors-item__column--light" data-variant="light">';
				foreach ( $light_shades as $suffix ) {
					$var     = "{$var_name}-{$suffix}";
					$label   = $root_color['label'] . ' ' . $this->format_shade_label( $suffix );
					$output .= $this->render_swatch( $var, $suffix, $label, false );
				}
				$output .= '</div>';
			}

			// Column 4: Transparency variants.
			if ( $show_transparency && ! empty( $transparency_shades ) ) {
				$output .= '<div class="bsg-colors-item__column bsg-colors-item__column--transparency" data-variant="transparency">';
				foreach ( $transparency_shades as $suffix ) {
					$var     = "{$var_name}-{$suffix}";
					$label   = $root_color['label'] . ' ' . $this->format_shade_label( $suffix );
					$output .= $this->render_swatch( $var, $suffix, $label, false );
				}
				$output .= '</div>';
			}
		}

		$output .= '</div>'; // .bsg-colors-item__grid

		$output .= '</div>'; // .bsg-colors-item

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Format shade suffix for display.
	 *
	 * @param string $suffix The shade suffix (e.g., 'd-1', 'ultra-light').
	 * @return string Formatted label.
	 */
	private function format_shade_label( string $suffix ): string {
		// For ACSS-style named shades, convert to title case.
		if ( strpos( $suffix, '-' ) !== false && ! preg_match( '/^[dlt]-\d+$/', $suffix ) ) {
			return ucwords( str_replace( '-', ' ', $suffix ) );
		}
		// For AT-style numbered shades, uppercase.
		return strtoupper( $suffix );
	}

	/**
	 * Render a single swatch with data attributes for the context menu.
	 *
	 * @param string $css_var         The CSS variable name (without var()).
	 * @param string $suffix          The variation suffix (base, d-1, l-1, t-1, etc.).
	 * @param string $label           The display label.
	 * @param bool   $is_base         Whether this is the base color.
	 * @param string $variant_type    Optional variant type for ACSS grid layout ('solid' or 'trans').
	 * @param string $variant_category Optional variant category for parent override CSS ('light', 'dark', 'transparency').
	 * @return string HTML output.
	 */
	private function render_swatch( string $css_var, string $suffix, string $label, bool $is_base, string $variant_type = '', string $variant_category = '' ): string {
		$class = $is_base ? 'bsg-colors-item__base' : 'bsg-colors-item__swatch';

		// Add variant type class for ACSS grid layout.
		if ( $variant_type ) {
			$class .= ' bsg-colors-item__swatch--' . $variant_type;
		}

		$output  = '<div class="' . esc_attr( $class ) . '"';
		$output .= ' style="background-color: var(' . esc_attr( $css_var ) . ');"';
		$output .= ' data-var="' . esc_attr( $css_var ) . '"';
		$output .= ' data-suffix="' . esc_attr( $suffix ) . '"';
		$output .= ' data-label="' . esc_attr( $label ) . '"';
		if ( $variant_category ) {
			$output .= ' data-variant="' . esc_attr( $variant_category ) . '"';
		}
		$output .= ' tabindex="0"';
		$output .= ' role="button"';
		$output .= ' aria-label="' . esc_attr( $label ) . '"';
		$output .= '>';

		// Context menu (hidden by default, shown on hover/click).
		$output .= '<div class="bsg-colors-item__menu">';
		$output .= '<div class="bsg-colors-item__menu-header">' . esc_html( $label ) . '</div>';
		$output .= '<button type="button" class="bsg-colors-item__menu-var" data-action="copy-var" data-var-value="' . esc_attr( 'var(' . $css_var . ')' ) . '">';
		$output .= '<code>' . esc_html( 'var(' . $css_var . ')' ) . '</code>';
		$output .= '</button>';
		$output .= '<div class="bsg-colors-item__menu-actions">';
		$output .= '<button type="button" class="bsg-colors-item__menu-btn" data-action="copy-hex">';
		$output .= '<span class="bsg-colors-item__menu-btn-icon">📋</span> ';
		$output .= esc_html__( 'Copy', 'bricks-style-guide' );
		$output .= ' <span class="bsg-colors-item__menu-value"></span>';
		$output .= '</button>';
		$output .= '<div class="bsg-colors-item__menu-more">';
		$output .= '<button type="button" class="bsg-colors-item__menu-btn bsg-colors-item__menu-btn--secondary" data-action="copy-rgb">';
		$output .= esc_html__( 'RGB', 'bricks-style-guide' );
		$output .= '</button>';
		$output .= '<button type="button" class="bsg-colors-item__menu-btn bsg-colors-item__menu-btn--secondary" data-action="copy-hsl">';
		$output .= esc_html__( 'HSL', 'bricks-style-guide' );
		$output .= '</button>';
		$output .= '<button type="button" class="bsg-colors-item__menu-btn bsg-colors-item__menu-btn--secondary" data-action="copy-oklch">';
		$output .= esc_html__( 'OKLCH', 'bricks-style-guide' );
		$output .= '</button>';
		$output .= '</div>'; // .bsg-colors-item__menu-more
		$output .= '</div>'; // .bsg-colors-item__menu-actions

		// Contrast checker section.
		$output .= '<div class="bsg-colors-item__menu-contrast">';
		$output .= '<div class="bsg-colors-item__menu-contrast-header">' . esc_html__( 'Contrast', 'bricks-style-guide' ) . '</div>';
		$output .= '<div class="bsg-colors-item__menu-contrast-row">';
		$output .= '<span class="bsg-colors-item__menu-contrast-label">' . esc_html__( 'White text', 'bricks-style-guide' ) . '</span>';
		$output .= '<span class="bsg-colors-item__menu-contrast-value" data-contrast="white"></span>';
		$output .= '<span class="bsg-colors-item__menu-contrast-badge" data-contrast-badge="white"></span>';
		$output .= '</div>';
		$output .= '<div class="bsg-colors-item__menu-contrast-row">';
		$output .= '<span class="bsg-colors-item__menu-contrast-label">' . esc_html__( 'Black text', 'bricks-style-guide' ) . '</span>';
		$output .= '<span class="bsg-colors-item__menu-contrast-value" data-contrast="black"></span>';
		$output .= '<span class="bsg-colors-item__menu-contrast-badge" data-contrast-badge="black"></span>';
		$output .= '</div>';
		$output .= '</div>'; // .bsg-colors-item__menu-contrast

		$output .= '</div>'; // .bsg-colors-item__menu

		$output .= '</div>';

		return $output;
	}

	/**
	 * Enqueue element styles.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {
		$handle = 'bsg-colors-item';

		// Only register and add inline styles once.
		if ( ! wp_style_is( $handle, 'registered' ) ) {
			wp_register_style( $handle, false, [], BRICKS_SG_VERSION );
			wp_add_inline_style( $handle, $this->get_element_css() );
		}

		wp_enqueue_style( $handle );
	}

	/**
	 * Get inline CSS for the element.
	 *
	 * @return string
	 */
	private function get_element_css(): string {
		// Get framework-agnostic CSS variables that map to the active framework.
		$framework_vars = FrameworkVariables::get_css_variables();

		return '
			/* Framework Variable Mappings */
			.bsg-colors-item,
			.bsg-colors-item__menu {
				' . $framework_vars . '
			}

			/* Critical layout */
			.bsg-colors-item {
				display: flex;
				flex-direction: column;
				gap: var(--bsg-space-xs, 0.75rem);
			}

			.bsg-colors-item__grid {
				display: flex;
				flex-wrap: nowrap;
				gap: var(--bsg-space-2xs, 0.25em);
			}

			.bsg-colors-item__base-column {
				display: flex;
				flex-shrink: 0;
			}

			.bsg-colors-item__column {
				display: flex;
				flex-direction: column;
				flex-shrink: 0;
				gap: var(--bsg-space-2xs, 0.25em);
			}

			/* =================================
			   ACSS DEFAULT LAYOUT
			   - Base swatch on left
			   - Solids in 2-column grid
			   - Transparencies in 3-column grid, smaller swatches
			   Note: These are default styles, overridden by stacked/compact layouts below
			   ================================= */
			.bsg-colors-item__grid--acss {
				display: flex;
				flex-direction: row;
				gap: var(--bsg-space-2xs, 0.25em);
				align-items: flex-start;
			}

			.bsg-colors-item__grid--acss .bsg-colors-item__base-column {
				flex-shrink: 0;
				align-self: stretch;
			}

			/* Base swatch needs explicit height in ACSS layout */
			.bsg-colors-item__grid--acss .bsg-colors-item__base {
				width: var(--bsg-space-xl, 5rem);
				height: 100%;
				min-height: var(--bsg-space-3xl, 12.5rem);
			}

			/* Variants wrapper - contains solids and transparencies side by side */
			.bsg-colors-item__grid--acss .bsg-colors-item__variants-wrapper {
				display: flex;
				flex-direction: row;
				gap: var(--bsg-space-xs, 0.5em);
				align-items: flex-start;
			}

			/* Solids section - 2-column grid */
			.bsg-colors-item__grid--acss .bsg-colors-item__solids {
				display: grid;
				grid-template-columns: repeat(2, 1fr);
				gap: var(--bsg-space-2xs, 0.25em);
			}

			/* Transparencies section - 3-column grid with smaller swatches */
			.bsg-colors-item__grid--acss .bsg-colors-item__transparencies {
				display: grid;
				grid-template-columns: repeat(3, 1fr);
				gap: var(--bsg-space-3xs, 0.125em);
			}

			/* Transparency swatches - slightly smaller than solids */
			.bsg-colors-item__grid--acss .bsg-colors-item__transparencies .bsg-colors-item__swatch {
				width: var(--bsg-space-l, 2.5rem);
				height: var(--bsg-space-l, 2.5rem);
				min-width: var(--bsg-space-l, 2.5rem);
			}

			/* Transparency pattern background for ACSS transparent swatches */
			.bsg-colors-item__grid--acss .bsg-colors-item__transparencies .bsg-colors-item__swatch {
				background-image:
					linear-gradient(45deg, var(--bsg-border-color, #d1d5db) 25%, transparent 25%),
					linear-gradient(-45deg, var(--bsg-border-color, #d1d5db) 25%, transparent 25%),
					linear-gradient(45deg, transparent 75%, var(--bsg-border-color, #d1d5db) 75%),
					linear-gradient(-45deg, transparent 75%, var(--bsg-border-color, #d1d5db) 75%);
				background-size: 8px 8px;
				background-position: 0 0, 0 4px, 4px -4px, -4px 0px;
			}

			.bsg-colors-item__grid--acss .bsg-colors-item__transparencies .bsg-colors-item__swatch::after {
				content: "";
				position: absolute;
				inset: 0;
				border-radius: inherit;
				background-color: inherit;
			}

			/* =================================
			   ACSS STACKED LAYOUT (outside @layer for higher specificity)
			   Base on top (2 cells wide), variants in 2-column grid below
			   ================================= */
			.bsg-colors[data-layout="stacked"] .bsg-colors-item__grid.bsg-colors-item__grid--acss {
				display: grid !important;
				grid-template-columns: repeat(2, 1fr) !important;
				gap: var(--bsg-space-2xs, 0.25em) !important;
				align-items: start !important;
			}

			.bsg-colors[data-layout="stacked"] .bsg-colors-item__grid--acss .bsg-colors-item__base-column {
				grid-column: span 2 !important;
				width: 100% !important;
			}

			.bsg-colors[data-layout="stacked"] .bsg-colors-item__grid--acss .bsg-colors-item__base {
				width: 100% !important;
				height: var(--bsg-space-xl, 3rem) !important;
				min-height: var(--bsg-space-xl, 3rem) !important;
			}

			.bsg-colors[data-layout="stacked"] .bsg-colors-item__grid--acss .bsg-colors-item__variants-wrapper {
				grid-column: span 2 !important;
				display: grid !important;
				grid-template-columns: repeat(2, 1fr) !important;
				gap: var(--bsg-space-2xs, 0.25em) !important;
				width: 100% !important;
			}

			/* Solids span both columns and use internal 2-column grid */
			.bsg-colors[data-layout="stacked"] .bsg-colors-item__grid--acss .bsg-colors-item__solids {
				grid-column: span 2 !important;
				grid-template-columns: repeat(2, 1fr) !important;
			}

			/* Transparencies also span both columns and match solid sizing */
			.bsg-colors[data-layout="stacked"] .bsg-colors-item__grid--acss .bsg-colors-item__transparencies {
				grid-column: span 2 !important;
				grid-template-columns: repeat(2, 1fr) !important;
			}

			/* Make transparency swatches same size as solids in stacked layout */
			.bsg-colors[data-layout="stacked"] .bsg-colors-item__grid--acss .bsg-colors-item__transparencies .bsg-colors-item__swatch {
				width: var(--bsg-space-xl, 3rem) !important;
				height: var(--bsg-space-xl, 3rem) !important;
				min-width: var(--bsg-space-xl, 3rem) !important;
			}

			/* =================================
			   ACSS COMPACT LAYOUT (outside @layer for higher specificity)
			   Smaller swatches
			   ================================= */
			.bsg-colors[data-layout="compact"] .bsg-colors-item__grid.bsg-colors-item__grid--acss {
				gap: var(--bsg-space-3xs, 0.125em) !important;
			}

			.bsg-colors[data-layout="compact"] .bsg-colors-item__grid--acss .bsg-colors-item__base {
				width: var(--bsg-space-l, 2rem) !important;
				min-height: auto !important;
			}

			.bsg-colors[data-layout="compact"] .bsg-colors-item__grid--acss .bsg-colors-item__variants-wrapper {
				gap: var(--bsg-space-3xs, 0.125em) !important;
			}

			.bsg-colors[data-layout="compact"] .bsg-colors-item__grid--acss .bsg-colors-item__solids {
				gap: var(--bsg-space-3xs, 0.125em) !important;
			}

			.bsg-colors[data-layout="compact"] .bsg-colors-item__grid--acss .bsg-colors-item__solids .bsg-colors-item__swatch {
				width: var(--bsg-space-m, 1.5rem) !important;
				height: var(--bsg-space-m, 1.5rem) !important;
			}

			.bsg-colors[data-layout="compact"] .bsg-colors-item__grid--acss .bsg-colors-item__transparencies {
				gap: var(--bsg-space-3xs, 0.125em) !important;
			}

			.bsg-colors[data-layout="compact"] .bsg-colors-item__grid--acss .bsg-colors-item__transparencies .bsg-colors-item__swatch {
				width: var(--bsg-space-s, 1rem) !important;
				height: var(--bsg-space-s, 1rem) !important;
				min-width: var(--bsg-space-s, 1rem) !important;
			}

			/* =================================
			   ACSS COMPACT-VERTICAL LAYOUT (outside @layer for higher specificity)
			   Compact sizes + 2-column grid like stacked
			   ================================= */
			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__grid.bsg-colors-item__grid--acss {
				display: grid !important;
				grid-template-columns: repeat(2, 1fr) !important;
				gap: var(--bsg-space-3xs, 0.125em) !important;
				align-items: start !important;
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__grid--acss .bsg-colors-item__base-column {
				grid-column: span 2 !important;
				width: 100% !important;
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__grid--acss .bsg-colors-item__base {
				width: 100% !important;
				height: var(--bsg-space-l, 2rem) !important;
				min-height: var(--bsg-space-l, 2rem) !important;
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__grid--acss .bsg-colors-item__variants-wrapper {
				grid-column: span 2 !important;
				display: grid !important;
				grid-template-columns: repeat(2, 1fr) !important;
				gap: var(--bsg-space-3xs, 0.125em) !important;
				width: 100% !important;
			}

			/* Solids span both columns and use internal 2-column grid */
			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__grid--acss .bsg-colors-item__solids {
				grid-column: span 2 !important;
				grid-template-columns: repeat(2, 1fr) !important;
				gap: var(--bsg-space-3xs, 0.125em) !important;
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__grid--acss .bsg-colors-item__solids .bsg-colors-item__swatch {
				width: var(--bsg-space-m, 1.5rem) !important;
				height: var(--bsg-space-m, 1.5rem) !important;
			}

			/* Transparencies also span both columns and match solid sizing */
			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__grid--acss .bsg-colors-item__transparencies {
				grid-column: span 2 !important;
				grid-template-columns: repeat(2, 1fr) !important;
				gap: var(--bsg-space-3xs, 0.125em) !important;
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__grid--acss .bsg-colors-item__transparencies .bsg-colors-item__swatch {
				width: var(--bsg-space-m, 1.5rem) !important;
				height: var(--bsg-space-m, 1.5rem) !important;
				min-width: var(--bsg-space-m, 1.5rem) !important;
			}

			/* Context Menu - positioned by JavaScript */
			.bsg-colors-item__menu {
				position: fixed;
				opacity: 0;
				visibility: hidden;
				z-index: 9999;
				pointer-events: none;
			}

			/* Swatch contrast badges */
			.bsg-colors-item__contrast-badges {
				position: absolute;
				bottom: 0.1875em;
				right: 0.1875em;
				display: flex;
				gap: 0.125em;
				pointer-events: none;
			}

			/* ACSS: Larger contrast badges for better readability */
			.bsg-colors-item__grid--acss .bsg-colors-item__contrast-badges {
				bottom: 0.25em;
				right: 0.25em;
				gap: 0.1875em;
			}

			.bsg-colors-item__grid--acss .bsg-colors-item__contrast-badge {
				font-size: 1em;
				width: 1.25em;
				height: 1.25em;
				border-radius: 0.1875em;
			}

			/* Layout variants - critical display rules */
			.bsg-colors[data-layout="stacked"] .bsg-colors-item__grid {
				flex-direction: column;
				gap: var(--bsg-space-xs, 0.75rem);
			}

			.bsg-colors[data-layout="stacked"] .bsg-colors-item__base-column {
				width: 100%;
			}

			.bsg-colors[data-layout="stacked"] .bsg-colors-item__column {
				flex-direction: row;
				flex-wrap: wrap;
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__grid {
				flex-direction: column;
				gap: var(--bsg-space-3xs, 0.125em);
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__base-column {
				width: 100%;
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__column {
				flex-direction: row;
				flex-wrap: wrap;
				gap: var(--bsg-space-3xs, 0.125em);
			}

			/* Mobile responsive - critical layout changes */
			@media screen and (max-width: 600px) {
				.bsg-colors[data-layout="default"] .bsg-colors-item__grid {
					flex-direction: column !important;
					gap: var(--bsg-space-xs, 0.75rem);
				}

				.bsg-colors[data-layout="default"] .bsg-colors-item__base-column {
					width: 100%;
				}

				.bsg-colors[data-layout="default"] .bsg-colors-item__column {
					flex-direction: row;
					flex-wrap: wrap;
				}

				.bsg-colors[data-layout="compact"] .bsg-colors-item__grid {
					flex-wrap: wrap !important;
				}
			}

			@layer bsg {
			/* === Settings === */
			.bsg-colors-item {
				/* Placeholder */
				--_placeholder-padding: var(--bsg-colors-item-placeholder-padding, var(--bsg-space-l, 2rem));
				--_placeholder-bg: var(--bsg-colors-item-placeholder-bg, var(--bsg-neutral-light, #f3f4f6));
				--_placeholder-border-color: var(--bsg-colors-item-placeholder-border-color, var(--bsg-border-color, #d1d5db));
				--_placeholder-color: var(--bsg-colors-item-placeholder-color, var(--bsg-neutral-medium, #6b7280));

				/* Label Typography */
				--_label-font-family: var(--bsg-colors-item-label-font-family, inherit);
				--_label-font-size: var(--bsg-colors-item-label-font-size, var(--bsg-text-m, 1.125rem));
				--_label-font-weight: var(--bsg-colors-item-label-font-weight, 600);
				--_label-line-height: var(--bsg-colors-item-label-line-height, 1.4);
				--_label-letter-spacing: var(--bsg-colors-item-label-letter-spacing, normal);
				--_label-text-transform: var(--bsg-colors-item-label-text-transform, none);
				--_label-color: var(--bsg-colors-item-label-color, var(--bsg-neutral-darker, #1f2937));

				/* Menu Header Typography */
				--_menu-header-font-family: var(--bsg-colors-item-menu-header-font-family, inherit);
				--_menu-header-font-size: var(--bsg-colors-item-menu-header-font-size, var(--bsg-text-s, 0.875rem));
				--_menu-header-font-weight: var(--bsg-colors-item-menu-header-font-weight, 600);
				--_menu-header-line-height: var(--bsg-colors-item-menu-header-line-height, 1.4);
				--_menu-header-letter-spacing: var(--bsg-colors-item-menu-header-letter-spacing, normal);
				--_menu-header-text-transform: var(--bsg-colors-item-menu-header-text-transform, none);
				--_menu-header-color: var(--bsg-colors-item-menu-header-color, var(--bsg-neutral-darker, #1f2937));

				/* Menu Code Typography */
				--_menu-code-font-family: var(--bsg-colors-item-menu-code-font-family, ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace);
				--_menu-code-font-size: var(--bsg-colors-item-menu-code-font-size, var(--bsg-text-2xs, 0.75rem));
				--_menu-code-font-weight: var(--bsg-colors-item-menu-code-font-weight, 400);
				--_menu-code-line-height: var(--bsg-colors-item-menu-code-line-height, 1.5);
				--_menu-code-letter-spacing: var(--bsg-colors-item-menu-code-letter-spacing, normal);
				--_menu-code-color: var(--bsg-colors-item-menu-code-color, var(--bsg-neutral-medium, #6b7280));

				/* Menu Button Typography */
				--_menu-btn-font-family: var(--bsg-colors-item-menu-btn-font-family, inherit);
				--_menu-btn-font-size: var(--bsg-colors-item-menu-btn-font-size, var(--bsg-text-2xs, 0.75rem));
				--_menu-btn-font-weight: var(--bsg-colors-item-menu-btn-font-weight, 500);
				--_menu-btn-line-height: var(--bsg-colors-item-menu-btn-line-height, 1.4);
				--_menu-btn-letter-spacing: var(--bsg-colors-item-menu-btn-letter-spacing, normal);
				--_menu-btn-text-transform: var(--bsg-colors-item-menu-btn-text-transform, none);

				/* Contrast Label Typography */
				--_contrast-label-font-family: var(--bsg-colors-item-contrast-label-font-family, inherit);
				--_contrast-label-font-size: var(--bsg-colors-item-contrast-label-font-size, var(--bsg-text-2xs, 0.75rem));
				--_contrast-label-font-weight: var(--bsg-colors-item-contrast-label-font-weight, 400);
				--_contrast-label-line-height: var(--bsg-colors-item-contrast-label-line-height, 1.4);
				--_contrast-label-letter-spacing: var(--bsg-colors-item-contrast-label-letter-spacing, normal);
				--_contrast-label-color: var(--bsg-colors-item-contrast-label-color, var(--bsg-neutral-medium, #6b7280));
			}

			.bsg-colors-item__placeholder {
				padding: var(--_placeholder-padding);
				background: var(--_placeholder-bg);
				border: var(--bsg-border-width, 0.125em) dashed var(--_placeholder-border-color);
				border-radius: var(--bsg-radius-s, 0.5em);
				text-align: center;
				color: var(--_placeholder-color);
			}

			.bsg-colors-item__label {
				font-family: var(--_label-font-family);
				font-size: var(--_label-font-size);
				font-weight: var(--_label-font-weight);
				line-height: var(--_label-line-height);
				letter-spacing: var(--_label-letter-spacing);
				text-transform: var(--_label-text-transform);
				color: var(--_label-color);
			}

			.bsg-colors-item__base {
				width: var(--bsg-space-xl, 5rem);
				min-height: 100%;
				border-radius: var(--bsg-radius-m, 0.5em);
				border: 1px solid var(--bsg-border-color, #d1d5db);
				position: relative;
				cursor: pointer;
				transition: outline 0.2s ease;
			}

			.bsg-colors-item__base:hover,
			.bsg-colors-item__base:focus {
				outline: 3px solid var(--bsg-focus-ring-color, var(--bsg-primary, #3b82f6));
				outline-offset: 2px;
			}

			.bsg-colors-item__swatch {
				width: var(--bsg-space-xl, 3rem);
				height: var(--bsg-space-xl, 3rem);
				border-radius: var(--bsg-radius-m, 0.5em);
				border: 1px solid var(--bsg-border-color, #d1d5db);
				position: relative;
				cursor: pointer;
				transition: outline 0.2s ease;
			}

			.bsg-colors-item__swatch:hover,
			.bsg-colors-item__swatch:focus {
				outline: 3px solid var(--bsg-focus-ring-color, var(--bsg-primary, #3b82f6));
				outline-offset: 2px;
				z-index: 10;
			}

			/* Click hint - shown on hover */
			.bsg-colors-item__hint {
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
				background: var(--bsg-neutral-darker, #1f2937);
				color: var(--bsg-white, #ffffff);
				font-size: 0.625em;
				font-weight: 600;
				text-transform: uppercase;
				letter-spacing: 0.05em;
				padding: 0.1875em 0.375em;
				border-radius: var(--bsg-radius-xs, 0.1875em);
				opacity: 0;
				transition: opacity 0.15s ease;
				pointer-events: none;
			}

			.bsg-colors-item__swatch:hover .bsg-colors-item__hint,
			.bsg-colors-item__base:hover .bsg-colors-item__hint {
				opacity: 1;
			}

			/* Transparency pattern background for transparent swatches */
			.bsg-colors-item__column:last-child .bsg-colors-item__swatch {
				background-image:
					linear-gradient(45deg, var(--bsg-border-color, #d1d5db) 25%, transparent 25%),
					linear-gradient(-45deg, var(--bsg-border-color, #d1d5db) 25%, transparent 25%),
					linear-gradient(45deg, transparent 75%, var(--bsg-border-color, #d1d5db) 75%),
					linear-gradient(-45deg, transparent 75%, var(--bsg-border-color, #d1d5db) 75%);
				background-size: 8px 8px;
				background-position: 0 0, 0 4px, 4px -4px, -4px 0px;
			}

			.bsg-colors-item__column:last-child .bsg-colors-item__swatch::after {
				content: "";
				position: absolute;
				inset: 0;
				border-radius: inherit;
				background-color: inherit;
			}

			/* Context Menu - positioned by JavaScript */
			.bsg-colors-item__menu {
				position: fixed;
				background: var(--bsg-white, #ffffff);
				border-radius: var(--bsg-radius-s, 0.5em);
				box-shadow: var(--bsg-shadow-l, 0 10px 25px var(--bsg-shadow-subtle, #e5e7eb));
				padding: var(--bsg-space-xs, 0.75rem);
				min-width: 18rem;
				opacity: 0;
				visibility: hidden;
				transition: opacity 0.15s ease;
				z-index: 9999;
				pointer-events: none;
			}

			.bsg-colors-item__menu-header {
				font-family: var(--_menu-header-font-family);
				font-size: var(--_menu-header-font-size);
				font-weight: var(--_menu-header-font-weight);
				line-height: var(--_menu-header-line-height);
				letter-spacing: var(--_menu-header-letter-spacing);
				text-transform: var(--_menu-header-text-transform);
				color: var(--_menu-header-color);
				margin-bottom: var(--bsg-space-3xs, 0.25rem);
			}

			.bsg-colors-item__menu-var {
				display: block;
				width: 100%;
				margin-bottom: var(--bsg-space-xs, 0.75rem);
				padding: 0;
				border: none;
				background: transparent;
				cursor: pointer;
				text-align: left;
			}

			.bsg-colors-item__menu-var:hover code {
				background: var(--bsg-border-color, #d1d5db);
			}

			.bsg-colors-item__menu-var.copied code {
				background: var(--bsg-success, #10b981);
				color: var(--bsg-white, #ffffff);
			}

			.bsg-colors-item__menu-var code {
				font-family: var(--_menu-code-font-family);
				font-size: var(--_menu-code-font-size);
				font-weight: var(--_menu-code-font-weight);
				line-height: var(--_menu-code-line-height);
				letter-spacing: var(--_menu-code-letter-spacing);
				color: var(--_menu-code-color);
				background: var(--bsg-neutral-light, #f3f4f6);
				padding: var(--bsg-space-3xs, 0.25rem) var(--bsg-space-2xs, 0.375rem);
				border-radius: var(--bsg-radius-xs, 0.25em);
				display: block;
				word-break: break-all;
				transition: background 0.15s ease, color 0.15s ease;
			}

			.bsg-colors-item__menu-actions {
				display: flex;
				flex-direction: column;
				gap: var(--bsg-space-2xs, 0.5rem);
			}

			.bsg-colors-item__menu-btn {
				display: flex;
				align-items: center;
				gap: var(--bsg-space-2xs, 0.5rem);
				width: 100%;
				padding: var(--bsg-space-2xs, 0.5rem) var(--bsg-space-xs, 0.75rem);
				background: var(--bsg-primary, #3b82f6);
				color: var(--bsg-white, #ffffff);
				border: none;
				border-radius: var(--bsg-radius-xs, 0.25em);
				font-family: var(--_menu-btn-font-family);
				font-size: var(--_menu-btn-font-size);
				font-weight: var(--_menu-btn-font-weight);
				line-height: var(--_menu-btn-line-height);
				letter-spacing: var(--_menu-btn-letter-spacing);
				text-transform: var(--_menu-btn-text-transform);
				cursor: pointer;
				transition: background 0.2s ease;
				text-align: left;
			}

			.bsg-colors-item__menu-btn:hover {
				background: var(--bsg-primary-hover, #2563eb);
			}

			.bsg-colors-item__menu-btn--secondary {
				background: var(--bsg-neutral-light, #e5e7eb);
				color: var(--bsg-neutral-dark, #374151);
			}

			.bsg-colors-item__menu-btn--secondary:hover {
				background: var(--bsg-border-color, #d1d5db);
			}

			.bsg-colors-item__menu-btn-icon {
				font-size: 1em;
			}

			.bsg-colors-item__menu-value {
				font-family: monospace;
				font-weight: 400;
			}

			.bsg-colors-item__menu-more {
				display: flex;
				gap: var(--bsg-space-2xs, 0.5rem);
			}

			.bsg-colors-item__menu-more .bsg-colors-item__menu-btn {
				flex: 1;
				justify-content: center;
				padding: var(--bsg-space-2xs, 0.375rem);
			}

			/* Copied feedback */
			.bsg-colors-item__menu-btn.copied {
				background: var(--bsg-success, #10b981) !important;
				color: var(--bsg-white, #ffffff) !important;
			}

			/* Contrast checker section */
			.bsg-colors-item__menu-contrast {
				margin-top: var(--bsg-space-xs, 0.75rem);
				padding-top: var(--bsg-space-xs, 0.75rem);
				border-top: 1px solid var(--bsg-neutral-light, #e5e7eb);
			}

			.bsg-colors-item__menu-contrast-header {
				font-size: var(--bsg-text-2xs, 0.75rem);
				font-weight: 600;
				color: var(--bsg-neutral-medium, #6b7280);
				text-transform: uppercase;
				letter-spacing: 0.05em;
				margin-bottom: var(--bsg-space-2xs, 0.5rem);
			}

			.bsg-colors-item__menu-contrast-row {
				display: flex;
				align-items: center;
				gap: var(--bsg-space-2xs, 0.5rem);
				font-size: var(--bsg-text-2xs, 0.75rem);
				margin-bottom: var(--bsg-space-3xs, 0.25rem);
			}

			.bsg-colors-item__menu-contrast-row:last-child {
				margin-bottom: 0;
			}

			.bsg-colors-item__menu-contrast-label {
				flex: 1;
				font-family: var(--_contrast-label-font-family);
				font-size: var(--_contrast-label-font-size);
				font-weight: var(--_contrast-label-font-weight);
				line-height: var(--_contrast-label-line-height);
				letter-spacing: var(--_contrast-label-letter-spacing);
				color: var(--_contrast-label-color);
			}

			.bsg-colors-item__menu-contrast-value {
				font-family: monospace;
				font-weight: 500;
				color: var(--bsg-neutral-darker, #1f2937);
				min-width: 3.5em;
				text-align: right;
			}

			.bsg-colors-item__menu-contrast-badge {
				display: inline-flex;
				align-items: center;
				justify-content: center;
				padding: 0.125em 0.375em;
				border-radius: 0.1875em;
				font-size: 0.625em;
				font-weight: 600;
				text-transform: uppercase;
				min-width: 4em;
				text-align: center;
			}

			.bsg-colors-item__menu-contrast-badge[data-level="AAA"] {
				background: var(--bsg-success, #10b981);
				color: var(--bsg-white, #ffffff);
			}

			.bsg-colors-item__menu-contrast-badge[data-level="AA"] {
				background: var(--bsg-success, #10b981);
				color: var(--bsg-white, #ffffff);
			}

			.bsg-colors-item__menu-contrast-badge[data-level="AA-large"] {
				background: var(--bsg-warning, #f59e0b);
				color: var(--bsg-white, #ffffff);
			}

			.bsg-colors-item__menu-contrast-badge[data-level="fail"] {
				background: var(--bsg-error, #ef4444);
				color: var(--bsg-white, #ffffff);
			}

			.bsg-colors-item__menu-contrast-note {
				font-size: var(--bsg-text-2xs, 0.75rem);
				font-style: italic;
				color: var(--bsg-neutral-medium, #9ca3af);
			}

			/* Swatch contrast badges */
			.bsg-colors-item__contrast-badges {
				position: absolute;
				bottom: 0.1875em;
				right: 0.1875em;
				display: flex;
				gap: 0.125em;
				pointer-events: none;
			}

			.bsg-colors-item__contrast-badge {
				font-size: 0.75em;
				font-weight: 700;
				line-height: 1;
				width: 1.25em;
				height: 1.25em;
				display: flex;
				align-items: center;
				justify-content: center;
				border-radius: 0.1875em;
			}

			.bsg-colors-item__contrast-badge--white {
				color: #ffffff; /* Fixed: literal white for A11Y contrast testing */
			}

			.bsg-colors-item__contrast-badge--black {
				color: #000000; /* Fixed: literal black for A11Y contrast testing */
			}

			/* Pass - green background */
			.bsg-colors-item__contrast-badge[data-level="AAA"],
			.bsg-colors-item__contrast-badge[data-level="AA"] {
				background: var(--bsg-success, #10b981);
			}

			/* Large text only - orange background */
			.bsg-colors-item__contrast-badge[data-level="AA-large"] {
				background: var(--bsg-warning, #f59e0b);
			}

			/* Fail - red background */
			.bsg-colors-item__contrast-badge[data-level="fail"] {
				background: var(--bsg-error, #ef4444);
			}

			/* Colors without variants (contextual colors) */
			.bsg-colors-item--no-variants .bsg-colors-item__base {
				width: var(--bsg-space-xl, 5rem);
				height: var(--bsg-space-xl, 5rem);
				min-height: var(--bsg-space-xl, 5rem);
			}

			/* =================================
			   STACKED LAYOUT
			   Base on top, variants in horizontal rows below
			   ================================= */
			.bsg-colors[data-layout="stacked"] .bsg-colors-item__grid {
				flex-direction: column;
				gap: var(--bsg-space-xs, 0.75rem);
			}

			.bsg-colors[data-layout="stacked"] .bsg-colors-item__base-column {
				width: 100%;
			}

			.bsg-colors[data-layout="stacked"] .bsg-colors-item__base {
				width: 100%;
				height: var(--bsg-space-3xl, 7.5rem);
				min-height: var(--bsg-space-3xl, 7.5rem);
			}

			.bsg-colors[data-layout="stacked"] .bsg-colors-item__column {
				flex-direction: row;
				flex-wrap: wrap;
			}

			.bsg-colors[data-layout="stacked"] .bsg-colors-item__swatch {
				flex: 1 1 auto;
				min-width: var(--bsg-space-xl, 3rem);
			}

			/* Note: ACSS stacked layout rules are defined outside @layer for higher specificity */

			/* =================================
			   COMPACT LAYOUT
			   Smaller swatches, labels on hover only
			   ================================= */
			.bsg-colors[data-layout="compact"] .bsg-colors-item {
				gap: var(--bsg-space-3xs, 0.25rem);
			}

			.bsg-colors[data-layout="compact"] .bsg-colors-item__label {
				font-size: var(--bsg-text-xs, 0.75rem);
				opacity: 0;
				max-height: 0;
				overflow: hidden;
				margin: 0;
				transition: opacity 0.2s ease, max-height 0.2s ease, margin 0.2s ease;
			}

			.bsg-colors[data-layout="compact"] .bsg-colors-item:hover .bsg-colors-item__label {
				opacity: 1;
				max-height: 2em;
				margin-bottom: var(--bsg-space-3xs, 0.25rem);
			}

			.bsg-colors[data-layout="compact"] .bsg-colors-item__grid {
				gap: var(--bsg-space-3xs, 0.125em);
			}

			.bsg-colors[data-layout="compact"] .bsg-colors-item__column {
				gap: var(--bsg-space-3xs, 0.125em);
			}

			.bsg-colors[data-layout="compact"] .bsg-colors-item__base {
				width: var(--bsg-space-l, 2rem);
				border-radius: var(--bsg-radius-xs, 0.25em);
			}

			.bsg-colors[data-layout="compact"] .bsg-colors-item__swatch {
				width: var(--bsg-space-m, 1.5rem);
				height: var(--bsg-space-m, 1.5rem);
				border-radius: var(--bsg-radius-xs, 0.25em);
			}

			/* Hide hint in compact mode - too small */
			.bsg-colors[data-layout="compact"] .bsg-colors-item__hint {
				display: none;
			}

			/* Smaller menu in compact mode */
			.bsg-colors[data-layout="compact"] .bsg-colors-item__menu {
				min-width: 16rem;
				padding: var(--bsg-space-2xs, 0.5rem);
			}

			.bsg-colors[data-layout="compact"] .bsg-colors-item__menu-header {
				font-size: var(--bsg-text-xs, 0.75rem);
			}

			/* Note: ACSS compact layout rules are defined outside @layer for higher specificity */

			/* =================================
			   COMPACT VERTICAL LAYOUT
			   Combines compact sizing with stacked/vertical arrangement
			   ================================= */
			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item {
				gap: var(--bsg-space-3xs, 0.25rem);
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__label {
				font-size: var(--bsg-text-xs, 0.75rem);
				opacity: 0;
				max-height: 0;
				overflow: hidden;
				margin: 0;
				transition: opacity 0.2s ease, max-height 0.2s ease, margin 0.2s ease;
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item:hover .bsg-colors-item__label {
				opacity: 1;
				max-height: 2em;
				margin-bottom: var(--bsg-space-3xs, 0.25rem);
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__grid {
				flex-direction: column;
				gap: var(--bsg-space-3xs, 0.125em);
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__base-column {
				width: 100%;
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__base {
				width: 100%;
				height: var(--bsg-space-xl, 3rem);
				min-height: var(--bsg-space-xl, 3rem);
				border-radius: var(--bsg-radius-xs, 0.25em);
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__column {
				flex-direction: row;
				flex-wrap: wrap;
				gap: var(--bsg-space-3xs, 0.125em);
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__swatch {
				flex: 1 1 auto;
				min-width: var(--bsg-space-m, 1.5rem);
				width: var(--bsg-space-m, 1.5rem);
				height: var(--bsg-space-m, 1.5rem);
				border-radius: var(--bsg-radius-xs, 0.25em);
			}

			/* Hide hint in compact-vertical mode - too small */
			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__hint {
				display: none;
			}

			/* Smaller menu in compact-vertical mode */
			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__menu {
				min-width: 16rem;
				padding: var(--bsg-space-2xs, 0.5rem);
			}

			.bsg-colors[data-layout="compact-vertical"] .bsg-colors-item__menu-header {
				font-size: var(--bsg-text-xs, 0.75rem);
			}

			/* Note: ACSS compact-vertical layout rules are defined outside @layer for higher specificity */

			/* =================================
			   MOBILE RESPONSIVE
			   Switch to stacked layout on small screens
			   ================================= */
			@media screen and (max-width: 600px) {
				/* Default layout - switch to stacked on mobile */
				.bsg-colors[data-layout="default"] .bsg-colors-item__grid {
					flex-direction: column !important;
					gap: var(--bsg-space-xs, 0.75rem);
				}

				.bsg-colors[data-layout="default"] .bsg-colors-item__base-column {
					width: 100%;
				}

				.bsg-colors[data-layout="default"] .bsg-colors-item__base {
					width: 100% !important;
					height: var(--bsg-space-2xl, 5rem);
					min-height: var(--bsg-space-2xl, 5rem);
				}

				.bsg-colors[data-layout="default"] .bsg-colors-item__column {
					flex-direction: row;
					flex-wrap: wrap;
				}

				.bsg-colors[data-layout="default"] .bsg-colors-item__swatch {
					flex: 1 1 auto;
					min-width: var(--bsg-space-l, 2.5rem);
				}

				/* Compact layout - make swatches smaller on mobile */
				.bsg-colors[data-layout="compact"] .bsg-colors-item__grid {
					flex-wrap: wrap !important;
				}

				.bsg-colors[data-layout="compact"] .bsg-colors-item__swatch {
					width: var(--bsg-space-s, 1.25rem);
					height: var(--bsg-space-s, 1.25rem);
				}
			}
			} /* end @layer bsg */
		';
	}
}
