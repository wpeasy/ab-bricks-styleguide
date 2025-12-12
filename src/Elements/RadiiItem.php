<?php
/**
 * Radii Item Element for Bricks Builder.
 *
 * Individual border radius sample for use within Radii (Nestable) element.
 *
 * @package AB\ATStyleGuide
 */

namespace AB\ATStyleGuide\Elements;

defined( 'ABSPATH' ) || exit;

/**
 * Radii Item Element.
 */
class RadiiItem extends \Bricks\Element {

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
	public $name = 'at-radii-item';

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
	public $scripts = [ 'atRadiiItemInit' ];

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Radii Item', 'advanced-themer-style-guide' );
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
			'title' => esc_html__( 'Content', 'advanced-themer-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['display'] = [
			'title' => esc_html__( 'Display', 'advanced-themer-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['boxStyle'] = [
			'title' => esc_html__( 'Box Style', 'advanced-themer-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['typography'] = [
			'title' => esc_html__( 'Typography', 'advanced-themer-style-guide' ),
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
			'label'       => esc_html__( 'Label', 'advanced-themer-style-guide' ),
			'type'        => 'text',
			'default'     => 'Medium',
			'placeholder' => esc_html__( 'e.g. Small, Medium, Large...', 'advanced-themer-style-guide' ),
		];

		$this->controls['variable'] = [
			'group'       => 'content',
			'label'       => esc_html__( 'CSS Variable', 'advanced-themer-style-guide' ),
			'type'        => 'text',
			'default'     => '--at-radius--m',
			'placeholder' => esc_html__( 'e.g. --at-radius--m', 'advanced-themer-style-guide' ),
		];

		// Display controls - all "Hide X" for consistency.
		$this->controls['hideLabel'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Label', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideVariable'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Variable Name', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideValue'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Computed Value', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideValueLabel'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Value Label', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		// Box style controls.
		$this->controls['boxSize'] = [
			'group'       => 'boxStyle',
			'label'       => esc_html__( 'Box Size', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => '6.25em',
			'css'         => [
				[
					'property' => 'width',
					'selector' => '.atsg-radii-item__box',
				],
				[
					'property' => 'height',
					'selector' => '.atsg-radii-item__box',
				],
			],
		];

		$this->controls['boxBackground'] = [
			'group' => 'boxStyle',
			'label' => esc_html__( 'Box Background', 'advanced-themer-style-guide' ),
			'type'  => 'color',
			'css'   => [
				[
					'property' => 'background-color',
					'selector' => '.atsg-radii-item__box',
				],
			],
		];

		$this->controls['boxBorder'] = [
			'group' => 'boxStyle',
			'label' => esc_html__( 'Box Border', 'advanced-themer-style-guide' ),
			'type'  => 'border',
			'css'   => [
				[
					'property' => 'border',
					'selector' => '.atsg-radii-item__box',
				],
			],
		];

		// Typography controls.
		$this->controls['labelTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Label Typography', 'advanced-themer-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.atsg-radii-item__label',
				],
			],
		];

		$this->controls['variableTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Variable Typography', 'advanced-themer-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.atsg-radii-item__variable',
				],
			],
		];

		$this->controls['valueTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Value Typography', 'advanced-themer-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.atsg-radii-item__value',
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

		$label    = $settings['label'] ?? 'Medium';
		$variable = $settings['variable'] ?? '--at-radius--m';

		// Bricks checkbox: key exists = checked (true), key missing = unchecked (false).
		// Using "Hide" checkboxes: isset = hide, !isset = show (default).
		$show_label       = ! isset( $settings['hideLabel'] );
		$show_variable    = ! isset( $settings['hideVariable'] );
		$show_value       = ! isset( $settings['hideValue'] );
		$show_value_label = ! isset( $settings['hideValueLabel'] );

		$this->set_attribute( '_root', 'class', [ 'atsg-radii-item' ] );
		$this->set_attribute( '_root', 'data-var', esc_attr( $variable ) );

		$output = "<div {$this->render_attributes( '_root' )}>";

		// Box with border-radius applied.
		$output .= '<div class="atsg-radii-item__box" style="border-radius: var(' . esc_attr( $variable ) . ');"></div>';

		// Info section.
		$output .= '<div class="atsg-radii-item__info">';
		if ( $show_label ) {
			$output .= '<span class="atsg-radii-item__label">' . esc_html( $label ) . '</span>';
		}
		if ( $show_variable ) {
			$output .= '<code class="atsg-radii-item__variable">' . esc_html( $variable ) . '</code>';
		}
		if ( $show_value ) {
			$output .= '<span class="atsg-radii-item__value">';
			if ( $show_value_label ) {
				$output .= '<span class="atsg-radii-item__value-label">' . esc_html__( 'Value:', 'advanced-themer-style-guide' ) . '</span> ';
			}
			$output .= '<span class="atsg-radii-item__computed"></span>';
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
		wp_register_style(
			'at-radii-item',
			false,
			[],
			AT_STYLE_GUIDE_VERSION
		);
		wp_add_inline_style( 'at-radii-item', $this->get_element_css() );
		wp_enqueue_style( 'at-radii-item' );
	}

	/**
	 * Get inline CSS for the element.
	 *
	 * @return string
	 */
	private function get_element_css(): string {
		return '
			.atsg-radii-item {
				display: flex;
				flex-direction: column;
				align-items: center;
				gap: 0.75em;
			}

			.atsg-radii-item__box {
				width: 6.25em;
				height: 6.25em;
				background-color: var(--at-neutral-t-5, #e5e7eb);
				border: 2px solid #9ca3af;
			}

			.atsg-radii-item__info {
				display: flex;
				flex-direction: column;
				align-items: center;
				gap: 0.25em;
				text-align: center;
			}

			.atsg-radii-item__label {
				font-weight: 600;
				font-size: 0.875em;
				color: var(--at-neutral-d-3, #374151);
			}

			.atsg-radii-item__variable {
				font-size: 0.75em;
				color: var(--at-neutral-d-2, #6b7280);
				background: var(--at-neutral-t-6, #f3f4f6);
				padding: 0.125em 0.375em;
				border-radius: 0.25em;
			}

			.atsg-radii-item__value {
				font-size: 0.75em;
				color: var(--at-neutral-d-2, #6b7280);
			}

			.atsg-radii-item__value-label {
				font-weight: 600;
				color: var(--at-neutral-d-3, #374151);
			}
		';
	}
}
