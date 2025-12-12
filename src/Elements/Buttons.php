<?php
/**
 * Buttons Element (Nestable) for Bricks Builder.
 *
 * Container element for button samples showing variants and sizes.
 *
 * @package AB\ATStyleGuide
 */

namespace AB\ATStyleGuide\Elements;

use AB\ATStyleGuide\ATFrameworkDefaults;

defined( 'ABSPATH' ) || exit;

/**
 * Buttons Element (Nestable).
 */
class Buttons extends \Bricks\Element {

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
	public $name = 'at-buttons';

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
	public $scripts = [ 'atButtonsInit' ];

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
		return esc_html__( 'Buttons', 'advanced-themer-style-guide' ) . ' (' . esc_html__( 'Nestable', 'advanced-themer-style-guide' ) . ')';
	}

	/**
	 * Get element keywords.
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'button', 'cta', 'action', 'style guide', 'nestable' ];
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

		$this->controls['layout'] = [
			'group'    => 'layout',
			'label'    => esc_html__( 'Layout', 'advanced-themer-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'grid' => esc_html__( 'Grid', 'advanced-themer-style-guide' ),
				'rows' => esc_html__( 'Rows (by Color)', 'advanced-themer-style-guide' ),
			],
			'default'  => 'grid',
			'inline'   => true,
			'rerender' => true,
		];

		$this->controls['columns'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Columns', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'min'         => 1,
			'max'         => 8,
			'default'     => 4,
			'required'    => [ 'layout', '=', 'grid' ],
			'css'         => [
				[
					'property' => 'grid-template-columns',
					'selector' => '&.atsg-buttons--grid .atsg-buttons__grid',
					'value'    => 'repeat(%s, 1fr)',
				],
			],
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
					'selector' => '.atsg-buttons__grid',
				],
			],
		];

		$this->controls['rowGap'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Row Gap', 'advanced-themer-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => '2em',
			'required'    => [ 'layout', '=', 'rows' ],
			'css'         => [
				[
					'property' => 'gap',
					'selector' => '.atsg-buttons--rows .atsg-buttons__grid',
				],
			],
		];

		// Style preset.
		$this->controls['stylePreset'] = [
			'group'    => 'layout',
			'label'    => esc_html__( 'Style Preset', 'advanced-themer-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'default' => esc_html__( 'Default', 'advanced-themer-style-guide' ),
				'minimal' => esc_html__( 'Minimal', 'advanced-themer-style-guide' ),
				'compact' => esc_html__( 'Compact', 'advanced-themer-style-guide' ),
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

		$this->controls['hideDescription'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Description', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideClasses'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide CSS Classes', 'advanced-themer-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		// Typography controls for item styling.
		$this->controls['descriptionTypography'] = [
			'group' => 'style',
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
			'group' => 'style',
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
	 * Get nestable item structure.
	 *
	 * @return array
	 */
	public function get_nestable_item(): array {
		return [
			'name'     => 'at-buttons-item',
			'label'    => esc_html__( 'Button Item', 'advanced-themer-style-guide' ),
			'settings' => [
				'label'   => '{item_label}',
				'variant' => '{item_variant}',
				'color'   => '{item_color}',
				'size'    => '{item_size}',
			],
		];
	}

	/**
	 * Get nestable children.
	 *
	 * Creates a grid of buttons: 4 colors × 4 sizes = 16 buttons (solid variant).
	 *
	 * @return array
	 */
	public function get_nestable_children(): array {
		$colors = [ 'primary', 'secondary', 'dark', 'light' ];
		$sizes  = [ 'sm', 'md', 'lg', 'xl' ];

		$children = [];

		foreach ( $colors as $color ) {
			foreach ( $sizes as $size ) {
				$child = $this->get_nestable_item();

				// Replace placeholders.
				$child = wp_json_encode( $child );
				$child = str_replace( '{item_label}', 'Button', $child );
				$child = str_replace( '{item_variant}', 'solid', $child );
				$child = str_replace( '{item_color}', $color, $child );
				$child = str_replace( '{item_size}', $size, $child );
				$child = json_decode( $child, true );

				$children[] = $child;
			}
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

		$layout       = $settings['layout'] ?? 'grid';
		$style_preset = $settings['stylePreset'] ?? 'default';

		$root_classes = [ 'atsg-buttons', 'atsg-buttons--' . $layout ];
		if ( 'default' !== $style_preset ) {
			$root_classes[] = 'atsg-buttons--' . $style_preset;
		}

		$this->set_attribute( '_root', 'class', $root_classes );

		// Pass override settings as data attributes for child elements to read.
		if ( isset( $settings['overrideChildDisplay'] ) ) {
			$this->set_attribute( '_root', 'data-override', 'true' );

			$override_settings = [
				'hideDescription',
				'hideClasses',
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

		// Toolbar with toggle switches.
		$output .= '<div class="atsg-buttons__toolbar">';
		$output .= '<label class="atsg-buttons__toggle">';
		$output .= '<input type="checkbox" class="atsg-buttons__toggle-input" data-toggle="rounded">';
		$output .= '<span class="atsg-buttons__toggle-switch"></span>';
		$output .= '<span class="atsg-buttons__toggle-label">' . esc_html__( 'Rounded', 'advanced-themer-style-guide' ) . '</span>';
		$output .= '</label>';
		$output .= '<label class="atsg-buttons__toggle">';
		$output .= '<input type="checkbox" class="atsg-buttons__toggle-input" data-toggle="outline">';
		$output .= '<span class="atsg-buttons__toggle-switch"></span>';
		$output .= '<span class="atsg-buttons__toggle-label">' . esc_html__( 'Outline', 'advanced-themer-style-guide' ) . '</span>';
		$output .= '</label>';
		$output .= '</div>';

		// Grid wrapper for button items.
		$output .= '<div class="atsg-buttons__grid">';

		// Render children elements (individual button items).
		$output .= \Bricks\Frontend::render_children( $this );

		$output .= '</div>'; // .atsg-buttons__grid
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
			'at-buttons',
			false,
			[],
			AT_STYLE_GUIDE_VERSION
		);
		wp_add_inline_style( 'at-buttons', $this->get_element_css() );
		wp_enqueue_style( 'at-buttons' );
	}

	/**
	 * Get inline CSS for the element.
	 *
	 * @return string
	 */
	private function get_element_css(): string {
		return '
			.atsg-buttons {
				display: flex;
				flex-direction: column;
				gap: 0.75em;
			}

			.atsg-buttons__grid {
				display: flex;
				flex-wrap: wrap;
				gap: 1.5em;
			}

			/* Grid layout */
			.atsg-buttons--grid .atsg-buttons__grid {
				display: grid;
				grid-template-columns: repeat(4, 1fr);
			}

			@media screen and (max-width: 600px) {
				.atsg-buttons--grid .atsg-buttons__grid {
					grid-template-columns: repeat(2, 1fr) !important;
				}
			}

			/* Rows layout - items in a row */
			.atsg-buttons--rows .atsg-buttons__grid {
				display: flex;
				flex-direction: column;
				gap: 2em;
			}

			.atsg-buttons--rows .atsg-buttons-item {
				flex-direction: row;
				justify-content: flex-start;
				gap: 1.5em;
			}

			.atsg-buttons--rows .atsg-buttons-item__info {
				align-items: flex-start;
				text-align: left;
				min-width: 9.375em;
			}

			/* Style: Minimal */
			.atsg-buttons--minimal .atsg-buttons-item__classes {
				display: none;
			}

			/* Style: Compact */
			.atsg-buttons--compact {
				gap: 1em;
			}

			.atsg-buttons--compact.atsg-buttons--grid .atsg-buttons__grid {
				grid-template-columns: repeat(4, auto);
				justify-content: start;
			}

			.atsg-buttons--compact .atsg-buttons-item {
				gap: 0.5em;
			}

			.atsg-buttons--compact .atsg-buttons-item__description {
				font-size: 0.75em;
			}

			.atsg-buttons--compact .atsg-buttons-item__classes {
				font-size: 0.625em;
			}

			/* Parent override styles - hide elements based on parent data attributes */
			.atsg-buttons[data-override="true"][data-hide-description="true"] .atsg-buttons-item__description {
				display: none;
			}

			.atsg-buttons[data-override="true"][data-hide-classes="true"] .atsg-buttons-item__classes {
				display: none;
			}

			/* Toolbar with toggles */
			.atsg-buttons__toolbar {
				display: flex;
				gap: 1em;
			}

			.atsg-buttons__toggle {
				display: flex;
				align-items: center;
				gap: 0.375em;
				cursor: pointer;
				user-select: none;
			}

			.atsg-buttons__toggle-input {
				position: absolute;
				opacity: 0;
				width: 0;
				height: 0;
			}

			.atsg-buttons__toggle-switch {
				position: relative;
				width: 1.5em;
				height: 0.875em;
				background: var(--at-neutral-t-4, #d1d5db);
				border-radius: 0.4375em;
				transition: background 0.2s ease;
			}

			.atsg-buttons__toggle-switch::after {
				content: "";
				position: absolute;
				top: 0.125em;
				left: 0.125em;
				width: 0.625em;
				height: 0.625em;
				background: var(--at-white, #ffffff);
				border-radius: 50%;
				transition: transform 0.2s ease;
			}

			.atsg-buttons__toggle-input:checked + .atsg-buttons__toggle-switch {
				background: var(--at-primary, #3b82f6);
			}

			.atsg-buttons__toggle-input:checked + .atsg-buttons__toggle-switch::after {
				transform: translateX(0.625em);
			}

			.atsg-buttons__toggle-label {
				font-size: 0.6875em;
				color: var(--at-neutral-d-2, #6b7280);
			}
		';
	}
}
