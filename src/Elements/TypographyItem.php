<?php
/**
 * Typography Item Element for Bricks Builder.
 *
 * Individual typography sample row for use within Typography (Nestable) element.
 *
 * @package AB\ATStyleGuide
 */

namespace AB\ATStyleGuide\Elements;

defined( 'ABSPATH' ) || exit;

/**
 * Typography Item Element.
 */
class TypographyItem extends \Bricks\Element {

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
	public $name = 'at-typography-item';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-smallcap';

	/**
	 * Element scripts.
	 *
	 * @var array
	 */
	public $scripts = [ 'atTypographyItemInit' ];

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Typography Item', 'advanced-themer-style-guide' );
	}

	/**
	 * Get element keywords.
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'typography', 'font', 'heading', 'text', 'item' ];
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

		$this->control_groups['style'] = [
			'title' => esc_html__( 'Item Style', 'advanced-themer-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['typography'] = [
			'title' => esc_html__( 'Sample Typography', 'advanced-themer-style-guide' ),
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
			'default'     => 'Heading 1',
			'placeholder' => esc_html__( 'e.g. Heading 1, Body, Lead...', 'advanced-themer-style-guide' ),
		];

		$this->controls['tag'] = [
			'group'   => 'content',
			'label'   => esc_html__( 'HTML Tag', 'advanced-themer-style-guide' ),
			'type'    => 'select',
			'options' => [
				'h1'   => 'H1',
				'h2'   => 'H2',
				'h3'   => 'H3',
				'h4'   => 'H4',
				'h5'   => 'H5',
				'h6'   => 'H6',
				'p'    => 'Paragraph',
				'span' => 'Span',
				'div'  => 'Div',
			],
			'default' => 'h1',
			'inline'  => true,
		];

		$this->controls['sampleText'] = [
			'group'       => 'content',
			'label'       => esc_html__( 'Sample Text', 'advanced-themer-style-guide' ),
			'type'        => 'text',
			'default'     => 'The quick brown fox jumps over the lazy dog',
			'placeholder' => esc_html__( 'Enter sample text...', 'advanced-themer-style-guide' ),
		];

		// Display controls - all "Hide X" for consistency.
		// Unchecked = show (default), Checked = hide.
		$this->controls['hideLabel'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Label', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideFontFamily'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Font Family', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideFontSize'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Font Size', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideLineHeight'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Line Height', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideFontWeight'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Font Weight', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideLetterSpacing'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Letter Spacing', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideColor'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Color', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideTextTransform'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Text Transform', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideFontStyle'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Font Style', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideValueLabels'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Value Labels', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		// Item style controls.
		$this->controls['itemBackground'] = [
			'group' => 'style',
			'label' => esc_html__( 'Background', 'advanced-themer-style-guide' ),
			'type'  => 'color',
			'css'   => [
				[
					'property' => 'background-color',
					'selector' => '',
				],
			],
		];

		// Typography controls for the sample.
		$this->controls['sampleClass'] = [
			'group'       => 'typography',
			'label'       => esc_html__( 'Class', 'advanced-themer-style-guide' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'e.g. .text--xs', 'advanced-themer-style-guide' ),
			'description' => esc_html__( 'You need to define these classes in your CSS.', 'advanced-themer-style-guide' ),
		];

		$this->controls['sampleTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Sample Typography', 'advanced-themer-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.atsg-typography-item__sample',
				],
			],
		];

		$this->controls['labelTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Label Typography', 'advanced-themer-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.atsg-typography-item__label',
				],
			],
		];

		$this->controls['metaTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Meta Typography', 'advanced-themer-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.atsg-typography-item__meta',
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

		$label        = $settings['label'] ?? 'Heading 1';
		$tag          = $settings['tag'] ?? 'h1';
		$sample_text  = $settings['sampleText'] ?? 'The quick brown fox jumps over the lazy dog';
		$sample_class = $settings['sampleClass'] ?? '';

		// Bricks checkbox: key exists = checked (true), key missing = unchecked (false).
		// Using "Hide" checkboxes: isset = hide, !isset = show (default).
		$show_label          = ! isset( $settings['hideLabel'] );
		$show_font_family    = ! isset( $settings['hideFontFamily'] );
		$show_font_size      = ! isset( $settings['hideFontSize'] );
		$show_line_height    = ! isset( $settings['hideLineHeight'] );
		$show_font_weight    = ! isset( $settings['hideFontWeight'] );
		$show_letter_spacing = ! isset( $settings['hideLetterSpacing'] );
		$show_color          = ! isset( $settings['hideColor'] );
		$show_text_transform = ! isset( $settings['hideTextTransform'] );
		$show_font_style     = ! isset( $settings['hideFontStyle'] );
		$show_value_labels   = ! isset( $settings['hideValueLabels'] );

		// Allowed tags for the sample.
		$allowed_tags = [ 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'p', 'span', 'div' ];
		if ( ! in_array( $tag, $allowed_tags, true ) ) {
			$tag = 'h1';
		}

		// Build sample classes.
		$sample_classes = [ 'atsg-typography-item__sample' ];
		if ( ! empty( $sample_class ) ) {
			// Remove leading dots and split by spaces/dots for multiple classes.
			$custom_classes = preg_split( '/[\s.]+/', $sample_class, -1, PREG_SPLIT_NO_EMPTY );
			$sample_classes = array_merge( $sample_classes, $custom_classes );
		}
		$sample_class_string = implode( ' ', $sample_classes );

		$this->set_attribute( '_root', 'class', [ 'atsg-typography-item' ] );
		$this->set_attribute( '_root', 'data-label', esc_attr( $label ) );

		$output = "<div {$this->render_attributes( '_root' )}>";

		// Label.
		if ( $show_label ) {
			$output .= '<div class="atsg-typography-item__label">' . esc_html( $label ) . '</div>';
		}

		// Sample text.
		$output .= '<div class="atsg-typography-item__sample-wrapper">';
		$output .= '<' . esc_attr( $tag ) . ' class="' . esc_attr( $sample_class_string ) . '">';
		$output .= esc_html( $sample_text );
		$output .= '</' . esc_attr( $tag ) . '>';
		$output .= '</div>';

		// Meta information.
		$has_meta = $show_font_family || $show_font_size || $show_line_height || $show_font_weight || $show_letter_spacing || $show_color || $show_text_transform || $show_font_style;

		if ( $has_meta ) {
			$output .= '<div class="atsg-typography-item__meta">';

			if ( $show_font_family ) {
				$output .= '<span class="atsg-typography-item__font-family">';
				if ( $show_value_labels ) {
					$output .= '<span class="atsg-typography-item__meta-label">' . esc_html__( 'Font:', 'advanced-themer-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="font-family"></span>';
				$output .= '</span>';
			}

			if ( $show_font_size ) {
				$output .= '<span class="atsg-typography-item__font-size">';
				if ( $show_value_labels ) {
					$output .= '<span class="atsg-typography-item__meta-label">' . esc_html__( 'Size:', 'advanced-themer-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="font-size"></span>';
				$output .= '</span>';
			}

			if ( $show_line_height ) {
				$output .= '<span class="atsg-typography-item__line-height">';
				if ( $show_value_labels ) {
					$output .= '<span class="atsg-typography-item__meta-label">' . esc_html__( 'Line Height:', 'advanced-themer-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="line-height"></span>';
				$output .= '</span>';
			}

			if ( $show_font_weight ) {
				$output .= '<span class="atsg-typography-item__font-weight">';
				if ( $show_value_labels ) {
					$output .= '<span class="atsg-typography-item__meta-label">' . esc_html__( 'Weight:', 'advanced-themer-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="font-weight"></span>';
				$output .= '</span>';
			}

			if ( $show_letter_spacing ) {
				$output .= '<span class="atsg-typography-item__letter-spacing">';
				if ( $show_value_labels ) {
					$output .= '<span class="atsg-typography-item__meta-label">' . esc_html__( 'Spacing:', 'advanced-themer-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="letter-spacing"></span>';
				$output .= '</span>';
			}

			if ( $show_color ) {
				$output .= '<span class="atsg-typography-item__color">';
				if ( $show_value_labels ) {
					$output .= '<span class="atsg-typography-item__meta-label">' . esc_html__( 'Color:', 'advanced-themer-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="color"></span>';
				$output .= '</span>';
			}

			if ( $show_text_transform ) {
				$output .= '<span class="atsg-typography-item__text-transform">';
				if ( $show_value_labels ) {
					$output .= '<span class="atsg-typography-item__meta-label">' . esc_html__( 'Transform:', 'advanced-themer-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="text-transform"></span>';
				$output .= '</span>';
			}

			if ( $show_font_style ) {
				$output .= '<span class="atsg-typography-item__font-style">';
				if ( $show_value_labels ) {
					$output .= '<span class="atsg-typography-item__meta-label">' . esc_html__( 'Style:', 'advanced-themer-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="font-style"></span>';
				$output .= '</span>';
			}

			$output .= '</div>';
		}

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
			'at-typography-item',
			false,
			[],
			AT_STYLE_GUIDE_VERSION
		);
		wp_add_inline_style( 'at-typography-item', $this->get_element_css() );
		wp_enqueue_style( 'at-typography-item' );
	}

	/**
	 * Get inline CSS for the element.
	 *
	 * @return string
	 */
	private function get_element_css(): string {
		return '
			.atsg-typography-item {
				display: flex;
				flex-direction: column;
				gap: 0.5em;
				padding: 1.5em;
			}

			.atsg-typography-item__label {
				font-size: 0.75em;
				font-weight: 600;
				text-transform: uppercase;
				letter-spacing: 0.05em;
				color: var(--at-neutral-d-2, #6b7280);
			}

			.atsg-typography-item__sample-wrapper {
				overflow: hidden;
			}

			.atsg-typography-item__sample {
				margin: 0;
				font-size: revert;
			}

			.atsg-typography-item__meta {
				display: flex;
				flex-wrap: wrap;
				gap: 1em;
				font-size: 0.75em;
				color: var(--at-neutral-d-2, #6b7280);
			}

			.atsg-typography-item__meta > span {
				background: var(--at-neutral-t-6, #f3f4f6);
				padding: 0.25em 0.5em;
				border-radius: 0.25em;
			}

			.atsg-typography-item__meta-label {
				font-weight: 600;
				color: var(--at-neutral-d-3, #374151);
			}
		';
	}
}
