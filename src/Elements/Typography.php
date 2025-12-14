<?php
/**
 * Typography Element (Nestable) for Bricks Builder.
 *
 * Container element for typography samples with computed font sizes and families.
 *
 * @package AB\BricksSG
 */

namespace AB\BricksSG\Elements;

use AB\BricksSG\ATFrameworkDefaults;
use AB\BricksSG\Framework\FrameworkDetector;
use AB\BricksSG\Framework\FrameworkVariables;

defined( 'ABSPATH' ) || exit;

/**
 * Typography Element (Nestable).
 */
class Typography extends \Bricks\Element {

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
	public $name = 'bsg-typography';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-text';

	/**
	 * Element scripts.
	 *
	 * @var array
	 */
	public $scripts = [ 'bsgTypographyInit' ];

	/**
	 * Nestable element.
	 *
	 * @var bool
	 */
	public $nestable = true;

	/**
	 * Get element label.
	 *
	 * @return string
	 */
	public function get_label(): string {
		return esc_html__( 'Typography', 'bricks-style-guide' ) . ' (' . esc_html__( 'Nestable', 'bricks-style-guide' ) . ')';
	}

	/**
	 * Get element keywords.
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'typography', 'fonts', 'headings', 'text', 'style guide', 'nestable' ];
	}

	/**
	 * Set control groups.
	 *
	 * @return void
	 */
	public function set_control_groups(): void {
		$this->control_groups['layout'] = [
			'title' => esc_html__( 'Layout', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['displayOverride'] = [
			'title' => esc_html__( 'Display Override', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['style'] = [
			'title' => esc_html__( 'Item Styling', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['typographyOverride'] = [
			'title' => esc_html__( 'Typography Override', 'bricks-style-guide' ),
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

		// Base font size control.
		$this->controls['baseFontSize'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Base Font Size', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'default'     => $examples['text_s'],
			'css'         => [
				[
					'property' => 'font-size',
					'selector' => '',
				],
			],
			'description' => esc_html__( 'Base font size for UI components. Sample text uses its own styled size.', 'bricks-style-guide' ),
		];

		// Layout controls.
		$this->controls['layout'] = [
			'group'   => 'layout',
			'label'   => esc_html__( 'Layout', 'bricks-style-guide' ),
			'type'    => 'select',
			'options' => [
				'stacked' => esc_html__( 'Stacked', 'bricks-style-guide' ),
				'table'   => esc_html__( 'Table', 'bricks-style-guide' ),
			],
			'default' => 'stacked',
			'inline'  => true,
		];

		$this->controls['gap'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Gap', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => '2em',
			'css'         => [
				[
					'property' => 'gap',
					'selector' => '',
				],
			],
		];

		$this->controls['flexDirection'] = [
			'group'   => 'layout',
			'label'   => esc_html__( 'Direction', 'bricks-style-guide' ),
			'type'    => 'direction',
			'css'     => [
				[
					'property' => 'flex-direction',
					'selector' => '',
				],
			],
		];

		$this->controls['flexWrap'] = [
			'group'   => 'layout',
			'label'   => esc_html__( 'Wrap', 'bricks-style-guide' ),
			'type'    => 'select',
			'options' => [
				'nowrap'       => esc_html__( 'No Wrap', 'bricks-style-guide' ),
				'wrap'         => esc_html__( 'Wrap', 'bricks-style-guide' ),
				'wrap-reverse' => esc_html__( 'Wrap Reverse', 'bricks-style-guide' ),
			],
			'inline'  => true,
			'css'     => [
				[
					'property' => 'flex-wrap',
					'selector' => '',
				],
			],
		];

		$this->controls['alignItems'] = [
			'group'   => 'layout',
			'label'   => esc_html__( 'Align Items', 'bricks-style-guide' ),
			'type'    => 'align-items',
			'css'     => [
				[
					'property' => 'align-items',
					'selector' => '',
				],
			],
		];

		$this->controls['justifyContent'] = [
			'group'   => 'layout',
			'label'   => esc_html__( 'Justify Content', 'bricks-style-guide' ),
			'type'    => 'justify-content',
			'css'     => [
				[
					'property' => 'justify-content',
					'selector' => '',
				],
			],
		];

		$this->controls['sampleText'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Sample Text', 'bricks-style-guide' ),
			'type'        => 'text',
			'default'     => 'The quick brown fox jumps over the lazy dog',
			'description' => esc_html__( 'Sets the default sample text for all Typography Items. Individual items can override this.', 'bricks-style-guide' ),
		];

		// Display Override controls - apply to all child items.
		$this->controls['overrideChildDisplay'] = [
			'group'       => 'displayOverride',
			'label'       => esc_html__( 'Override Child Display Settings', 'bricks-style-guide' ),
			'type'        => 'checkbox',
			'rerender'    => true,
			'description' => esc_html__( 'Enable to control display settings for all child items from here.', 'bricks-style-guide' ),
		];

		$this->controls['hideLabel'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Label', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideFontFamily'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Font Family', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideFontSize'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Font Size', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideLineHeight'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Line Height', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideFontWeight'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Font Weight', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideLetterSpacing'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Letter Spacing', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideColor'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Color', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideTextTransform'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Text Transform', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideFontStyle'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Font Style', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideValueLabels'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Value Labels', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		// Style preset.
		$this->controls['stylePreset'] = [
			'group'   => 'style',
			'label'   => esc_html__( 'Style Preset', 'bricks-style-guide' ),
			'type'    => 'select',
			'options' => [
				'default'   => esc_html__( 'Default', 'bricks-style-guide' ),
				'minimal'   => esc_html__( 'Minimal', 'bricks-style-guide' ),
				'bold'      => esc_html__( 'Bold', 'bricks-style-guide' ),
				'colourful' => esc_html__( 'Colourful', 'bricks-style-guide' ),
				'compact'   => esc_html__( 'Compact', 'bricks-style-guide' ),
			],
			'default' => 'default',
			'inline'  => true,
		];

		// Item border.
		$this->controls['itemBorder'] = [
			'group' => 'style',
			'label' => esc_html__( 'Item Border', 'bricks-style-guide' ),
			'type'  => 'border',
			'css'   => [
				[
					'property' => 'border-bottom',
					'selector' => '.bsg-typography-item',
				],
			],
		];

		// Item padding.
		$this->controls['itemPadding'] = [
			'group' => 'style',
			'label' => esc_html__( 'Item Padding', 'bricks-style-guide' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.bsg-typography-item',
				],
			],
		];

		// Label typography.
		$this->controls['labelTypography'] = [
			'group' => 'style',
			'label' => esc_html__( 'Label Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-typography-item__label',
				],
			],
		];

		// Meta typography.
		$this->controls['metaTypography'] = [
			'group' => 'style',
			'label' => esc_html__( 'Meta Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-typography-item__meta',
				],
			],
		];

		// Meta background.
		$this->controls['metaBackground'] = [
			'group' => 'style',
			'label' => esc_html__( 'Meta Background', 'bricks-style-guide' ),
			'type'  => 'color',
			'css'   => [
				[
					'property' => 'background-color',
					'selector' => '.bsg-typography-item__meta > span',
				],
			],
		];

		// Item background.
		$this->controls['itemBackground'] = [
			'group' => 'style',
			'label' => esc_html__( 'Item Background', 'bricks-style-guide' ),
			'type'  => 'color',
			'css'   => [
				[
					'property' => 'background-color',
					'selector' => '.bsg-typography-item',
				],
			],
		];

		// Typography Override controls.
		$this->controls['overrideChildTypography'] = [
			'group'       => 'typographyOverride',
			'label'       => esc_html__( 'Override Child Typography Settings', 'bricks-style-guide' ),
			'type'        => 'checkbox',
			'description' => esc_html__( 'Enable to control typography settings for all child items from here.', 'bricks-style-guide' ),
		];

		$this->controls['overrideLabelTypography'] = [
			'group'    => 'typographyOverride',
			'label'    => esc_html__( 'Label Typography', 'bricks-style-guide' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.bsg-typography-item__label',
				],
			],
			'required' => [ 'overrideChildTypography', '!=', '' ],
		];

		$this->controls['overrideMetaTypography'] = [
			'group'    => 'typographyOverride',
			'label'    => esc_html__( 'Meta Typography', 'bricks-style-guide' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.bsg-typography-item__meta',
				],
			],
			'required' => [ 'overrideChildTypography', '!=', '' ],
		];

		$this->controls['overrideMetaLabelTypography'] = [
			'group'    => 'typographyOverride',
			'label'    => esc_html__( 'Meta Label Typography', 'bricks-style-guide' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.bsg-typography-item__meta-label',
				],
			],
			'required' => [ 'overrideChildTypography', '!=', '' ],
		];
	}

	/**
	 * Get nestable item structure.
	 *
	 * Defines the default structure for a single typography item.
	 *
	 * @return array
	 */
	public function get_nestable_item(): array {
		return [
			'name'     => 'bsg-typography-item',
			'label'    => esc_html__( 'Typography Item', 'bricks-style-guide' ),
			'settings' => [
				'label'       => '{item_label}',
				'tag'         => '{item_tag}',
				'sampleClass' => '{item_class}',
			],
		];
	}

	/**
	 * Get nestable children.
	 *
	 * Generates the default set of typography items (H1-H6, Body, Small).
	 *
	 * @return array
	 */
	public function get_nestable_children(): array {
		$default_items = [
			[ 'label' => 'Heading 1', 'tag' => 'h1', 'class' => '' ],
			[ 'label' => 'Heading 2', 'tag' => 'h2', 'class' => '' ],
			[ 'label' => 'Heading 3', 'tag' => 'h3', 'class' => '' ],
			[ 'label' => 'Heading 4', 'tag' => 'h4', 'class' => '' ],
			[ 'label' => 'Heading 5', 'tag' => 'h5', 'class' => '' ],
			[ 'label' => 'Heading 6', 'tag' => 'h6', 'class' => '' ],
			[ 'label' => 'Body', 'tag' => 'p', 'class' => '' ],
			[ 'label' => 'Small', 'tag' => 'span', 'class' => 'text--xs' ],
		];

		$children = [];

		foreach ( $default_items as $item ) {
			$child = $this->get_nestable_item();

			// Replace placeholders.
			$child       = wp_json_encode( $child );
			$child       = str_replace( '{item_label}', $item['label'], $child );
			$child       = str_replace( '{item_tag}', $item['tag'], $child );
			$child       = str_replace( '{item_class}', $item['class'], $child );
			$child       = json_decode( $child, true );
			$children[]  = $child;
		}

		return $children;
	}

	/**
	 * Render element.
	 *
	 * @return void
	 */
	public function render(): void {
		// Check for framework variables (AT or ACSS).
		if ( ! ATFrameworkDefaults::has_framework_variables() ) {
			echo ATFrameworkDefaults::render_warning(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}

		$settings = $this->settings;

		$layout       = $settings['layout'] ?? 'stacked';
		$style_preset = $settings['stylePreset'] ?? 'default';

		$root_classes = [ 'bsg-typography', 'bsg-typography--' . $layout ];
		if ( 'default' !== $style_preset ) {
			$root_classes[] = 'bsg-typography--' . $style_preset;
		}

		$this->set_attribute( '_root', 'class', $root_classes );

		// Pass default sample text as data attribute for child elements to read.
		$sample_text = $settings['sampleText'] ?? 'The quick brown fox jumps over the lazy dog';
		$this->set_attribute( '_root', 'data-sample-text', esc_attr( $sample_text ) );

		// Pass override settings as data attributes for child elements to read.
		if ( isset( $settings['overrideChildDisplay'] ) ) {
			$this->set_attribute( '_root', 'data-override', 'true' );

			$override_settings = [
				'hideLabel',
				'hideFontFamily',
				'hideFontSize',
				'hideLineHeight',
				'hideFontWeight',
				'hideLetterSpacing',
				'hideColor',
				'hideTextTransform',
				'hideFontStyle',
				'hideValueLabels',
			];

			foreach ( $override_settings as $setting_key ) {
				if ( isset( $settings[ $setting_key ] ) ) {
					// Convert camelCase to kebab-case for data attribute.
					$data_key = strtolower( preg_replace( '/([a-z])([A-Z])/', '$1-$2', $setting_key ) );
					$this->set_attribute( '_root', 'data-' . $data_key, 'true' );
				}
			}
		}

		$output = "<div {$this->render_attributes( '_root' )}>";

		// Render children elements (individual typography items).
		$output .= \Bricks\Frontend::render_children( $this );

		$output .= '</div>';

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Enqueue element styles.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {
		$handle = 'bsg-typography';

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
			.bsg-typography {
				' . $framework_vars . '
				display: flex;
				flex-direction: column;
				gap: 2em;
			}

			/* Table layout - critical display rules (outside @layer for higher specificity) */
			.bsg-typography--table {
				display: table !important;
				width: 100%;
				border-collapse: collapse;
			}

			.bsg-typography--table .bsg-typography-item {
				display: table-row !important;
				padding: 0;
				border-block-end: none;
			}

			.bsg-typography--table .bsg-typography-item__label,
			.bsg-typography--table .bsg-typography-item__sample-wrapper,
			.bsg-typography--table .bsg-typography-item__meta {
				display: table-cell !important;
				padding: 1em;
				vertical-align: middle;
				border-block-end: 1px solid var(--bsg-border-color, #e5e7eb);
			}

			.bsg-typography--table .bsg-typography-item__label {
				width: 6.25em;
			}

			.bsg-typography--table .bsg-typography-item__meta {
				width: 12.5em;
				flex-direction: column;
				align-items: flex-start;
				gap: 0.25em;
				text-align: left;
			}

			.bsg-typography--table .bsg-typography-item__meta > span {
				display: block;
				width: auto;
			}

			/* Table layout - mobile: revert to stacked */
			@media screen and (max-width: 768px) {
				.bsg-typography--table {
					display: flex !important;
					flex-direction: column;
					gap: 2em;
				}

				.bsg-typography--table .bsg-typography-item {
					display: flex !important;
					flex-direction: column;
					gap: 0.5em;
					padding: 0;
					padding-block-end: 1.5em;
					border-block-end: 1px solid var(--bsg-border-color, #e5e7eb);
				}

				.bsg-typography--table .bsg-typography-item__label,
				.bsg-typography--table .bsg-typography-item__sample-wrapper,
				.bsg-typography--table .bsg-typography-item__meta {
					display: block !important;
					padding: 0;
					width: auto !important;
					border-block-end: none;
				}

				.bsg-typography--table .bsg-typography-item__meta {
					display: flex !important;
					flex-wrap: wrap;
				}
			}

			@layer bsg {
			/* === Settings === */
			.bsg-typography {
				--_placeholder-padding: var(--bsg-typography-placeholder-padding, 2em);
				--_placeholder-bg: var(--bsg-typography-placeholder-bg, var(--bsg-neutral-light, #f3f4f6));
				--_placeholder-border-color: var(--bsg-typography-placeholder-border-color, var(--bsg-border-color, #d1d5db));
				--_placeholder-color: var(--bsg-typography-placeholder-color, var(--bsg-neutral-medium, #6b7280));
			}

			.bsg-typography__placeholder {
				padding: var(--_placeholder-padding);
				background: var(--_placeholder-bg);
				border: 2px dashed var(--_placeholder-border-color);
				border-radius: 0.5em;
				text-align: center;
				color: var(--_placeholder-color);
			}

			/* Style: Minimal */
			.bsg-typography--minimal .bsg-typography-item {
				border-block-end: none;
				padding-block-end: 0.75em;
			}

			.bsg-typography--minimal .bsg-typography-item__label {
				display: none;
			}

			.bsg-typography--minimal .bsg-typography-item__meta {
				opacity: 0.7;
			}

			/* Style: Bold - override item settings */
			.bsg-typography--bold .bsg-typography-item {
				--_label-font-size: 0.875em;
				--_label-font-weight: 700;
				--_label-text-transform: none;
				--_label-color: var(--bsg-neutral-darker, #1f2937);
				border-block-end-width: 2px;
			}

			/* Style: Colourful - override item settings */
			.bsg-typography--colourful .bsg-typography-item {
				--_label-color: var(--bsg-primary, #3b82f6);
				--_meta-bg: var(--bsg-primary-light, #dbeafe);
				--_meta-text-color: var(--bsg-primary-dark, #1d4ed8);
				border-block-end-color: var(--bsg-primary-light, #93c5fd);
			}

			/* Style: Compact */
			.bsg-typography--compact {
				gap: 0.5em;
			}

			.bsg-typography--compact .bsg-typography-item {
				--_label-font-size: 0.75em;
				--_meta-font-size: 0.75em;
				gap: 0.25em;
				padding-block-end: 0.5em;
			}

			.bsg-typography--compact .bsg-typography-item__meta {
				gap: 0.5em;
			}

			} /* end @layer bsg */

			/* Parent override styles - hide elements based on parent data attributes */
			/* Outside @layer with !important to override table-cell display */
			.bsg-typography[data-override="true"][data-hide-label="true"] .bsg-typography-item__label {
				display: none !important;
			}

			.bsg-typography[data-override="true"][data-hide-font-family="true"] .bsg-typography-item__font-family {
				display: none !important;
			}

			.bsg-typography[data-override="true"][data-hide-font-size="true"] .bsg-typography-item__font-size {
				display: none !important;
			}

			.bsg-typography[data-override="true"][data-hide-line-height="true"] .bsg-typography-item__line-height {
				display: none !important;
			}

			.bsg-typography[data-override="true"][data-hide-font-weight="true"] .bsg-typography-item__font-weight {
				display: none !important;
			}

			.bsg-typography[data-override="true"][data-hide-letter-spacing="true"] .bsg-typography-item__letter-spacing {
				display: none !important;
			}

			.bsg-typography[data-override="true"][data-hide-color="true"] .bsg-typography-item__color {
				display: none !important;
			}

			.bsg-typography[data-override="true"][data-hide-text-transform="true"] .bsg-typography-item__text-transform {
				display: none !important;
			}

			.bsg-typography[data-override="true"][data-hide-font-style="true"] .bsg-typography-item__font-style {
				display: none !important;
			}

			.bsg-typography[data-override="true"][data-hide-value-labels="true"] .bsg-typography-item__meta-label {
				display: none !important;
			}
		';
	}
}
