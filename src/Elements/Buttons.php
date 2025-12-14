<?php
/**
 * Buttons Element (Nestable) for Bricks Builder.
 *
 * Container element for button samples showing variants and sizes.
 *
 * @package AB\BricksSG
 */

namespace AB\BricksSG\Elements;

use AB\BricksSG\ATFrameworkDefaults;
use AB\BricksSG\Framework\FrameworkDetector;
use AB\BricksSG\Framework\FrameworkVariables;

defined( 'ABSPATH' ) || exit;

/**
 * Buttons Element (Nestable).
 */
class Buttons extends \Bricks\Element {

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
	public $name = 'bsg-buttons';

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
	public $scripts = [ 'bsgButtonsInit' ];

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
		return esc_html__( 'Buttons', 'bricks-style-guide' ) . ' (' . esc_html__( 'Nestable', 'bricks-style-guide' ) . ')';
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

		$this->controls['layout'] = [
			'group'    => 'layout',
			'label'    => esc_html__( 'Layout', 'bricks-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'grid' => esc_html__( 'Grid', 'bricks-style-guide' ),
				'rows' => esc_html__( 'Rows (by Color)', 'bricks-style-guide' ),
			],
			'default'  => 'grid',
			'inline'   => true,
			'rerender' => true,
		];

		$this->controls['columns'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Columns', 'bricks-style-guide' ),
			'type'        => 'number',
			'min'         => 1,
			'max'         => 8,
			'default'     => 4,
			'required'    => [ 'layout', '=', 'grid' ],
			'css'         => [
				[
					'property' => 'grid-template-columns',
					'selector' => '&.bsg-buttons--grid .bsg-buttons__grid',
					'value'    => 'repeat(%s, 1fr)',
				],
			],
		];

		$this->controls['gap'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Gap', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => '1.5em',
			'css'         => [
				[
					'property' => 'gap',
					'selector' => '.bsg-buttons__grid',
				],
			],
		];

		$this->controls['rowGap'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Row Gap', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => '2em',
			'required'    => [ 'layout', '=', 'rows' ],
			'css'         => [
				[
					'property' => 'gap',
					'selector' => '.bsg-buttons--rows .bsg-buttons__grid',
				],
			],
		];

		// Style preset.
		$this->controls['stylePreset'] = [
			'group'    => 'layout',
			'label'    => esc_html__( 'Style Preset', 'bricks-style-guide' ),
			'type'     => 'select',
			'options'  => [
				'default' => esc_html__( 'Default', 'bricks-style-guide' ),
				'minimal' => esc_html__( 'Minimal', 'bricks-style-guide' ),
				'compact' => esc_html__( 'Compact', 'bricks-style-guide' ),
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

		$this->controls['hideDescription'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Description', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideClasses'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide CSS Classes', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		// Typography controls for item styling.
		$this->controls['descriptionTypography'] = [
			'group' => 'style',
			'label' => esc_html__( 'Description Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-buttons-item__description',
				],
			],
		];

		$this->controls['classesTypography'] = [
			'group' => 'style',
			'label' => esc_html__( 'Classes Typography', 'bricks-style-guide' ),
			'type'  => 'typography',
			'css'   => [
				[
					'property' => 'font',
					'selector' => '.bsg-buttons-item__classes',
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
			'name'     => 'bsg-buttons-item',
			'label'    => esc_html__( 'Button Item', 'bricks-style-guide' ),
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
	 * Creates a grid of buttons: colors × sizes (solid variant).
	 * Colors are framework-specific.
	 *
	 * @return array
	 */
	public function get_nestable_children(): array {
		// Use framework-specific colors.
		$is_acss = FrameworkDetector::is_acss_active();
		$colors  = $is_acss
			? [ 'primary', 'primary-dark', 'primary-light', 'secondary', 'secondary-dark', 'secondary-light' ]
			: [ 'primary', 'secondary', 'dark', 'light' ];
		$sizes   = [ 'sm', 'md', 'lg', 'xl' ];

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
		// Check for framework variables (AT or ACSS).
		if ( ! ATFrameworkDefaults::has_framework_variables() ) {
			echo ATFrameworkDefaults::render_warning(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}

		$settings = $this->settings;

		$layout       = $settings['layout'] ?? 'grid';
		$style_preset = $settings['stylePreset'] ?? 'default';

		$root_classes = [ 'bsg-buttons', 'bsg-buttons--' . $layout ];
		if ( 'default' !== $style_preset ) {
			$root_classes[] = 'bsg-buttons--' . $style_preset;
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

		$output  = "<div {$this->render_attributes( '_root' )}>";
		$is_acss = FrameworkDetector::is_acss_active();

		// Toolbar with toggle switches.
		$output .= '<div class="bsg-buttons__toolbar">';

		// Rounded toggle - only for Bricks/AT (ACSS has no rounded button class).
		if ( ! $is_acss ) {
			$output .= '<label class="bsg-buttons__toggle">';
			$output .= '<input type="checkbox" class="bsg-buttons__toggle-input" data-toggle="rounded">';
			$output .= '<span class="bsg-buttons__toggle-switch"></span>';
			$output .= '<span class="bsg-buttons__toggle-label">' . esc_html__( 'Rounded', 'bricks-style-guide' ) . '</span>';
			$output .= '</label>';
		}

		// Outline toggle - available for both frameworks.
		$output .= '<label class="bsg-buttons__toggle">';
		$output .= '<input type="checkbox" class="bsg-buttons__toggle-input" data-toggle="outline">';
		$output .= '<span class="bsg-buttons__toggle-switch"></span>';
		$output .= '<span class="bsg-buttons__toggle-label">' . esc_html__( 'Outline', 'bricks-style-guide' ) . '</span>';
		$output .= '</label>';
		$output .= '</div>';

		// Grid wrapper for button items.
		$output .= '<div class="bsg-buttons__grid">';

		// Render children elements (individual button items).
		$output .= \Bricks\Frontend::render_children( $this );

		$output .= '</div>'; // .bsg-buttons__grid
		$output .= '</div>';

		echo $output; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
	}

	/**
	 * Enqueue element styles.
	 *
	 * @return void
	 */
	public function enqueue_scripts(): void {
		$handle = 'bsg-buttons';

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
		// Get framework-agnostic CSS variables that map to the active framework.
		$framework_vars = FrameworkVariables::get_css_variables();

		return '
			/* Framework Variable Mappings */
			.bsg-buttons {
				' . $framework_vars . '
			}

			/* Layout only - button styling handled by Bricks/AT */
			.bsg-buttons {
				display: flex;
				flex-direction: column;
				gap: var(--bsg-space-m, 0.75em);
			}

			.bsg-buttons__grid {
				display: flex;
				flex-wrap: wrap;
				gap: 1.5em;
			}

			/* Grid layout */
			.bsg-buttons--grid .bsg-buttons__grid {
				display: grid;
				grid-template-columns: repeat(4, 1fr);
			}

			@media screen and (max-width: 600px) {
				.bsg-buttons--grid .bsg-buttons__grid {
					grid-template-columns: repeat(2, 1fr) !important;
				}
			}

			/* Rows layout - items in a row */
			.bsg-buttons--rows .bsg-buttons__grid {
				display: flex;
				flex-direction: column;
				gap: 2em;
			}

			.bsg-buttons--rows .bsg-buttons-item {
				flex-direction: row;
				justify-content: flex-start;
				gap: 1.5em;
			}

			.bsg-buttons--rows .bsg-buttons-item__info {
				align-items: flex-start;
				text-align: left;
				min-width: 9.375em;
			}

			/* Toolbar with toggles */
			.bsg-buttons__toolbar {
				display: flex;
				gap: 1em;
			}

			.bsg-buttons__toggle {
				display: flex;
				align-items: center;
				gap: 0.375em;
				cursor: pointer;
				user-select: none;
			}

			.bsg-buttons__toggle-input {
				position: absolute;
				opacity: 0;
				width: 0;
				height: 0;
			}

			/* Parent override styles - hide elements based on parent data attributes */
			.bsg-buttons[data-override="true"][data-hide-description="true"] .bsg-buttons-item__description {
				display: none;
			}

			.bsg-buttons[data-override="true"][data-hide-classes="true"] .bsg-buttons-item__classes {
				display: none;
			}

			@layer bsg {
			/* === Settings === */
			.bsg-buttons {
				--_toggle-switch-width: var(--bsg-buttons-toggle-switch-width, 1.5em);
				--_toggle-switch-height: var(--bsg-buttons-toggle-switch-height, 0.875em);
				--_toggle-switch-bg: var(--bsg-buttons-toggle-switch-bg, var(--bsg-border-color, #d1d5db));
				--_toggle-switch-active-bg: var(--bsg-buttons-toggle-switch-active-bg, var(--bsg-primary, #3b82f6));
				--_toggle-label-font-size: var(--bsg-buttons-toggle-label-font-size, 0.6875em);
				--_toggle-label-color: var(--bsg-buttons-toggle-label-color, var(--bsg-neutral-medium, #6b7280));
			}

			/* Style: Minimal - override item settings */
			.bsg-buttons--minimal .bsg-buttons-item__classes {
				display: none;
			}

			/* Style: Compact - override item settings */
			.bsg-buttons--compact {
				gap: 1em;
			}

			.bsg-buttons--compact.bsg-buttons--grid .bsg-buttons__grid {
				grid-template-columns: repeat(4, auto);
				justify-content: start;
			}

			.bsg-buttons--compact .bsg-buttons-item {
				--_description-font-size: 0.75em;
				--_classes-font-size: 0.625em;
				gap: 0.5em;
			}

			.bsg-buttons__toggle-switch {
				position: relative;
				width: var(--_toggle-switch-width);
				height: var(--_toggle-switch-height);
				background: var(--_toggle-switch-bg);
				border-radius: 0.4375em;
				transition: background 0.2s ease;
			}

			.bsg-buttons__toggle-switch::after {
				content: "";
				position: absolute;
				top: 0.125em;
				left: 0.125em;
				width: 0.625em;
				height: 0.625em;
				background: var(--bsg-white, #ffffff);
				border-radius: 50%;
				transition: transform 0.2s ease;
			}

			.bsg-buttons__toggle-input:checked + .bsg-buttons__toggle-switch {
				background: var(--_toggle-switch-active-bg);
			}

			.bsg-buttons__toggle-input:checked + .bsg-buttons__toggle-switch::after {
				transform: translateX(0.625em);
			}

			.bsg-buttons__toggle-label {
				font-size: var(--_toggle-label-font-size);
				color: var(--_toggle-label-color);
			}
			} /* end @layer bsg */
		';
	}
}
