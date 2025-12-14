<?php
/**
 * Buttons Item Element for Bricks Builder.
 *
 * Individual button sample for use within Buttons (Nestable) element.
 *
 * @package AB\BricksSG
 */

namespace AB\BricksSG\Elements;

use AB\BricksSG\Framework\FrameworkDetector;
use AB\BricksSG\Framework\FrameworkVariables;

defined( 'ABSPATH' ) || exit;

/**
 * Buttons Item Element.
 */
class ButtonsItem extends \Bricks\Element {

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
	public $name = 'bsg-buttons-item';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-hand-point-up';

	/**
	 * Element scripts.
	 *
	 * @var array
	 */
	public $scripts = [ 'bsgButtonsItemInit' ];

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Button Item', 'bricks-style-guide' );
	}

	/**
	 * Get element keywords.
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'button', 'cta', 'action', 'item' ];
	}

	/**
	 * Set control groups.
	 *
	 * @return void
	 */
	public function set_control_groups(): void {
		$this->control_groups['content'] = [
			'title' => esc_html__( 'Content', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['buttonStyle'] = [
			'title' => esc_html__( 'Button Style', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['display'] = [
			'title' => esc_html__( 'Display', 'bricks-style-guide' ),
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
		// Content controls.
		$this->controls['label'] = [
			'group'       => 'content',
			'label'       => esc_html__( 'Label', 'bricks-style-guide' ),
			'type'        => 'text',
			'default'     => 'Button',
			'placeholder' => esc_html__( 'Button text...', 'bricks-style-guide' ),
		];

		$this->controls['description'] = [
			'group'       => 'content',
			'label'       => esc_html__( 'Description', 'bricks-style-guide' ),
			'type'        => 'text',
			'default'     => '',
			'placeholder' => esc_html__( 'e.g. Primary / Medium', 'bricks-style-guide' ),
		];

		// Button style controls.
		$this->controls['variant'] = [
			'group'    => 'buttonStyle',
			'label'    => esc_html__( 'Variant', 'bricks-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'solid'   => esc_html__( 'Solid (Fill)', 'bricks-style-guide' ),
				'outline' => esc_html__( 'Outline', 'bricks-style-guide' ),
			],
			'default'  => 'solid',
			'inline'   => true,
			'rerender' => true,
		];

		// Color options differ by framework.
		$is_acss       = FrameworkDetector::is_acss_active();
		$color_options = $is_acss ? $this->get_acss_color_options() : $this->get_bricks_color_options();

		$this->controls['color'] = [
			'group'    => 'buttonStyle',
			'label'    => esc_html__( 'Color', 'bricks-style-guide' ),
			'type'     => 'select',
			'options'  => $color_options,
			'default'  => 'primary',
			'inline'   => true,
			'rerender' => true,
		];

		$this->controls['size'] = [
			'group'    => 'buttonStyle',
			'label'    => esc_html__( 'Size', 'bricks-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'sm' => esc_html__( 'Small', 'bricks-style-guide' ),
				'md' => esc_html__( 'Medium', 'bricks-style-guide' ),
				'lg' => esc_html__( 'Large', 'bricks-style-guide' ),
				'xl' => esc_html__( 'Extra Large', 'bricks-style-guide' ),
			],
			'default'  => 'md',
			'inline'   => true,
			'rerender' => true,
		];

		$this->controls['shape'] = [
			'group'    => 'buttonStyle',
			'label'    => esc_html__( 'Shape', 'bricks-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'default' => esc_html__( 'Default', 'bricks-style-guide' ),
				'square'  => esc_html__( 'Square', 'bricks-style-guide' ),
				'round'   => esc_html__( 'Round', 'bricks-style-guide' ),
				'circle'  => esc_html__( 'Circle', 'bricks-style-guide' ),
			],
			'default'  => 'default',
			'inline'   => true,
			'rerender' => true,
		];

		// Display controls - all "Hide X" for consistency.
		$this->controls['hideDescription'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Description', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideClasses'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide CSS Classes', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		// Typography controls.
		$this->controls['descriptionTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Description Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-buttons-item__description',
				],
			],
		];

		$this->controls['classesTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Classes Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-buttons-item__classes',
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

		$label       = $settings['label'] ?? 'Button';
		$description = $settings['description'] ?? '';
		$variant     = $settings['variant'] ?? 'solid';
		$color       = $settings['color'] ?? 'primary';
		$size        = $settings['size'] ?? 'md';
		$shape       = $settings['shape'] ?? 'default';

		// Using "Hide" checkboxes: isset = hide, !isset = show (default).
		$show_description = ! isset( $settings['hideDescription'] );
		$show_classes     = ! isset( $settings['hideClasses'] );

		// Build button classes based on active framework.
		$is_acss        = FrameworkDetector::is_acss_active();
		$button_classes = $this->get_button_classes( $variant, $color, $size, $shape, $is_acss );

		// Always add our internal class for styling.
		$render_classes   = array_merge( [ 'bsg-btn' ], $button_classes );
		$render_class_str = implode( ' ', $render_classes );

		// Auto-generate description if not provided.
		if ( empty( $description ) ) {
			$variant_label = 'outline' === $variant ? 'Outline' : 'Solid';
			$color_label   = ucfirst( $color );
			$size_label    = strtoupper( $size );
			$description   = "{$color_label} / {$variant_label} / {$size_label}";
		}

		$this->set_attribute( '_root', 'class', [ 'bsg-buttons-item' ] );
		$this->set_attribute( '_root', 'data-variant', esc_attr( $variant ) );
		$this->set_attribute( '_root', 'data-color', esc_attr( $color ) );
		$this->set_attribute( '_root', 'data-size', esc_attr( $size ) );

		$output = "<div {$this->render_attributes( '_root' )}>";

		// Button sample.
		$output .= '<div class="bsg-buttons-item__sample">';
		$output .= '<button type="button" class="' . esc_attr( $render_class_str ) . '">' . esc_html( $label ) . '</button>';
		$output .= '</div>';

		// Info section.
		$output .= '<div class="bsg-buttons-item__info">';
		if ( $show_description && ! empty( $description ) ) {
			$output .= '<span class="bsg-buttons-item__description">' . esc_html( $description ) . '</span>';
		}
		if ( $show_classes ) {
			// Show only the framework-specific classes (not our internal bsg-btn class).
			$class_spans = array_map(
				function ( $class ) {
					return '<span class="class-name">' . esc_html( $class ) . '</span>';
				},
				$button_classes
			);
			$output .= '<code class="bsg-buttons-item__classes">' . implode( ' ', $class_spans ) . '</code>';
		}
		$output .= '</div>';

		$output .= '</div>';

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Get Bricks/AT button color options.
	 *
	 * @return array
	 */
	private function get_bricks_color_options(): array {
		return [
			'primary'   => esc_html__( 'Primary', 'bricks-style-guide' ),
			'secondary' => esc_html__( 'Secondary', 'bricks-style-guide' ),
			'dark'      => esc_html__( 'Dark', 'bricks-style-guide' ),
			'light'     => esc_html__( 'Light', 'bricks-style-guide' ),
			'info'      => esc_html__( 'Info', 'bricks-style-guide' ),
			'success'   => esc_html__( 'Success', 'bricks-style-guide' ),
			'warning'   => esc_html__( 'Warning', 'bricks-style-guide' ),
			'danger'    => esc_html__( 'Danger', 'bricks-style-guide' ),
		];
	}

	/**
	 * Get ACSS button color options.
	 *
	 * ACSS generates button styles for primary and secondary colors,
	 * each with -dark and -light variants.
	 *
	 * @return array
	 */
	private function get_acss_color_options(): array {
		return [
			'primary'         => esc_html__( 'Primary', 'bricks-style-guide' ),
			'primary-dark'    => esc_html__( 'Primary Dark', 'bricks-style-guide' ),
			'primary-light'   => esc_html__( 'Primary Light', 'bricks-style-guide' ),
			'secondary'       => esc_html__( 'Secondary', 'bricks-style-guide' ),
			'secondary-dark'  => esc_html__( 'Secondary Dark', 'bricks-style-guide' ),
			'secondary-light' => esc_html__( 'Secondary Light', 'bricks-style-guide' ),
		];
	}

	/**
	 * Get button classes based on the active framework.
	 *
	 * @param string $variant The button variant (solid/outline).
	 * @param string $color   The button color.
	 * @param string $size    The button size.
	 * @param string $shape   The button shape.
	 * @param bool   $is_acss Whether ACSS is active.
	 * @return array Array of CSS classes.
	 */
	private function get_button_classes( string $variant, string $color, string $size, string $shape, bool $is_acss ): array {
		if ( $is_acss ) {
			return $this->get_acss_button_classes( $variant, $color, $size, $shape );
		}

		return $this->get_bricks_button_classes( $variant, $color, $size, $shape );
	}

	/**
	 * Get ACSS button classes.
	 *
	 * ACSS uses: .btn, .btn--primary, .btn--secondary with -dark and -light variants.
	 * Sizes: btn--s, btn--m, btn--l, btn--xl.
	 *
	 * @param string $variant The button variant.
	 * @param string $color   The button color.
	 * @param string $size    The button size.
	 * @param string $shape   The button shape (not used for ACSS - no rounded class).
	 * @return array Array of CSS classes.
	 */
	private function get_acss_button_classes( string $variant, string $color, string $size, string $shape ): array {
		$classes = [ 'btn' ];

		// Color class - ACSS has primary and secondary with -dark/-light variants.
		$valid_colors = [
			'primary', 'primary-dark', 'primary-light',
			'secondary', 'secondary-dark', 'secondary-light',
		];
		$acss_color   = in_array( $color, $valid_colors, true ) ? $color : 'primary';
		$classes[]    = 'btn--' . $acss_color;

		// Variant - outline.
		if ( 'outline' === $variant ) {
			$classes[] = 'btn--outline';
		}

		// Size - ACSS uses btn--s, btn--m, btn--l, btn--xl (not sm/md/lg).
		$size_map = [
			'sm' => 'btn--s',
			'md' => 'btn--m',
			'lg' => 'btn--l',
			'xl' => 'btn--xl',
		];

		if ( ! empty( $size_map[ $size ] ) ) {
			$classes[] = $size_map[ $size ];
		}

		// Note: ACSS does not have a rounded/pill button class.

		return $classes;
	}

	/**
	 * Get Bricks/AT button classes.
	 *
	 * Bricks uses: .bricks-button, .bricks-color-primary, etc.
	 *
	 * @param string $variant The button variant.
	 * @param string $color   The button color.
	 * @param string $size    The button size.
	 * @param string $shape   The button shape.
	 * @return array Array of CSS classes.
	 */
	private function get_bricks_button_classes( string $variant, string $color, string $size, string $shape ): array {
		$classes = [ 'bricks-button' ];

		// Variant (outline or solid - solid is default, no class needed).
		if ( 'outline' === $variant ) {
			$classes[] = 'outline';
		}

		// Color.
		$classes[] = 'bricks-color-' . $color;

		// Size.
		$classes[] = $size;

		// Shape.
		if ( 'default' !== $shape ) {
			$classes[] = $shape;
		}

		return $classes;
	}

	/**
	 * Enqueue element styles.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {
		$handle = 'bsg-buttons-item';

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
		$framework_vars = FrameworkVariables::get_css_variables();

		return '
			/* Layout only - button styling handled by Bricks/AT/ACSS */
			.bsg-buttons-item {
				' . $framework_vars . '
				display: flex;
				flex-direction: column;
				align-items: center;
				gap: var(--bsg-space-s, 0.75em);
			}

			.bsg-buttons-item__sample {
				display: flex;
				align-items: center;
				justify-content: center;
			}

			.bsg-buttons-item__info {
				display: flex;
				flex-direction: column;
				align-items: center;
				gap: var(--bsg-space-3xs, 0.25em);
				text-align: center;
			}

			@layer bsg {
			/* === Settings === */
			.bsg-buttons-item {
				--_description-font-weight: var(--bsg-buttons-item-description-font-weight, 600);
				--_description-font-size: var(--bsg-buttons-item-description-font-size, 0.875em);
				--_description-color: var(--bsg-buttons-item-description-color, var(--bsg-neutral-darker, #374151));
				--_classes-font-size: var(--bsg-buttons-item-classes-font-size, 0.75em);
				--_classes-color: var(--bsg-buttons-item-classes-color, var(--bsg-neutral-medium, #6b7280));
				--_classes-bg: var(--bsg-buttons-item-classes-bg, var(--bsg-neutral-light, #f3f4f6));
			}

			.bsg-buttons-item__description {
				font-weight: var(--_description-font-weight);
				font-size: var(--_description-font-size);
				line-height: 1;
				color: var(--_description-color);
			}

			.bsg-buttons-item__classes {
				font-size: var(--_classes-font-size);
				line-height: 1;
				color: var(--_classes-color);
				background: var(--_classes-bg);
				padding: 0.125em 0.375em;
				border-radius: var(--bsg-radius-xs, 0.25em);
				word-spacing: 0.25em;
			}

			.bsg-buttons-item__classes .class-name {
				white-space: nowrap;
				display: inline;
			}
			} /* end @layer bsg */
		';
	}
}
