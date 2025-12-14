<?php
/**
 * Typography Item Element for Bricks Builder.
 *
 * Individual typography sample row for use within Typography (Nestable) element.
 *
 * @package AB\BricksSG
 */

namespace AB\BricksSG\Elements;

use AB\BricksSG\Framework\FrameworkDetector;
use AB\BricksSG\Framework\FrameworkVariables;

defined( 'ABSPATH' ) || exit;

/**
 * Typography Item Element.
 */
class TypographyItem extends \Bricks\Element {

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
	public $name = 'bsg-typography-item';

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
	public $scripts = [ 'bsgTypographyItemInit' ];

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Typography Item', 'bricks-style-guide' );
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
			'title' => esc_html__( 'Content', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['display'] = [
			'title' => esc_html__( 'Display', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['style'] = [
			'title' => esc_html__( 'Item Style', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['typography'] = [
			'title' => esc_html__( 'Sample Typography', 'bricks-style-guide' ),
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
			'default'     => 'Heading 1',
			'placeholder' => esc_html__( 'e.g. Heading 1, Body, Lead...', 'bricks-style-guide' ),
		];

		$this->controls['tag'] = [
			'group'   => 'content',
			'label'   => esc_html__( 'HTML Tag', 'bricks-style-guide' ),
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
			'label'       => esc_html__( 'Sample Text', 'bricks-style-guide' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'Inherits from parent...', 'bricks-style-guide' ),
			'description' => esc_html__( 'Leave empty to use the default from the parent Typography element.', 'bricks-style-guide' ),
		];

		// Display controls - all "Hide X" for consistency.
		// Unchecked = show (default), Checked = hide.
		$this->controls['hideLabel'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Label', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideFontFamily'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Font Family', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideFontSize'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Font Size', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideLineHeight'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Line Height', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideFontWeight'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Font Weight', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideLetterSpacing'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Letter Spacing', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideColor'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Color', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideTextTransform'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Text Transform', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideFontStyle'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Font Style', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		$this->controls['hideValueLabels'] = [
			'group'    => 'display',
			'label'    => esc_html__( 'Hide Value Labels', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
		];

		// Item style controls.
		$this->controls['itemBackground'] = [
			'group' => 'style',
			'label' => esc_html__( 'Background', 'bricks-style-guide' ),
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
			'label'       => esc_html__( 'Class', 'bricks-style-guide' ),
			'type'        => 'text',
			'placeholder' => esc_html__( 'e.g. .text--xs', 'bricks-style-guide' ),
			'description' => esc_html__( 'You need to define these classes in your CSS.', 'bricks-style-guide' ),
		];

		$this->controls['sampleTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Sample Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-typography-item__sample',
				],
			],
		];

		$this->controls['labelTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Label Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-typography-item__label',
				],
			],
		];

		$this->controls['metaTypography'] = [
			'group' => 'typography',
			'label' => esc_html__( 'Meta Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-typography-item__meta',
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
		$sample_class = $settings['sampleClass'] ?? '';

		// Sample text: use item's value if set, otherwise will be replaced by JS from parent.
		// If standalone (no parent), fallback to default.
		$sample_text     = $settings['sampleText'] ?? '';
		$has_custom_text = ! empty( $sample_text );

		// Fallback text for standalone items or initial render.
		$fallback_text = 'The quick brown fox jumps over the lazy dog';
		$display_text  = $has_custom_text ? $sample_text : $fallback_text;

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
		$sample_classes = [ 'bsg-typography-item__sample' ];
		if ( ! empty( $sample_class ) ) {
			// Remove leading dots and split by spaces/dots for multiple classes.
			$custom_classes = preg_split( '/[\s.]+/', $sample_class, -1, PREG_SPLIT_NO_EMPTY );
			$sample_classes = array_merge( $sample_classes, $custom_classes );
		}
		$sample_class_string = implode( ' ', $sample_classes );

		$this->set_attribute( '_root', 'class', [ 'bsg-typography-item' ] );
		$this->set_attribute( '_root', 'data-label', esc_attr( $label ) );

		// Mark whether this item has custom sample text or should inherit from parent.
		if ( ! $has_custom_text ) {
			$this->set_attribute( '_root', 'data-inherit-sample', 'true' );
		}

		$output = "<div {$this->render_attributes( '_root' )}>";

		// Label.
		if ( $show_label ) {
			$output .= '<div class="bsg-typography-item__label">' . esc_html( $label ) . '</div>';
		}

		// Sample text.
		$output .= '<div class="bsg-typography-item__sample-wrapper">';
		$output .= '<' . esc_attr( $tag ) . ' class="' . esc_attr( $sample_class_string ) . '">';
		$output .= esc_html( $display_text );
		$output .= '</' . esc_attr( $tag ) . '>';
		$output .= '</div>';

		// Meta information.
		$has_meta = $show_font_family || $show_font_size || $show_line_height || $show_font_weight || $show_letter_spacing || $show_color || $show_text_transform || $show_font_style;

		if ( $has_meta ) {
			$output .= '<div class="bsg-typography-item__meta">';

			if ( $show_font_family ) {
				$output .= '<span class="bsg-typography-item__font-family">';
				if ( $show_value_labels ) {
					$output .= '<span class="bsg-typography-item__meta-label">' . esc_html__( 'Font:', 'bricks-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="font-family"></span>';
				$output .= '</span>';
			}

			if ( $show_font_size ) {
				$output .= '<span class="bsg-typography-item__font-size">';
				if ( $show_value_labels ) {
					$output .= '<span class="bsg-typography-item__meta-label">' . esc_html__( 'Size:', 'bricks-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="font-size"></span>';
				$output .= '</span>';
			}

			if ( $show_line_height ) {
				$output .= '<span class="bsg-typography-item__line-height">';
				if ( $show_value_labels ) {
					$output .= '<span class="bsg-typography-item__meta-label">' . esc_html__( 'Line Height:', 'bricks-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="line-height"></span>';
				$output .= '</span>';
			}

			if ( $show_font_weight ) {
				$output .= '<span class="bsg-typography-item__font-weight">';
				if ( $show_value_labels ) {
					$output .= '<span class="bsg-typography-item__meta-label">' . esc_html__( 'Weight:', 'bricks-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="font-weight"></span>';
				$output .= '</span>';
			}

			if ( $show_letter_spacing ) {
				$output .= '<span class="bsg-typography-item__letter-spacing">';
				if ( $show_value_labels ) {
					$output .= '<span class="bsg-typography-item__meta-label">' . esc_html__( 'Spacing:', 'bricks-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="letter-spacing"></span>';
				$output .= '</span>';
			}

			if ( $show_color ) {
				$output .= '<span class="bsg-typography-item__color">';
				if ( $show_value_labels ) {
					$output .= '<span class="bsg-typography-item__meta-label">' . esc_html__( 'Color:', 'bricks-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="color"></span>';
				$output .= '</span>';
			}

			if ( $show_text_transform ) {
				$output .= '<span class="bsg-typography-item__text-transform">';
				if ( $show_value_labels ) {
					$output .= '<span class="bsg-typography-item__meta-label">' . esc_html__( 'Transform:', 'bricks-style-guide' ) . '</span> ';
				}
				$output .= '<span data-computed="text-transform"></span>';
				$output .= '</span>';
			}

			if ( $show_font_style ) {
				$output .= '<span class="bsg-typography-item__font-style">';
				if ( $show_value_labels ) {
					$output .= '<span class="bsg-typography-item__meta-label">' . esc_html__( 'Style:', 'bricks-style-guide' ) . '</span> ';
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
		$handle = 'bsg-typography-item';

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
			.bsg-typography-item {
				' . $framework_vars . '
				display: flex;
				flex-direction: column;
				gap: 0.5em;
				padding: 1.5em;
			}

			.bsg-typography-item__meta {
				display: flex;
				flex-wrap: wrap;
				gap: 1em;
			}

			@layer bsg {
			/* === Settings === */
			.bsg-typography-item {
				--_label-color: var(--bsg-typography-item-label-color, var(--bsg-neutral-medium, #6b7280));
				--_label-font-size: var(--bsg-typography-item-label-font-size, 0.75em);
				--_label-font-weight: var(--bsg-typography-item-label-font-weight, 600);
				--_label-text-transform: var(--bsg-typography-item-label-text-transform, uppercase);
				--_label-letter-spacing: var(--bsg-typography-item-label-letter-spacing, 0.05em);
				--_meta-font-size: var(--bsg-typography-item-meta-font-size, 0.75em);
				--_meta-color: var(--bsg-typography-item-meta-color, var(--bsg-neutral-medium, #6b7280));
				--_meta-bg: var(--bsg-typography-item-meta-bg, var(--bsg-neutral-light, #f3f4f6));
				--_meta-text-color: var(--bsg-typography-item-meta-text-color, inherit);
				--_meta-label-color: var(--bsg-typography-item-meta-label-color, var(--bsg-neutral-darker, #374151));
			}

			.bsg-typography-item__label {
				font-size: var(--_label-font-size);
				font-weight: var(--_label-font-weight);
				text-transform: var(--_label-text-transform);
				letter-spacing: var(--_label-letter-spacing);
				color: var(--_label-color);
			}

			.bsg-typography-item__sample-wrapper {
				overflow: hidden;
			}

			.bsg-typography-item__sample {
				margin: 0;
				font-size: revert;
			}

			.bsg-typography-item__meta {
				font-size: var(--_meta-font-size);
				line-height: 1;
				color: var(--_meta-color);
			}

			.bsg-typography-item__meta > span {
				background: var(--_meta-bg);
				color: var(--_meta-text-color);
				padding: 0.25em 0.5em;
				border-radius: 0.25em;
			}

			.bsg-typography-item__meta-label {
				font-weight: 600;
				color: var(--_meta-label-color);
			}
			} /* end @layer bsg */
		';
	}
}
