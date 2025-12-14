<?php
/**
 * Spacing Element (Nestable) for Bricks Builder.
 *
 * Container element for spacing samples with computed pixel values.
 *
 * @package AB\BricksSG
 */

namespace AB\BricksSG\Elements;

use AB\BricksSG\ATFrameworkDefaults;
use AB\BricksSG\Framework\FrameworkDetector;
use AB\BricksSG\Framework\FrameworkVariables;

defined( 'ABSPATH' ) || exit;

/**
 * Spacing Element (Nestable).
 */
class Spacing extends \Bricks\Element {

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
	public $name = 'bsg-spacing';

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
	public $scripts = [ 'bsgSpacingInit' ];

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
		return esc_html__( 'Spacing', 'bricks-style-guide' ) . ' (' . esc_html__( 'Nestable', 'bricks-style-guide' ) . ')';
	}

	/**
	 * Get element keywords.
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'spacing', 'gap', 'margin', 'padding', 'scale', 'style guide', 'nestable' ];
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
		// Layout controls.
		$this->controls['layout'] = [
			'group'    => 'layout',
			'label'    => esc_html__( 'Layout', 'bricks-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'horizontal' => esc_html__( 'Horizontal Bars', 'bricks-style-guide' ),
				'vertical'   => esc_html__( 'Vertical Bars', 'bricks-style-guide' ),
			],
			'default'  => 'horizontal',
			'inline'   => true,
			'rerender' => true,
		];

		// Get framework-specific example variables.
		$examples = FrameworkDetector::get_example_variables();

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
			'description' => esc_html__( 'Base font size for the element. Sub-components use em units relative to this.', 'bricks-style-guide' ),
		];

		$this->controls['gap'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Gap', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => '1em',
			'css'         => [
				[
					'property' => 'gap',
					'selector' => '',
				],
			],
		];

		$this->controls['flexDirection'] = [
			'group' => 'layout',
			'label' => esc_html__( 'Direction', 'bricks-style-guide' ),
			'type'  => 'direction',
			'css'   => [
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
			'group' => 'layout',
			'label' => esc_html__( 'Align Items', 'bricks-style-guide' ),
			'type'  => 'align-items',
			'css'   => [
				[
					'property' => 'align-items',
					'selector' => '',
				],
			],
		];

		$this->controls['justifyContent'] = [
			'group' => 'layout',
			'label' => esc_html__( 'Justify Content', 'bricks-style-guide' ),
			'type'  => 'justify-content',
			'css'   => [
				[
					'property' => 'justify-content',
					'selector' => '',
				],
			],
		];

		// Style preset.
		$this->controls['stylePreset'] = [
			'group'    => 'layout',
			'label'    => esc_html__( 'Style Preset', 'bricks-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'default'   => esc_html__( 'Default', 'bricks-style-guide' ),
				'minimal'   => esc_html__( 'Minimal', 'bricks-style-guide' ),
				'bold'      => esc_html__( 'Bold', 'bricks-style-guide' ),
				'colourful' => esc_html__( 'Colourful', 'bricks-style-guide' ),
				'compact'   => esc_html__( 'Compact', 'bricks-style-guide' ),
			],
			'default'  => 'default',
			'inline'   => true,
			'rerender' => true,
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

		$this->controls['hideVariable'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Variable Name', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideValue'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Computed Value', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideValueLabel'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Value Label', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		// Item styling controls.
		$this->controls['barColor'] = [
			'group' => 'style',
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
			'group'       => 'style',
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
			'description' => esc_html__( 'Thickness of the spacing bars (height in horizontal, width in vertical layout).', 'bricks-style-guide' ),
		];

		$this->controls['labelTypography'] = [
			'group' => 'style',
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
			'group' => 'style',
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
			'group' => 'style',
			'label' => esc_html__( 'Value Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-spacing-item__value',
				],
			],
		];

		$this->controls['infoMinWidth'] = [
			'group'       => 'style',
			'label'       => esc_html__( 'Info Min Width', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => $examples['space_3xl'],
			'css'         => [
				[
					'property' => 'min-width',
					'selector' => '.bsg-spacing-item__info',
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
					'selector' => '.bsg-spacing-item__label',
				],
			],
			'required' => [ 'overrideChildTypography', '!=', '' ],
		];

		$this->controls['overrideVariableTypography'] = [
			'group'    => 'typographyOverride',
			'label'    => esc_html__( 'Variable Typography', 'bricks-style-guide' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.bsg-spacing-item__variable',
				],
			],
			'required' => [ 'overrideChildTypography', '!=', '' ],
		];

		$this->controls['overrideValueTypography'] = [
			'group'    => 'typographyOverride',
			'label'    => esc_html__( 'Value Typography', 'bricks-style-guide' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.bsg-spacing-item__value',
				],
			],
			'required' => [ 'overrideChildTypography', '!=', '' ],
		];

		$this->controls['overrideValueLabelTypography'] = [
			'group'    => 'typographyOverride',
			'label'    => esc_html__( 'Value Label Typography', 'bricks-style-guide' ),
			'type'     => 'typography',
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.bsg-spacing-item__value-label',
				],
			],
			'required' => [ 'overrideChildTypography', '!=', '' ],
		];
	}

	/**
	 * Get nestable item structure.
	 *
	 * @return array
	 */
	public function get_nestable_item(): array {
		return [
			'name'     => 'bsg-spacing-item',
			'label'    => esc_html__( 'Spacing Item', 'bricks-style-guide' ),
			'settings' => [
				'label'    => '{item_label}',
				'variable' => '{item_variable}',
			],
		];
	}

	/**
	 * Get nestable children.
	 *
	 * @return array
	 */
	public function get_nestable_children(): array {
		// Get spacing variables from the active framework.
		$framework = FrameworkDetector::get_active_framework();
		if ( $framework ) {
			$spacing_vars = $framework::get_spacing_variables();
		} else {
			// Fallback to generic items.
			$spacing_vars = [
				[ 'name' => '3xs', 'variable' => '--space-3xs' ],
				[ 'name' => '2xs', 'variable' => '--space-2xs' ],
				[ 'name' => 'xs', 'variable' => '--space-xs' ],
				[ 'name' => 's', 'variable' => '--space-s' ],
				[ 'name' => 'm', 'variable' => '--space-m' ],
				[ 'name' => 'l', 'variable' => '--space-l' ],
				[ 'name' => 'xl', 'variable' => '--space-xl' ],
				[ 'name' => '2xl', 'variable' => '--space-2xl' ],
				[ 'name' => '3xl', 'variable' => '--space-3xl' ],
			];
		}

		$children = [];

		foreach ( $spacing_vars as $item ) {
			$child = $this->get_nestable_item();

			// Replace placeholders.
			$child      = wp_json_encode( $child );
			$child      = str_replace( '{item_label}', strtoupper( $item['name'] ), $child );
			$child      = str_replace( '{item_variable}', $item['variable'], $child );
			$child      = json_decode( $child, true );
			$children[] = $child;
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

		$layout       = $settings['layout'] ?? 'horizontal';
		$style_preset = $settings['stylePreset'] ?? 'default';

		$root_classes = [ 'bsg-spacing', 'bsg-spacing--' . $layout ];
		if ( 'default' !== $style_preset ) {
			$root_classes[] = 'bsg-spacing--' . $style_preset;
		}

		$this->set_attribute( '_root', 'class', $root_classes );

		// Pass override settings as data attributes for child elements to read.
		if ( isset( $settings['overrideChildDisplay'] ) ) {
			$this->set_attribute( '_root', 'data-override', 'true' );

			$override_settings = [
				'hideLabel',
				'hideVariable',
				'hideValue',
				'hideValueLabel',
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

		// Render children elements (individual spacing items).
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
		$handle = 'bsg-spacing';

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
			.bsg-spacing {
				' . $framework_vars . '
				--bsg-bar-thickness: 1.5em;
				display: flex;
				flex-direction: column;
				gap: 1em;
			}

			/* Horizontal layout: bar thickness = height, width = spacing value */
			.bsg-spacing--horizontal .bsg-spacing-item__bar {
				height: var(--bsg-bar-thickness) !important;
			}

			/* Vertical layout */
			.bsg-spacing--vertical {
				flex-direction: row;
				flex-wrap: wrap;
				align-items: flex-end;
				gap: 1.5em;
			}

			.bsg-spacing--vertical .bsg-spacing-item {
				flex-direction: column;
				align-items: center;
			}

			.bsg-spacing--vertical .bsg-spacing-item__info {
				min-width: auto;
				align-items: center;
				order: 2;
			}

			.bsg-spacing--vertical .bsg-spacing-item__bar-container {
				flex-direction: column;
				justify-content: flex-end;
				height: 12em;
				order: 1;
			}

			/* Vertical layout: bar thickness = width, height = spacing value (from inline style) */
			.bsg-spacing--vertical .bsg-spacing-item__bar {
				width: var(--bsg-bar-thickness) !important;
			}

			@layer bsg {
			/* === Settings === */
			.bsg-spacing {
				--_placeholder-padding: var(--bsg-spacing-placeholder-padding, 2em);
				--_placeholder-bg: var(--bsg-spacing-placeholder-bg, var(--bsg-neutral-light, #f3f4f6));
				--_placeholder-border-color: var(--bsg-spacing-placeholder-border-color, var(--bsg-border-color, #d1d5db));
				--_placeholder-color: var(--bsg-spacing-placeholder-color, var(--bsg-neutral-medium, #6b7280));
			}

			.bsg-spacing__placeholder {
				padding: var(--_placeholder-padding);
				background: var(--_placeholder-bg);
				border: 2px dashed var(--_placeholder-border-color);
				border-radius: 0.5em;
				text-align: center;
				color: var(--_placeholder-color);
			}

			/* Style: Minimal - override item settings */
			.bsg-spacing--minimal .bsg-spacing-item {
				--_label-font-weight: 400;
			}

			.bsg-spacing--minimal .bsg-spacing-item__variable {
				display: none;
			}

			/* Style: Bold - override item settings */
			.bsg-spacing--bold .bsg-spacing-item {
				--_label-font-size: 0.875em;
				--_label-font-weight: 700;
			}

			.bsg-spacing--bold .bsg-spacing-item__bar {
				--bsg-bar-thickness: 2em;
			}

			/* Style: Colourful - override item settings */
			.bsg-spacing--colourful .bsg-spacing-item {
				--_label-color: var(--bsg-primary, #3b82f6);
				--_variable-bg: var(--bsg-primary-light, #dbeafe);
				--_variable-color: var(--bsg-primary-dark, #1d4ed8);
			}

			.bsg-spacing--colourful .bsg-spacing-item__bar {
				background: linear-gradient(90deg, var(--bsg-primary, #3b82f6), var(--bsg-secondary, #8b5cf6));
			}

			/* Style: Compact - override item settings */
			.bsg-spacing--compact {
				gap: 0.25em;
			}

			.bsg-spacing--compact .bsg-spacing-item {
				--_label-font-size: 0.75em;
				--_variable-font-size: 0.75em;
				gap: 0.5em;
			}

			.bsg-spacing--compact .bsg-spacing-item__info {
				min-width: 5em;
				gap: 0.125em;
			}

			.bsg-spacing--compact .bsg-spacing-item__bar {
				--bsg-bar-thickness: 1em;
			}

			/* Parent override styles - hide elements based on parent data attributes */
			.bsg-spacing[data-override="true"][data-hide-label="true"] .bsg-spacing-item__label {
				display: none;
			}

			.bsg-spacing[data-override="true"][data-hide-variable="true"] .bsg-spacing-item__variable {
				display: none;
			}

			.bsg-spacing[data-override="true"][data-hide-value="true"] .bsg-spacing-item__value {
				display: none;
			}

			.bsg-spacing[data-override="true"][data-hide-value-label="true"] .bsg-spacing-item__value-label {
				display: none;
			}
			} /* end @layer bsg */
		';
	}
}
