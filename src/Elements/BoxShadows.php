<?php
/**
 * Box Shadows Element (Nestable) for Bricks Builder.
 *
 * Container element for box shadow samples with computed values.
 *
 * @package AB\BricksSG
 */

namespace AB\BricksSG\Elements;

use AB\BricksSG\ATFrameworkDefaults;
use AB\BricksSG\Framework\FrameworkDetector;
use AB\BricksSG\Framework\FrameworkVariables;

defined( 'ABSPATH' ) || exit;

/**
 * Box Shadows Element (Nestable).
 */
class BoxShadows extends \Bricks\Element {

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
	public $name = 'bsg-box-shadows';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-layers';

	/**
	 * Element scripts.
	 *
	 * @var array
	 */
	public $scripts = [ 'bsgBoxShadowsInit' ];

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
		return esc_html__( 'Box Shadows', 'bricks-style-guide' ) . ' (' . esc_html__( 'Nestable', 'bricks-style-guide' ) . ')';
	}

	/**
	 * Get element keywords.
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'shadow', 'elevation', 'depth', 'box-shadow', 'style guide', 'nestable' ];
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
	}

	/**
	 * Set controls.
	 *
	 * @return void
	 */
	public function set_controls(): void {
		// Get framework-specific example variables.
		$examples = FrameworkDetector::get_example_variables();

		// Layout controls.
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
			'placeholder' => '2em',
			'css'         => [
				[
					'property' => 'gap',
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

		// Container background.
		$this->controls['containerBackground'] = [
			'group' => 'layout',
			'label' => esc_html__( 'Container Background', 'bricks-style-guide' ),
			'type'  => 'color',
			'css'   => [
				[
					'property' => 'background-color',
					'selector' => '',
				],
			],
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
			'label'    => esc_html__( 'Hide Shadow Value', 'bricks-style-guide' ),
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
		$this->controls['boxSize'] = [
			'group'       => 'style',
			'label'       => esc_html__( 'Box Size', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => '7.5em',
			'css'         => [
				[
					'property' => 'width',
					'selector' => '.bsg-shadows-item__box',
				],
				[
					'property' => 'height',
					'selector' => '.bsg-shadows-item__box',
				],
			],
		];

		$this->controls['boxBackground'] = [
			'group' => 'style',
			'label' => esc_html__( 'Box Background', 'bricks-style-guide' ),
			'type'  => 'color',
			'css'   => [
				[
					'property' => 'background-color',
					'selector' => '.bsg-shadows-item__box',
				],
			],
		];

		$this->controls['boxRadius'] = [
			'group'       => 'style',
			'label'       => esc_html__( 'Box Border Radius', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => '0.5em',
			'css'         => [
				[
					'property' => 'border-radius',
					'selector' => '.bsg-shadows-item__box',
				],
			],
		];

		$this->controls['labelTypography'] = [
			'group' => 'style',
			'label' => esc_html__( 'Label Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-shadows-item__label',
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
					'selector' => '.bsg-shadows-item__variable',
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
					'selector' => '.bsg-shadows-item__value',
				],
			],
		];
	}

	/**
	 * Get nestable item structure.
	 *
	 * @return array
	 */
	public function get_nestable_item(): array {
		return [
			'name'     => 'bsg-box-shadows-item',
			'label'    => esc_html__( 'Box Shadow Item', 'bricks-style-guide' ),
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
		// Get shadow variables from the active framework.
		$framework = FrameworkDetector::get_active_framework();
		if ( $framework ) {
			$shadow_vars = $framework::get_shadow_variables();
		} else {
			// Fallback to generic items.
			$shadow_vars = [
				[ 'name' => 's', 'variable' => '--shadow-s' ],
				[ 'name' => 'm', 'variable' => '--shadow-m' ],
				[ 'name' => 'l', 'variable' => '--shadow-l' ],
				[ 'name' => 'xl', 'variable' => '--shadow-xl' ],
			];
		}

		$children = [];

		foreach ( $shadow_vars as $item ) {
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

		$style_preset = $settings['stylePreset'] ?? 'default';

		$root_classes = [ 'bsg-shadows' ];
		if ( 'default' !== $style_preset ) {
			$root_classes[] = 'bsg-shadows--' . $style_preset;
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

		// Render children elements (individual shadow items).
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
		$handle = 'bsg-box-shadows';

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
			.bsg-shadows {
				' . $framework_vars . '
				display: flex;
				flex-wrap: wrap;
				gap: 2em;
			}

			/* Parent override styles - hide elements based on parent data attributes */
			.bsg-shadows[data-override="true"][data-hide-label="true"] .bsg-shadows-item__label {
				display: none;
			}

			.bsg-shadows[data-override="true"][data-hide-variable="true"] .bsg-shadows-item__variable {
				display: none;
			}

			.bsg-shadows[data-override="true"][data-hide-value="true"] .bsg-shadows-item__value {
				display: none;
			}

			.bsg-shadows[data-override="true"][data-hide-value-label="true"] .bsg-shadows-item__value-label {
				display: none;
			}

			@layer bsg {
			/* === Settings === */
			.bsg-shadows {
				--_placeholder-padding: var(--bsg-shadows-placeholder-padding, 2em);
				--_placeholder-bg: var(--bsg-shadows-placeholder-bg, var(--bsg-neutral-light, #f3f4f6));
				--_placeholder-border-color: var(--bsg-shadows-placeholder-border-color, var(--bsg-border-color, #d1d5db));
				--_placeholder-color: var(--bsg-shadows-placeholder-color, var(--bsg-neutral-medium, #6b7280));
			}

			.bsg-shadows__placeholder {
				padding: var(--_placeholder-padding);
				background: var(--_placeholder-bg);
				border: 2px dashed var(--_placeholder-border-color);
				border-radius: 0.5em;
				text-align: center;
				color: var(--_placeholder-color);
				width: 100%;
			}

			/* Style: Minimal - override item settings */
			.bsg-shadows--minimal .bsg-shadows-item__variable {
				display: none;
			}

			/* Style: Bold - override item settings */
			.bsg-shadows--bold .bsg-shadows-item {
				--_label-font-size: 0.875em;
				--_label-font-weight: 700;
				--_box-size: 8.75em;
			}

			/* Style: Colourful - override item settings */
			.bsg-shadows--colourful .bsg-shadows-item {
				--_label-color: var(--bsg-primary, #3b82f6);
				--_variable-bg: var(--bsg-primary-light, #dbeafe);
				--_variable-color: var(--bsg-primary-dark, #1d4ed8);
			}

			.bsg-shadows--colourful .bsg-shadows-item__box {
				background: linear-gradient(135deg, var(--bsg-primary-light, #dbeafe), var(--bsg-secondary-light, #ede9fe));
			}

			/* Style: Compact - override item settings */
			.bsg-shadows--compact {
				gap: 1em;
			}

			.bsg-shadows--compact .bsg-shadows-item {
				--_box-size: 5em;
				--_label-font-size: 0.75em;
				--_variable-font-size: 0.75em;
				gap: 0.375em;
			}
			} /* end @layer bsg */
		';
	}
}
