<?php
/**
 * Spacing Item Element for Bricks Builder.
 *
 * Individual spacing sample row for use within Spacing (Nestable) element.
 *
 * @package AB\BricksSG
 */

namespace AB\BricksSG\Elements;

use AB\BricksSG\Framework\FrameworkDetector;
use AB\BricksSG\Framework\FrameworkVariables;

defined( 'ABSPATH' ) || exit;

/**
 * Spacing Item Element.
 */
class SpacingItem extends \Bricks\Element {

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
	public $name = 'bsg-spacing-item';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-layout-width-default';

	/**
	 * Element scripts.
	 *
	 * @var array
	 */
	public $scripts = [ 'bsgSpacingItemInit' ];

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Spacing Item', 'bricks-style-guide' );
	}

	/**
	 * Get element keywords.
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'spacing', 'gap', 'margin', 'padding', 'item' ];
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

		$this->control_groups['display'] = [
			'title' => esc_html__( 'Display', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['barStyle'] = [
			'title' => esc_html__( 'Bar Style', 'bricks-style-guide' ),
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
		$examples = FrameworkDetector::get_example_variables();

		// Content controls.
		$this->controls['label'] = [
			'group'       => 'content',
			'label'       => esc_html__( 'Label', 'bricks-style-guide' ),
			'type'        => 'text',
			'default'     => 'Medium',
			'placeholder' => esc_html__( 'e.g. Small, Medium, Large...', 'bricks-style-guide' ),
		];

		$this->controls['variable'] = [
			'group'       => 'content',
			'label'       => esc_html__( 'CSS Variable', 'bricks-style-guide' ),
			'type'        => 'text',
			'default'     => $examples['space_m_raw'],
			'placeholder' => esc_html__( 'e.g.', 'bricks-style-guide' ) . ' ' . $examples['space_m_raw'],
		];

		// Display controls - all "Hide X" for consistency.
		$this->controls['hideLabel'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Label', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideVariable'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Variable Name', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideValue'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Computed Value', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideValueLabel'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Value Label', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		// Bar style controls.
		$this->controls['barColor'] = [
			'group' => 'barStyle',
			'label' => esc_html__( 'Bar Color', 'bricks-style-guide' ),
			'type'  => 'color',
			'css'   => [
				[
					'property' => 'background-color',
					'selector' => '.bsg-spacing-item__bar',
				],
			],
		];

		$this->controls['barThickness'] = [
			'group'       => 'barStyle',
			'label'       => esc_html__( 'Bar Thickness', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => '1.5em',
			'css'         => [
				[
					'property' => '--bsg-bar-thickness',
					'selector' => '',
				],
			],
		];

		// Typography controls.
		$this->controls['labelTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Label Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-spacing-item__label',
				],
			],
		];

		$this->controls['variableTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Variable Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-spacing-item__variable',
				],
			],
		];

		$this->controls['valueTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Value Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-spacing-item__value',
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

		$examples = FrameworkDetector::get_example_variables();
		$label    = $settings['label'] ?? 'Medium';
		$variable = $settings['variable'] ?? $examples['space_m_raw'];

		// Bricks checkbox: key exists = checked (true), key missing = unchecked (false).
		// Using "Hide" checkboxes: isset = hide, !isset = show (default).
		$show_label       = ! isset( $settings['hideLabel'] );
		$show_variable    = ! isset( $settings['hideVariable'] );
		$show_value       = ! isset( $settings['hideValue'] );
		$show_value_label = ! isset( $settings['hideValueLabel'] );

		$this->set_attribute( '_root', 'class', [ 'bsg-spacing-item' ] );
		$this->set_attribute( '_root', 'data-var', esc_attr( $variable ) );

		$output = "<div {$this->render_attributes( '_root' )}>";

		// Info section (label + variable).
		$output .= '<div class="bsg-spacing-item__info">';
		if ( $show_label ) {
			$output .= '<span class="bsg-spacing-item__label">' . esc_html( $label ) . '</span>';
		}
		if ( $show_variable ) {
			$output .= '<code class="bsg-spacing-item__variable">' . esc_html( $variable ) . '</code>';
		}
		$output .= '</div>';

		// Bar container - set both width and height to the spacing value, CSS controls which one applies.
		$output .= '<div class="bsg-spacing-item__bar-container">';
		$output .= '<div class="bsg-spacing-item__bar" style="width: var(' . esc_attr( $variable ) . '); height: var(' . esc_attr( $variable ) . ');"></div>';
		if ( $show_value ) {
			$output .= '<span class="bsg-spacing-item__value">';
			if ( $show_value_label ) {
				$output .= '<span class="bsg-spacing-item__value-label">' . esc_html__( 'Value:', 'bricks-style-guide' ) . '</span> ';
			}
			$output .= '<span class="bsg-spacing-item__computed"></span>';
			$output .= '</span>';
		}
		$output .= '</div>';

		$output .= '</div>';

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Enqueue element styles.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {
		$handle = 'bsg-spacing-item';

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
			/* Critical layout */
			.bsg-spacing-item {
				' . $framework_vars . '
				display: flex;
				align-items: center;
				gap: 1em;
			}

			.bsg-spacing-item__info {
				display: flex;
				flex-direction: column;
				gap: 0.25em;
				min-width: 7.5em;
			}

			.bsg-spacing-item__bar-container {
				display: flex;
				align-items: center;
				gap: 0.75em;
				flex: 1;
			}

			/* Mobile responsive layout */
			@media screen and (max-width: 600px) {
				.bsg-spacing-item {
					flex-direction: column;
					align-items: flex-start;
				}

				.bsg-spacing-item__info {
					min-width: auto;
					flex-direction: row;
					gap: 0.5em;
					align-items: center;
				}

				.bsg-spacing-item__bar-container {
					width: 100%;
				}
			}

			@layer bsg {
			/* === Settings === */
			.bsg-spacing-item {
				/* Label Typography */
				--_label-font-family: var(--bsg-spacing-item-label-font-family, inherit);
				--_label-font-size: var(--bsg-spacing-item-label-font-size, 0.875em);
				--_label-font-weight: var(--bsg-spacing-item-label-font-weight, 600);
				--_label-line-height: var(--bsg-spacing-item-label-line-height, 1.4);
				--_label-letter-spacing: var(--bsg-spacing-item-label-letter-spacing, normal);
				--_label-text-transform: var(--bsg-spacing-item-label-text-transform, none);
				--_label-color: var(--bsg-spacing-item-label-color, var(--bsg-neutral-darker, #374151));

				/* Variable Typography */
				--_variable-font-family: var(--bsg-spacing-item-variable-font-family, inherit);
				--_variable-font-size: var(--bsg-spacing-item-variable-font-size, 0.75em);
				--_variable-font-weight: var(--bsg-spacing-item-variable-font-weight, 400);
				--_variable-line-height: var(--bsg-spacing-item-variable-line-height, 1);
				--_variable-letter-spacing: var(--bsg-spacing-item-variable-letter-spacing, normal);
				--_variable-text-transform: var(--bsg-spacing-item-variable-text-transform, none);
				--_variable-color: var(--bsg-spacing-item-variable-color, var(--bsg-neutral-medium, #6b7280));
				--_variable-bg: var(--bsg-spacing-item-variable-bg, var(--bsg-neutral-light, #f3f4f6));

				/* Value Typography */
				--_value-font-family: var(--bsg-spacing-item-value-font-family, inherit);
				--_value-font-size: var(--bsg-spacing-item-value-font-size, 0.75em);
				--_value-font-weight: var(--bsg-spacing-item-value-font-weight, 400);
				--_value-line-height: var(--bsg-spacing-item-value-line-height, 1);
				--_value-letter-spacing: var(--bsg-spacing-item-value-letter-spacing, normal);
				--_value-text-transform: var(--bsg-spacing-item-value-text-transform, none);
				--_value-color: var(--bsg-spacing-item-value-color, var(--bsg-neutral-medium, #6b7280));

				/* Value Label Typography */
				--_value-label-font-family: var(--bsg-spacing-item-value-label-font-family, inherit);
				--_value-label-font-size: var(--bsg-spacing-item-value-label-font-size, inherit);
				--_value-label-font-weight: var(--bsg-spacing-item-value-label-font-weight, 600);
				--_value-label-line-height: var(--bsg-spacing-item-value-label-line-height, inherit);
				--_value-label-letter-spacing: var(--bsg-spacing-item-value-label-letter-spacing, normal);
				--_value-label-text-transform: var(--bsg-spacing-item-value-label-text-transform, none);
				--_value-label-color: var(--bsg-spacing-item-value-label-color, var(--bsg-neutral-darker, #374151));

				/* Bar Style */
				--_bar-color: var(--bsg-spacing-item-bar-color, var(--bsg-primary, #3b82f6));
				--_bar-radius: var(--bsg-spacing-item-bar-radius, 0.25em);
			}

			.bsg-spacing-item__label {
				font-family: var(--_label-font-family);
				font-size: var(--_label-font-size);
				font-weight: var(--_label-font-weight);
				line-height: var(--_label-line-height);
				letter-spacing: var(--_label-letter-spacing);
				text-transform: var(--_label-text-transform);
				color: var(--_label-color);
			}

			.bsg-spacing-item__variable {
				font-family: var(--_variable-font-family);
				font-size: var(--_variable-font-size);
				font-weight: var(--_variable-font-weight);
				line-height: var(--_variable-line-height);
				letter-spacing: var(--_variable-letter-spacing);
				text-transform: var(--_variable-text-transform);
				color: var(--_variable-color);
				background: var(--_variable-bg);
				padding: 0.125em 0.375em;
				border-radius: 0.25em;
				width: fit-content;
			}

			.bsg-spacing-item__bar {
				background-color: var(--_bar-color);
				border-radius: var(--_bar-radius);
				min-width: 0.25em;
				min-height: 0.25em;
				transition: width 0.2s ease, height 0.2s ease;
			}

			.bsg-spacing-item__value {
				font-family: var(--_value-font-family);
				font-size: var(--_value-font-size);
				font-weight: var(--_value-font-weight);
				line-height: var(--_value-line-height);
				letter-spacing: var(--_value-letter-spacing);
				text-transform: var(--_value-text-transform);
				color: var(--_value-color);
				min-width: 3.125em;
			}

			.bsg-spacing-item__value-label {
				font-family: var(--_value-label-font-family);
				font-size: var(--_value-label-font-size);
				font-weight: var(--_value-label-font-weight);
				line-height: var(--_value-label-line-height);
				letter-spacing: var(--_value-label-letter-spacing);
				text-transform: var(--_value-label-text-transform);
				color: var(--_value-label-color);
			}
			} /* end @layer bsg */
		';
	}
}
