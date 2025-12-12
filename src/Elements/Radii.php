<?php
/**
 * Radii Element (Nestable) for Bricks Builder.
 *
 * Container element for border radius samples with computed pixel values.
 *
 * @package AB\ATStyleGuide
 */

namespace AB\ATStyleGuide\Elements;

use AB\ATStyleGuide\ATFrameworkDefaults;

defined( 'ABSPATH' ) || exit;

/**
 * Radii Element (Nestable).
 */
class Radii extends \Bricks\Element {

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
	public $name = 'at-radii';

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
	public $scripts = [ 'atRadiiInit' ];

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
		return esc_html__( 'Border Radii', 'advanced-themer-style-guide' ) . ' (' . esc_html__( 'Nestable', 'advanced-themer-style-guide' ) . ')';
	}

	/**
	 * Get element keywords.
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'radius', 'border', 'rounded', 'corners', 'style guide', 'nestable' ];
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
		// Layout controls.
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
			'description' => esc_html__( 'Base font size for the element. Sub-components use em units relative to this.', 'advanced-themer-style-guide' ),
		];

		$this->controls['gap'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Gap', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => '1.5em',
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
			'label'    => esc_html__( 'Style Preset', 'advanced-themer-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'default'   => esc_html__( 'Default', 'advanced-themer-style-guide' ),
				'minimal'   => esc_html__( 'Minimal', 'advanced-themer-style-guide' ),
				'bold'      => esc_html__( 'Bold', 'advanced-themer-style-guide' ),
				'colourful' => esc_html__( 'Colourful', 'advanced-themer-style-guide' ),
				'compact'   => esc_html__( 'Compact', 'advanced-themer-style-guide' ),
			],
			'default'  => 'default',
			'inline'   => true,
			'rerender' => true,
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

		$this->controls['hideVariable'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Variable Name', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideValue'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Computed Value', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideValueLabel'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Value Label', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		// Item styling controls.
		$this->controls['boxSize'] = [
			'group'       => 'style',
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
			'group' => 'style',
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
			'group' => 'style',
			'label' => esc_html__( 'Box Border', 'advanced-themer-style-guide' ),
			'type'  => 'border',
			'css'   => [
				[
					'property' => 'border',
					'selector' => '.atsg-radii-item__box',
				],
			],
		];

		$this->controls['labelTypography'] = [
			'group' => 'style',
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
			'group' => 'style',
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
			'group' => 'style',
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
	 * Get nestable item structure.
	 *
	 * @return array
	 */
	public function get_nestable_item(): array {
		return [
			'name'     => 'at-radii-item',
			'label'    => esc_html__( 'Radii Item', 'advanced-themer-style-guide' ),
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
		$default_items = [
			[ 'label' => 'XS', 'variable' => '--at-radius--xs' ],
			[ 'label' => 'S', 'variable' => '--at-radius--s' ],
			[ 'label' => 'M', 'variable' => '--at-radius--m' ],
			[ 'label' => 'L', 'variable' => '--at-radius--l' ],
			[ 'label' => 'XL', 'variable' => '--at-radius--xl' ],
			[ 'label' => 'Full', 'variable' => '--at-radius--full' ],
		];

		$children = [];

		foreach ( $default_items as $item ) {
			$child = $this->get_nestable_item();

			// Replace placeholders.
			$child      = wp_json_encode( $child );
			$child      = str_replace( '{item_label}', $item['label'], $child );
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
		// Check for ATF variables.
		if ( ! ATFrameworkDefaults::has_at_variables() ) {
			echo ATFrameworkDefaults::render_warning(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}

		$settings = $this->settings;

		$style_preset = $settings['stylePreset'] ?? 'default';

		$root_classes = [ 'atsg-radii' ];
		if ( 'default' !== $style_preset ) {
			$root_classes[] = 'atsg-radii--' . $style_preset;
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

		// Render children elements (individual radii items).
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
			'at-radii',
			false,
			[],
			AT_STYLE_GUIDE_VERSION
		);
		wp_add_inline_style( 'at-radii', $this->get_element_css() );
		wp_enqueue_style( 'at-radii' );
	}

	/**
	 * Get inline CSS for the element.
	 *
	 * @return string
	 */
	private function get_element_css(): string {
		return '
			.atsg-radii {
				display: flex;
				flex-wrap: wrap;
				gap: 1.5em;
			}

			.atsg-radii__placeholder {
				padding: 2em;
				background: var(--at-neutral-t-6, #f3f4f6);
				border: 2px dashed var(--at-border-color, #d1d5db);
				border-radius: 0.5em;
				text-align: center;
				color: var(--at-neutral-d-2, #6b7280);
				width: 100%;
			}

			/* Style: Minimal */
			.atsg-radii--minimal .atsg-radii-item__variable {
				display: none;
			}

			.atsg-radii--minimal .atsg-radii-item__box {
				border: none;
				background-color: var(--at-neutral-t-4, #d1d5db);
			}

			/* Style: Bold */
			.atsg-radii--bold .atsg-radii-item__label {
				font-size: 0.875em;
				font-weight: 700;
			}

			.atsg-radii--bold .atsg-radii-item__box {
				border-width: 3px;
			}

			/* Style: Colourful */
			.atsg-radii--colourful .atsg-radii-item__box {
				background: linear-gradient(135deg, var(--at-primary-l-4, #bfdbfe), var(--at-secondary-l-4, #c4b5fd));
				border-color: var(--at-primary, #3b82f6);
			}

			.atsg-radii--colourful .atsg-radii-item__label {
				color: var(--at-primary, #3b82f6);
			}

			.atsg-radii--colourful .atsg-radii-item__variable {
				background: var(--at-primary-l-5, #dbeafe);
				color: var(--at-primary-d-2, #1d4ed8);
			}

			/* Style: Compact */
			.atsg-radii--compact {
				gap: 0.75em;
			}

			.atsg-radii--compact .atsg-radii-item {
				gap: 0.375em;
			}

			.atsg-radii--compact .atsg-radii-item__box {
				width: 3.75em;
				height: 3.75em;
			}

			.atsg-radii--compact .atsg-radii-item__label {
				font-size: 0.75em;
			}

			.atsg-radii--compact .atsg-radii-item__variable {
				font-size: 0.75em;
			}

			/* Parent override styles - hide elements based on parent data attributes */
			.atsg-radii[data-override="true"][data-hide-label="true"] .atsg-radii-item__label {
				display: none;
			}

			.atsg-radii[data-override="true"][data-hide-variable="true"] .atsg-radii-item__variable {
				display: none;
			}

			.atsg-radii[data-override="true"][data-hide-value="true"] .atsg-radii-item__value {
				display: none;
			}

			.atsg-radii[data-override="true"][data-hide-value-label="true"] .atsg-radii-item__value-label {
				display: none;
			}
		';
	}
}
