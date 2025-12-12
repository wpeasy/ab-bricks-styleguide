<?php
/**
 * Buttons Item Element for Bricks Builder.
 *
 * Individual button sample for use within Buttons (Nestable) element.
 *
 * @package AB\ATStyleGuide
 */

namespace AB\ATStyleGuide\Elements;

defined( 'ABSPATH' ) || exit;

/**
 * Buttons Item Element.
 */
class ButtonsItem extends \Bricks\Element {

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
	public $name = 'at-buttons-item';

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
	public $scripts = [ 'atButtonsItemInit' ];

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Button Item', 'advanced-themer-style-guide' );
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
			'title' => esc_html__( 'Content', 'advanced-themer-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['buttonStyle'] = [
			'title' => esc_html__( 'Button Style', 'advanced-themer-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['display'] = [
			'title' => esc_html__( 'Display', 'advanced-themer-style-guide' ),
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
			'default'     => 'Button',
			'placeholder' => esc_html__( 'Button text...', 'advanced-themer-style-guide' ),
		];

		$this->controls['description'] = [
			'group'       => 'content',
			'label'       => esc_html__( 'Description', 'advanced-themer-style-guide' ),
			'type'        => 'text',
			'default'     => '',
			'placeholder' => esc_html__( 'e.g. Primary / Medium', 'advanced-themer-style-guide' ),
		];

		// Button style controls.
		$this->controls['variant'] = [
			'group'    => 'buttonStyle',
			'label'    => esc_html__( 'Variant', 'advanced-themer-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'solid'   => esc_html__( 'Solid (Fill)', 'advanced-themer-style-guide' ),
				'outline' => esc_html__( 'Outline', 'advanced-themer-style-guide' ),
			],
			'default'  => 'solid',
			'inline'   => true,
			'rerender' => true,
		];

		$this->controls['color'] = [
			'group'    => 'buttonStyle',
			'label'    => esc_html__( 'Color', 'advanced-themer-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'primary'   => esc_html__( 'Primary', 'advanced-themer-style-guide' ),
				'secondary' => esc_html__( 'Secondary', 'advanced-themer-style-guide' ),
				'dark'      => esc_html__( 'Dark', 'advanced-themer-style-guide' ),
				'light'     => esc_html__( 'Light', 'advanced-themer-style-guide' ),
				'info'      => esc_html__( 'Info', 'advanced-themer-style-guide' ),
				'success'   => esc_html__( 'Success', 'advanced-themer-style-guide' ),
				'warning'   => esc_html__( 'Warning', 'advanced-themer-style-guide' ),
				'danger'    => esc_html__( 'Danger', 'advanced-themer-style-guide' ),
			],
			'default'  => 'primary',
			'inline'   => true,
			'rerender' => true,
		];

		$this->controls['size'] = [
			'group'    => 'buttonStyle',
			'label'    => esc_html__( 'Size', 'advanced-themer-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'sm' => esc_html__( 'Small', 'advanced-themer-style-guide' ),
				'md' => esc_html__( 'Medium', 'advanced-themer-style-guide' ),
				'lg' => esc_html__( 'Large', 'advanced-themer-style-guide' ),
				'xl' => esc_html__( 'Extra Large', 'advanced-themer-style-guide' ),
			],
			'default'  => 'md',
			'inline'   => true,
			'rerender' => true,
		];

		$this->controls['shape'] = [
			'group'    => 'buttonStyle',
			'label'    => esc_html__( 'Shape', 'advanced-themer-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'default' => esc_html__( 'Default', 'advanced-themer-style-guide' ),
				'square'  => esc_html__( 'Square', 'advanced-themer-style-guide' ),
				'round'   => esc_html__( 'Round', 'advanced-themer-style-guide' ),
				'circle'  => esc_html__( 'Circle', 'advanced-themer-style-guide' ),
			],
			'default'  => 'default',
			'inline'   => true,
			'rerender' => true,
		];

		// Display controls - all "Hide X" for consistency.
		$this->controls['hideDescription'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Description', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideClasses'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide CSS Classes', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		// Typography controls.
		$this->controls['descriptionTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Description Typography', 'advanced-themer-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.atsg-buttons-item__description',
				],
			],
		];

		$this->controls['classesTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Classes Typography', 'advanced-themer-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.atsg-buttons-item__classes',
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

		// Build button classes following Bricks pattern.
		$button_classes = [ 'bricks-button' ];

		// Add variant (outline or solid - solid is default, no class needed).
		if ( 'outline' === $variant ) {
			$button_classes[] = 'outline';
		}

		// Add color.
		$button_classes[] = 'bricks-color-' . $color;

		// Add size.
		$button_classes[] = $size;

		// Add shape.
		if ( 'default' !== $shape ) {
			$button_classes[] = $shape;
		}

		$button_class_string = implode( ' ', $button_classes );

		// Auto-generate description if not provided.
		if ( empty( $description ) ) {
			$variant_label = 'outline' === $variant ? 'Outline' : 'Solid';
			$color_label   = ucfirst( $color );
			$size_label    = strtoupper( $size );
			$description   = "{$color_label} / {$variant_label} / {$size_label}";
		}

		$this->set_attribute( '_root', 'class', [ 'atsg-buttons-item' ] );
		$this->set_attribute( '_root', 'data-variant', esc_attr( $variant ) );
		$this->set_attribute( '_root', 'data-color', esc_attr( $color ) );
		$this->set_attribute( '_root', 'data-size', esc_attr( $size ) );

		$output = "<div {$this->render_attributes( '_root' )}>";

		// Button sample.
		$output .= '<div class="atsg-buttons-item__sample">';
		$output .= '<button type="button" class="' . esc_attr( $button_class_string ) . '">' . esc_html( $label ) . '</button>';
		$output .= '</div>';

		// Info section.
		$output .= '<div class="atsg-buttons-item__info">';
		if ( $show_description && ! empty( $description ) ) {
			$output .= '<span class="atsg-buttons-item__description">' . esc_html( $description ) . '</span>';
		}
		if ( $show_classes ) {
			$class_spans = array_map(
				function ( $class ) {
					return '<span class="class-name">' . esc_html( $class ) . '</span>';
				},
				$button_classes
			);
			$output .= '<code class="atsg-buttons-item__classes">' . implode( ' ', $class_spans ) . '</code>';
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
			'at-buttons-item',
			false,
			[],
			AT_STYLE_GUIDE_VERSION
		);
		wp_add_inline_style( 'at-buttons-item', $this->get_element_css() );
		wp_enqueue_style( 'at-buttons-item' );
	}

	/**
	 * Get inline CSS for the element.
	 *
	 * @return string
	 */
	private function get_element_css(): string {
		return '
			.atsg-buttons-item {
				display: flex;
				flex-direction: column;
				align-items: center;
				gap: 0.75em;
			}

			.atsg-buttons-item__sample {
				display: flex;
				align-items: center;
				justify-content: center;
			}

			.atsg-buttons-item__info {
				display: flex;
				flex-direction: column;
				align-items: center;
				gap: 0.25em;
				text-align: center;
			}

			.atsg-buttons-item__description {
				font-weight: 600;
				font-size: 0.875em;
				color: var(--at-neutral-d-3, #374151);
			}

			.atsg-buttons-item__classes {
				font-size: 0.75em;
				color: var(--at-neutral-d-2, #6b7280);
				background: var(--at-neutral-t-6, #f3f4f6);
				padding: 0.125em 0.375em;
				border-radius: 0.25em;
				word-spacing: 0.25em;
			}

			.atsg-buttons-item__classes .class-name {
				white-space: nowrap;
				display: inline;
			}
		';
	}
}
