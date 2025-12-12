<?php
/**
 * Typography Element (Nestable) for Bricks Builder.
 *
 * Container element for typography samples with computed font sizes and families.
 *
 * @package AB\ATStyleGuide
 */

namespace AB\ATStyleGuide\Elements;

use AB\ATStyleGuide\ATFrameworkDefaults;

defined( 'ABSPATH' ) || exit;

/**
 * Typography Element (Nestable).
 */
class Typography extends \Bricks\Element {

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
	public $name = 'at-typography';

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
	public $scripts = [ 'atTypographyInit' ];

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
		return esc_html__( 'Typography', 'advanced-themer-style-guide' ) . ' (' . esc_html__( 'Nestable', 'advanced-themer-style-guide' ) . ')';
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
			'title' => esc_html__( 'Layout', 'advanced-themer-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['displayOverride'] = [
			'title' => esc_html__( 'Display Override', 'advanced-themer-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['style'] = [
			'title' => esc_html__( 'Item Styling', 'advanced-themer-style-guide' ),
			'tab'   => 'content',
		];
	}

	/**
	 * Set controls.
	 *
	 * @return void
	 */
	public function set_controls(): void {
		// Base font size control.
		$this->controls['baseFontSize'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Base Font Size', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'default'     => 'var(--at-text--s)',
			'css'         => [
				[
					'property' => 'font-size',
					'selector' => '',
				],
			],
			'description' => esc_html__( 'Base font size for UI components. Sample text uses its own styled size.', 'advanced-themer-style-guide' ),
		];

		// Layout controls.
		$this->controls['layout'] = [
			'group'   => 'layout',
			'label'   => esc_html__( 'Layout', 'advanced-themer-style-guide' ),
			'type'    => 'select',
			'options' => [
				'stacked' => esc_html__( 'Stacked', 'advanced-themer-style-guide' ),
				'table'   => esc_html__( 'Table', 'advanced-themer-style-guide' ),
			],
			'default' => 'stacked',
			'inline'  => true,
		];

		$this->controls['gap'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Gap', 'advanced-themer-style-guide' ),
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

		// Display Override controls - apply to all child items.
		$this->controls['overrideChildDisplay'] = [
			'group'       => 'displayOverride',
			'label'       => esc_html__( 'Override Child Display Settings', 'advanced-themer-style-guide' ),
			'type'        => 'checkbox',
			'rerender'    => true,
			'description' => esc_html__( 'Enable to control display settings for all child items from here.', 'advanced-themer-style-guide' ),
		];

		$this->controls['hideLabel'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Label', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideFontFamily'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Font Family', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideFontSize'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Font Size', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideLineHeight'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Line Height', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideFontWeight'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Font Weight', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideLetterSpacing'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Letter Spacing', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideColor'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Color', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideTextTransform'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Text Transform', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideFontStyle'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Font Style', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideValueLabels'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Value Labels', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		// Style preset.
		$this->controls['stylePreset'] = [
			'group'   => 'style',
			'label'   => esc_html__( 'Style Preset', 'advanced-themer-style-guide' ),
			'type'    => 'select',
			'options' => [
				'default'   => esc_html__( 'Default', 'advanced-themer-style-guide' ),
				'minimal'   => esc_html__( 'Minimal', 'advanced-themer-style-guide' ),
				'bold'      => esc_html__( 'Bold', 'advanced-themer-style-guide' ),
				'colourful' => esc_html__( 'Colourful', 'advanced-themer-style-guide' ),
				'compact'   => esc_html__( 'Compact', 'advanced-themer-style-guide' ),
			],
			'default' => 'default',
			'inline'  => true,
		];

		// Item border.
		$this->controls['itemBorder'] = [
			'group' => 'style',
			'label' => esc_html__( 'Item Border', 'advanced-themer-style-guide' ),
			'type'  => 'border',
			'css'   => [
				[
					'property' => 'border-bottom',
					'selector' => '.atsg-typography-item',
				],
			],
		];

		// Item padding.
		$this->controls['itemPadding'] = [
			'group' => 'style',
			'label' => esc_html__( 'Item Padding', 'advanced-themer-style-guide' ),
			'type'  => 'spacing',
			'css'   => [
				[
					'property' => 'padding',
					'selector' => '.atsg-typography-item',
				],
			],
		];

		// Label typography.
		$this->controls['labelTypography'] = [
			'group' => 'style',
			'label' => esc_html__( 'Label Typography', 'advanced-themer-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.atsg-typography-item__label',
				],
			],
		];

		// Meta typography.
		$this->controls['metaTypography'] = [
			'group' => 'style',
			'label' => esc_html__( 'Meta Typography', 'advanced-themer-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.atsg-typography-item__meta',
				],
			],
		];

		// Meta background.
		$this->controls['metaBackground'] = [
			'group' => 'style',
			'label' => esc_html__( 'Meta Background', 'advanced-themer-style-guide' ),
			'type'  => 'color',
			'css'   => [
				[
					'property' => 'background-color',
					'selector' => '.atsg-typography-item__meta > span',
				],
			],
		];

		// Item background.
		$this->controls['itemBackground'] = [
			'group' => 'style',
			'label' => esc_html__( 'Item Background', 'advanced-themer-style-guide' ),
			'type'  => 'color',
			'css'   => [
				[
					'property' => 'background-color',
					'selector' => '.atsg-typography-item',
				],
			],
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
			'name'     => 'at-typography-item',
			'label'    => esc_html__( 'Typography Item', 'advanced-themer-style-guide' ),
			'settings' => [
				'label'       => '{item_label}',
				'tag'         => '{item_tag}',
				'sampleText'  => 'The quick brown fox jumps over the lazy dog',
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
		// Check for ATF variables.
		if ( ! ATFrameworkDefaults::has_at_variables() ) {
			echo ATFrameworkDefaults::render_warning(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}

		$settings = $this->settings;

		$layout       = $settings['layout'] ?? 'stacked';
		$style_preset = $settings['stylePreset'] ?? 'default';

		$root_classes = [ 'atsg-typography', 'atsg-typography--' . $layout ];
		if ( 'default' !== $style_preset ) {
			$root_classes[] = 'atsg-typography--' . $style_preset;
		}

		$this->set_attribute( '_root', 'class', $root_classes );

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
		wp_register_style(
			'at-typography',
			false,
			[],
			AT_STYLE_GUIDE_VERSION
		);
		wp_add_inline_style( 'at-typography', $this->get_element_css() );
		wp_enqueue_style( 'at-typography' );
	}

	/**
	 * Get inline CSS for the element.
	 *
	 * @return string
	 */
	private function get_element_css(): string {
		return '
			.atsg-typography {
				display: flex;
				flex-direction: column;
				gap: 2em;
			}

			.atsg-typography__placeholder {
				padding: 2em;
				background: var(--at-neutral-t-6, #f3f4f6);
				border: 2px dashed var(--at-border-color, #d1d5db);
				border-radius: 0.5em;
				text-align: center;
				color: var(--at-neutral-d-2, #6b7280);
			}

			/* Table layout */
			.atsg-typography--table {
				display: table;
				width: 100%;
				border-collapse: collapse;
			}

			.atsg-typography--table .atsg-typography-item {
				display: table-row;
				padding: 0;
				border-block-end: none;
			}

			.atsg-typography--table .atsg-typography-item__label,
			.atsg-typography--table .atsg-typography-item__sample-wrapper,
			.atsg-typography--table .atsg-typography-item__meta {
				display: table-cell;
				padding: 1em;
				vertical-align: middle;
				border-block-end: 1px solid var(--at-border-color, #e5e7eb);
			}

			.atsg-typography--table .atsg-typography-item__label {
				width: 6.25em;
			}

			.atsg-typography--table .atsg-typography-item__meta {
				width: 12.5em;
				flex-direction: column;
				align-items: flex-start;
				gap: 0.25em;
				text-align: left;
			}

			.atsg-typography--table .atsg-typography-item__meta > span {
				display: block;
				width: auto;
			}

			/* Table layout - mobile: revert to stacked */
			@media screen and (max-width: 768px) {
				.atsg-typography--table {
					display: flex !important;
					flex-direction: column;
					gap: 2em;
				}

				.atsg-typography--table .atsg-typography-item {
					display: flex !important;
					flex-direction: column;
					gap: 0.5em;
					padding: 0;
					padding-block-end: 1.5em;
					border-block-end: 1px solid var(--at-border-color, #e5e7eb);
				}

				.atsg-typography--table .atsg-typography-item__label,
				.atsg-typography--table .atsg-typography-item__sample-wrapper,
				.atsg-typography--table .atsg-typography-item__meta {
					display: block !important;
					padding: 0;
					width: auto !important;
					border-block-end: none;
				}

				.atsg-typography--table .atsg-typography-item__meta {
					display: flex !important;
					flex-wrap: wrap;
				}
			}

			/* Style: Minimal */
			.atsg-typography--minimal .atsg-typography-item {
				border-block-end: none;
				padding-block-end: 0.75em;
			}

			.atsg-typography--minimal .atsg-typography-item__label {
				display: none;
			}

			.atsg-typography--minimal .atsg-typography-item__meta {
				opacity: 0.7;
			}

			/* Style: Bold */
			.atsg-typography--bold .atsg-typography-item__label {
				font-size: 0.875em;
				font-weight: 700;
				text-transform: none;
				color: var(--at-neutral-d-4, #1f2937);
			}

			.atsg-typography--bold .atsg-typography-item {
				border-block-end-width: 2px;
			}

			/* Style: Colourful */
			.atsg-typography--colourful .atsg-typography-item__label {
				color: var(--at-primary, #3b82f6);
			}

			.atsg-typography--colourful .atsg-typography-item {
				border-block-end-color: var(--at-primary-l-3, #93c5fd);
			}

			.atsg-typography--colourful .atsg-typography-item__meta > span {
				background: var(--at-primary-l-5, #dbeafe);
				color: var(--at-primary-d-2, #1d4ed8);
			}

			/* Style: Compact */
			.atsg-typography--compact {
				gap: 0.5em;
			}

			.atsg-typography--compact .atsg-typography-item {
				gap: 0.25em;
				padding-block-end: 0.5em;
			}

			.atsg-typography--compact .atsg-typography-item__label {
				font-size: 0.75em;
			}

			.atsg-typography--compact .atsg-typography-item__meta {
				gap: 0.5em;
				font-size: 0.75em;
			}

			/* Parent override styles - hide elements based on parent data attributes */
			.atsg-typography[data-override="true"][data-hide-label="true"] .atsg-typography-item__label {
				display: none;
			}

			.atsg-typography[data-override="true"][data-hide-font-family="true"] .atsg-typography-item__font-family {
				display: none;
			}

			.atsg-typography[data-override="true"][data-hide-font-size="true"] .atsg-typography-item__font-size {
				display: none;
			}

			.atsg-typography[data-override="true"][data-hide-line-height="true"] .atsg-typography-item__line-height {
				display: none;
			}

			.atsg-typography[data-override="true"][data-hide-font-weight="true"] .atsg-typography-item__font-weight {
				display: none;
			}

			.atsg-typography[data-override="true"][data-hide-letter-spacing="true"] .atsg-typography-item__letter-spacing {
				display: none;
			}

			.atsg-typography[data-override="true"][data-hide-color="true"] .atsg-typography-item__color {
				display: none;
			}

			.atsg-typography[data-override="true"][data-hide-text-transform="true"] .atsg-typography-item__text-transform {
				display: none;
			}

			.atsg-typography[data-override="true"][data-hide-font-style="true"] .atsg-typography-item__font-style {
				display: none;
			}

			.atsg-typography[data-override="true"][data-hide-value-labels="true"] .atsg-typography-item__meta-label {
				display: none;
			}
		';
	}
}
