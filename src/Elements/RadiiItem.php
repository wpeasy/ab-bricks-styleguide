<?php
/**
 * Radii Item Element for Bricks Builder.
 *
 * Individual border radius sample for use within Radii (Nestable) element.
 *
 * @package AB\BricksSG
 */

namespace AB\BricksSG\Elements;

use AB\BricksSG\Framework\FrameworkDetector;
use AB\BricksSG\Framework\FrameworkVariables;

defined( 'ABSPATH' ) || exit;

/**
 * Radii Item Element.
 */
class RadiiItem extends \Bricks\Element {

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
	public $name = 'bsg-radii-item';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-layout-tab-window';

	/**
	 * Element scripts.
	 *
	 * @var array
	 */
	public $scripts = [ 'bsgRadiiItemInit' ];

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Radii Item', 'bricks-style-guide' );
	}

	/**
	 * Get element keywords.
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'radius', 'border', 'rounded', 'corners', 'item' ];
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

		$this->control_groups['boxStyle'] = [
			'title' => esc_html__( 'Box Style', 'bricks-style-guide' ),
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
			'default'     => $examples['radius_m_raw'],
			'placeholder' => esc_html__( 'e.g.', 'bricks-style-guide' ) . ' ' . $examples['radius_m_raw'],
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

		// Box style controls.
		$this->controls['boxSize'] = [
			'group'       => 'boxStyle',
			'label'       => esc_html__( 'Box Size', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => '6.25em',
			'css'         => [
				[
					'property' => 'width',
					'selector' => '.bsg-radii-item__box',
				],
				[
					'property' => 'height',
					'selector' => '.bsg-radii-item__box',
				],
			],
		];

		$this->controls['boxBackground'] = [
			'group' => 'boxStyle',
			'label' => esc_html__( 'Box Background', 'bricks-style-guide' ),
			'type'  => 'color',
			'css'   => [
				[
					'property' => 'background-color',
					'selector' => '.bsg-radii-item__box',
				],
			],
		];

		$this->controls['boxBorder'] = [
			'group' => 'boxStyle',
			'label' => esc_html__( 'Box Border', 'bricks-style-guide' ),
			'type'  => 'border',
			'css'   => [
				[
					'property' => 'border',
					'selector' => '.bsg-radii-item__box',
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
					'selector' => '.bsg-radii-item__label',
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
					'selector' => '.bsg-radii-item__variable',
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
					'selector' => '.bsg-radii-item__value',
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
		$variable = $settings['variable'] ?? $examples['radius_m_raw'];

		// Bricks checkbox: key exists = checked (true), key missing = unchecked (false).
		// Using "Hide" checkboxes: isset = hide, !isset = show (default).
		$show_label       = ! isset( $settings['hideLabel'] );
		$show_variable    = ! isset( $settings['hideVariable'] );
		$show_value       = ! isset( $settings['hideValue'] );
		$show_value_label = ! isset( $settings['hideValueLabel'] );

		$this->set_attribute( '_root', 'class', [ 'bsg-radii-item' ] );
		$this->set_attribute( '_root', 'data-var', esc_attr( $variable ) );

		$output = "<div {$this->render_attributes( '_root' )}>";

		// Box with border-radius applied.
		$output .= '<div class="bsg-radii-item__box" style="border-radius: var(' . esc_attr( $variable ) . ');"></div>';

		// Info section.
		$output .= '<div class="bsg-radii-item__info">';
		if ( $show_label ) {
			$output .= '<span class="bsg-radii-item__label">' . esc_html( $label ) . '</span>';
		}
		if ( $show_variable ) {
			$output .= '<code class="bsg-radii-item__variable">' . esc_html( $variable ) . '</code>';
		}
		if ( $show_value ) {
			$output .= '<span class="bsg-radii-item__value">';
			if ( $show_value_label ) {
				$output .= '<span class="bsg-radii-item__value-label">' . esc_html__( 'Value:', 'bricks-style-guide' ) . '</span> ';
			}
			$output .= '<span class="bsg-radii-item__computed"></span>';
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
		$handle = 'bsg-radii-item';

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
			.bsg-radii-item {
				' . $framework_vars . '
				display: flex;
				flex-direction: column;
				align-items: center;
				gap: 0.75em;
			}

			.bsg-radii-item__info {
				display: flex;
				flex-direction: column;
				align-items: center;
				gap: 0.25em;
				text-align: center;
			}

			@layer bsg {
			/* === Settings === */
			.bsg-radii-item {
				--_box-size: var(--bsg-radii-item-box-size, 6.25em);
				--_box-bg: var(--bsg-radii-item-box-bg, var(--bsg-neutral-light, #e5e7eb));
				--_box-border-color: var(--bsg-radii-item-box-border-color, var(--bsg-border-color, #d1d5db));
				--_label-font-weight: var(--bsg-radii-item-label-font-weight, 600);
				--_label-font-size: var(--bsg-radii-item-label-font-size, 0.875em);
				--_label-color: var(--bsg-radii-item-label-color, var(--bsg-neutral-darker, #374151));
				--_variable-font-size: var(--bsg-radii-item-variable-font-size, 0.75em);
				--_variable-color: var(--bsg-radii-item-variable-color, var(--bsg-neutral-medium, #6b7280));
				--_variable-bg: var(--bsg-radii-item-variable-bg, var(--bsg-neutral-light, #f3f4f6));
				--_value-font-size: var(--bsg-radii-item-value-font-size, 0.75em);
				--_value-color: var(--bsg-radii-item-value-color, var(--bsg-neutral-medium, #6b7280));
				--_value-label-color: var(--bsg-radii-item-value-label-color, var(--bsg-neutral-darker, #374151));
			}

			.bsg-radii-item__box {
				width: var(--_box-size);
				height: var(--_box-size);
				background-color: var(--_box-bg);
				border: 2px solid var(--_box-border-color);
			}

			.bsg-radii-item__label {
				font-weight: var(--_label-font-weight);
				font-size: var(--_label-font-size);
				color: var(--_label-color);
			}

			.bsg-radii-item__variable {
				font-size: var(--_variable-font-size);
				line-height: 1;
				color: var(--_variable-color);
				background: var(--_variable-bg);
				padding: 0.125em 0.375em;
				border-radius: 0.25em;
			}

			.bsg-radii-item__value {
				font-size: var(--_value-font-size);
				line-height: 1;
				color: var(--_value-color);
			}

			.bsg-radii-item__value-label {
				font-weight: 600;
				color: var(--_value-label-color);
			}
			} /* end @layer bsg */
		';
	}
}
