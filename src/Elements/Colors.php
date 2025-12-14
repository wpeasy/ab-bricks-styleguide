<?php
/**
 * Colors Element (Nestable) for Bricks Builder.
 *
 * Container element for color swatches from Advanced Themer or Automatic CSS.
 *
 * @package AB\BricksSG
 */

namespace AB\BricksSG\Elements;

use AB\BricksSG\ATColors;
use AB\BricksSG\ATFrameworkDefaults;
use AB\BricksSG\Framework\FrameworkDetector;
use AB\BricksSG\Framework\FrameworkVariables;

defined( 'ABSPATH' ) || exit;

/**
 * Colors Element (Nestable).
 */
class Colors extends \Bricks\Element {

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
	public $name = 'bsg-colors';

	/**
	 * Element icon.
	 *
	 * @var string
	 */
	public $icon = 'ti-palette';

	/**
	 * Element scripts.
	 *
	 * @var array
	 */
	public $scripts = [ 'bsgColorsInit' ];

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
		return esc_html__( 'Colors', 'bricks-style-guide' ) . ' (' . esc_html__( 'Nestable', 'bricks-style-guide' ) . ')';
	}

	/**
	 * Get element keywords.
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return [ 'color', 'swatch', 'palette', 'style guide', 'nestable', 'advanced themer', 'automatic css', 'acss' ];
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

		$this->control_groups['variationsOverride'] = [
			'title' => esc_html__( 'Variations Override', 'bricks-style-guide' ),
			'tab'   => 'content',
		];

		$this->control_groups['styleOverride'] = [
			'title' => esc_html__( 'Style Override', 'bricks-style-guide' ),
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
			'description' => esc_html__( 'Base font size for the element. Sub-components use em units relative to this.', 'bricks-style-guide' ),
		];

		// Layout mode control.
		$this->controls['layoutMode'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Layout Mode', 'bricks-style-guide' ),
			'type'        => 'select',
			'options'     => [
				'default'          => esc_html__( 'Default (Grid)', 'bricks-style-guide' ),
				'stacked'          => esc_html__( 'Stacked (Vertical)', 'bricks-style-guide' ),
				'compact'          => esc_html__( 'Compact', 'bricks-style-guide' ),
				'compact-vertical' => esc_html__( 'Compact Vertical', 'bricks-style-guide' ),
			],
			'default'     => 'default',
			'placeholder' => esc_html__( 'Default (Grid)', 'bricks-style-guide' ),
			'rerender'    => true,
		];

		// Layout controls - Flex options using Bricks dedicated control types.
		$this->controls['flexDirection'] = [
			'group'   => 'layout',
			'label'   => esc_html__( 'Direction', 'bricks-style-guide' ),
			'type'    => 'direction',
			'inline'  => true,
			'css'     => [
				[
					'property' => 'flex-direction',
					'selector' => '',
				],
			],
		];

		$this->controls['justifyContent'] = [
			'group'   => 'layout',
			'label'   => esc_html__( 'Justify', 'bricks-style-guide' ),
			'type'    => 'justify-content',
			'inline'  => true,
			'css'     => [
				[
					'property' => 'justify-content',
					'selector' => '',
				],
			],
		];

		$this->controls['alignItems'] = [
			'group'   => 'layout',
			'label'   => esc_html__( 'Align', 'bricks-style-guide' ),
			'type'    => 'align-items',
			'inline'  => true,
			'css'     => [
				[
					'property' => 'align-items',
					'selector' => '',
				],
			],
		];

		$this->controls['gap'] = [
			'group'   => 'layout',
			'label'   => esc_html__( 'Gap', 'bricks-style-guide' ),
			'type'    => 'number',
			'units'   => true,
			'default' => '2em',
			'css'     => [
				[
					'property' => 'gap',
					'selector' => '',
				],
			],
		];

		$this->controls['showA11yGlossary'] = [
			'group'       => 'layout',
			'label'       => esc_html__( 'Show A11Y Glossary', 'bricks-style-guide' ),
			'type'        => 'checkbox',
			'rerender'    => true,
			'description' => esc_html__( 'Show the WCAG contrast standards glossary when A11Y badges are enabled.', 'bricks-style-guide' ),
		];

		// Display Override controls.
		$this->controls['overrideChildDisplay'] = [
			'group'       => 'displayOverride',
			'label'       => esc_html__( 'Override Child Display Settings', 'bricks-style-guide' ),
			'type'        => 'checkbox',
			'rerender'    => true,
			'description' => esc_html__( 'Enable to control display settings for all child items from here.', 'bricks-style-guide' ),
		];

		$this->controls['hideColorName'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Color Name', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideCssVariable'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide CSS Variable', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideHexValue'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Hex/Color Value', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		$this->controls['hideShadeLabels'] = [
			'group'    => 'displayOverride',
			'label'    => esc_html__( 'Hide Shade Labels', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildDisplay', '!=', '' ],
		];

		// Variations Override controls.
		$this->controls['overrideChildVariations'] = [
			'group'       => 'variationsOverride',
			'label'       => esc_html__( 'Override Child Variation Settings', 'bricks-style-guide' ),
			'type'        => 'checkbox',
			'rerender'    => true,
			'description' => esc_html__( 'Enable to control variation settings for all child items from here.', 'bricks-style-guide' ),
		];

		$this->controls['hideVariations'] = [
			'group'    => 'variationsOverride',
			'label'    => esc_html__( 'Hide All Variations', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildVariations', '!=', '' ],
		];

		$this->controls['hideLightShades'] = [
			'group'    => 'variationsOverride',
			'label'    => esc_html__( 'Hide Light Shades', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildVariations', '!=', '' ],
		];

		$this->controls['hideDarkShades'] = [
			'group'    => 'variationsOverride',
			'label'    => esc_html__( 'Hide Dark Shades', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildVariations', '!=', '' ],
		];

		$this->controls['hideTransparencyShades'] = [
			'group'    => 'variationsOverride',
			'label'    => esc_html__( 'Hide Transparency Shades', 'bricks-style-guide' ),
			'type'     => 'checkbox',
			'rerender' => true,
			'required' => [ 'overrideChildVariations', '!=', '' ],
		];

		// Style Override controls.
		$this->controls['overrideChildStyle'] = [
			'group'       => 'styleOverride',
			'label'       => esc_html__( 'Override Child Style Settings', 'bricks-style-guide' ),
			'type'        => 'checkbox',
			'rerender'    => true,
			'description' => esc_html__( 'Enable to control swatch styling for all child items from here.', 'bricks-style-guide' ),
		];

		$this->controls['parentSwatchSize'] = [
			'group'       => 'styleOverride',
			'label'       => esc_html__( 'Variant Swatch Size', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => $examples['space_xl'],
			'required'    => [ 'overrideChildStyle', '!=', '' ],
			'css'         => [
				[
					'property' => 'width',
					'selector' => '.bsg-colors-item__swatch',
				],
				[
					'property' => 'height',
					'selector' => '.bsg-colors-item__swatch',
				],
				[
					'property'  => 'min-width',
					'selector'  => '.bsg-colors-item__swatch',
					'important' => true,
				],
			],
		];

		$this->controls['parentBaseSize'] = [
			'group'       => 'styleOverride',
			'label'       => esc_html__( 'Base Swatch Width', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => $examples['space_xl'],
			'required'    => [ 'overrideChildStyle', '!=', '' ],
			'css'         => [
				[
					'property'  => 'width',
					'selector'  => '.bsg-colors-item__base-column',
					'important' => true,
				],
				[
					'property'  => 'width',
					'selector'  => '.bsg-colors-item__base',
					'important' => true,
				],
			],
		];

		$this->controls['parentSwatchGap'] = [
			'group'       => 'styleOverride',
			'label'       => esc_html__( 'Swatch Gap', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => $examples['space_3xs'],
			'required'    => [ 'overrideChildStyle', '!=', '' ],
			'css'         => [
				[
					'property' => 'gap',
					'selector' => '.bsg-colors-item__grid',
				],
				[
					'property' => 'gap',
					'selector' => '.bsg-colors-item__column',
				],
			],
		];

		$this->controls['parentSwatchBorderRadius'] = [
			'group'       => 'styleOverride',
			'label'       => esc_html__( 'Swatch Border Radius', 'bricks-style-guide' ),
			'type'        => 'number',
			'units'       => true,
			'placeholder' => $examples['radius_m'],
			'required'    => [ 'overrideChildStyle', '!=', '' ],
			'css'         => [
				[
					'property' => 'border-radius',
					'selector' => '.bsg-colors-item__swatch',
				],
				[
					'property' => 'border-radius',
					'selector' => '.bsg-colors-item__base',
				],
			],
		];

		$this->controls['parentSwatchBorder'] = [
			'group'    => 'styleOverride',
			'label'    => esc_html__( 'Swatch Border', 'bricks-style-guide' ),
			'type'     => 'border',
			'required' => [ 'overrideChildStyle', '!=', '' ],
			'css'      => [
				[
					'property' => 'border',
					'selector' => '.bsg-colors-item__swatch',
				],
				[
					'property' => 'border',
					'selector' => '.bsg-colors-item__base',
				],
			],
		];

		$this->controls['labelTypography'] = [
			'group'    => 'styleOverride',
			'label'    => esc_html__( 'Label Typography', 'bricks-style-guide' ),
			'type'     => 'typography',
			'required' => [ 'overrideChildStyle', '!=', '' ],
			'css'      => [
				[
					'property' => 'font',
					'selector' => '.bsg-colors-item__label',
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
			'name'     => 'bsg-colors-item',
			'label'    => esc_html__( 'Color Item', 'bricks-style-guide' ),
			'settings' => [
				'atColor' => '{item_color_id}',
			],
		];
	}

	/**
	 * Get nestable children.
	 *
	 * Creates a color item for each defined color from the active framework.
	 *
	 * @return array
	 */
	public function get_nestable_children(): array {
		// Use framework-agnostic method to get colors.
		$root_colors = ATColors::get_framework_colors();
		$children    = [];

		foreach ( $root_colors as $color_id => $color ) {
			$child = $this->get_nestable_item();

			// Replace placeholders.
			$child = wp_json_encode( $child );
			$child = str_replace( '{item_color_id}', $color_id, $child );
			$child = json_decode( $child, true );

			$children[] = $child;
		}

		// If no colors found, return empty array.
		if ( empty( $children ) ) {
			return [];
		}

		return $children;
	}

	/**
	 * Render element.
	 *
	 * @return void
	 */
	public function render(): void {
		// Check for framework variables.
		if ( ! ATFrameworkDefaults::has_framework_variables() ) {
			echo ATFrameworkDefaults::render_warning(); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
			return;
		}

		$settings = $this->settings;

		$layout_mode  = $settings['layoutMode'] ?? 'default';
		$root_classes = [ 'bsg-colors' ];

		if ( 'default' !== $layout_mode ) {
			$root_classes[] = 'bsg-colors--' . $layout_mode;
		}

		$this->set_attribute( '_root', 'class', $root_classes );
		$this->set_attribute( '_root', 'data-layout', esc_attr( $layout_mode ) );

		// Pass display override settings as data attributes.
		if ( isset( $settings['overrideChildDisplay'] ) ) {
			$this->set_attribute( '_root', 'data-override-display', 'true' );

			$display_overrides = [
				'hideColorName',
				'hideCssVariable',
				'hideHexValue',
				'hideShadeLabels',
			];

			foreach ( $display_overrides as $setting_key ) {
				if ( isset( $settings[ $setting_key ] ) ) {
					$data_key = strtolower( preg_replace( '/([a-z])([A-Z])/', '$1-$2', $setting_key ) );
					$this->set_attribute( '_root', 'data-' . $data_key, 'true' );
				}
			}
		}

		// Pass variations override settings as data attributes.
		if ( isset( $settings['overrideChildVariations'] ) ) {
			$this->set_attribute( '_root', 'data-override-variations', 'true' );

			$variation_overrides = [
				'hideVariations',
				'hideLightShades',
				'hideDarkShades',
				'hideTransparencyShades',
			];

			foreach ( $variation_overrides as $setting_key ) {
				if ( isset( $settings[ $setting_key ] ) ) {
					$data_key = strtolower( preg_replace( '/([a-z])([A-Z])/', '$1-$2', $setting_key ) );
					$this->set_attribute( '_root', 'data-' . $data_key, 'true' );
				}
			}
		}

		// Check if glossary should be shown.
		// Bricks checkbox: key exists = checked, key missing = unchecked.
		// We want glossary shown by default, so show if key exists OR if never set.
		$show_glossary = isset( $settings['showA11yGlossary'] );

		// Pass glossary setting as data attribute.
		if ( $show_glossary ) {
			$this->set_attribute( '_root', 'data-show-glossary', 'true' );
		}

		$output = "<div {$this->render_attributes( '_root' )}>";

		// A11Y badges toggle switch.
		$output .= '<div class="bsg-colors__toolbar">';
		$output .= '<label class="bsg-colors__toggle">';
		$output .= '<input type="checkbox" class="bsg-colors__toggle-input" data-toggle="a11y-badges">';
		$output .= '<span class="bsg-colors__toggle-switch"></span>';
		$output .= '<span class="bsg-colors__toggle-label">' . esc_html__( 'A11Y Badges', 'bricks-style-guide' ) . '</span>';
		$output .= '</label>';
		$output .= '</div>';

		// A11Y Glossary - reveals when toggle is enabled (if glossary is enabled in settings).
		$output .= '<div class="bsg-colors__glossary">';
		$output .= '<div class="bsg-colors__glossary-inner">';

		// WCAG Standard explanation.
		$output .= '<div class="bsg-colors__glossary-section">';
		$output .= '<h4 class="bsg-colors__glossary-title">' . esc_html__( 'WCAG Contrast Standards', 'bricks-style-guide' ) . '</h4>';
		$output .= '<p class="bsg-colors__glossary-text">' . esc_html__( 'The Web Content Accessibility Guidelines (WCAG) define minimum contrast ratios between text and background colors to ensure readability for users with visual impairments.', 'bricks-style-guide' ) . '</p>';
		$output .= '</div>';

		// Contrast ratios.
		$output .= '<div class="bsg-colors__glossary-section">';
		$output .= '<h4 class="bsg-colors__glossary-title">' . esc_html__( 'Contrast Ratios', 'bricks-style-guide' ) . '</h4>';
		$output .= '<ul class="bsg-colors__glossary-list">';
		$output .= '<li><strong>AAA</strong> ' . esc_html__( '(7:1+) - Enhanced contrast, best for body text', 'bricks-style-guide' ) . '</li>';
		$output .= '<li><strong>AA</strong> ' . esc_html__( '(4.5:1+) - Minimum for normal text', 'bricks-style-guide' ) . '</li>';
		$output .= '<li><strong>AA Large</strong> ' . esc_html__( '(3:1+) - Minimum for large text (24px+ or 19px+ bold)*', 'bricks-style-guide' ) . '</li>';
		$output .= '</ul>';
		$output .= '<p class="bsg-colors__glossary-note">' . esc_html__( '*Approximate px values at 96dpi', 'bricks-style-guide' ) . '</p>';
		$output .= '</div>';

		// Badge legend.
		$output .= '<div class="bsg-colors__glossary-section">';
		$output .= '<h4 class="bsg-colors__glossary-title">' . esc_html__( 'Badge Legend', 'bricks-style-guide' ) . '</h4>';
		$output .= '<div class="bsg-colors__glossary-badges">';
		$output .= '<div class="bsg-colors__glossary-badge-item">';
		$output .= '<span class="bsg-colors__glossary-badge bsg-colors__glossary-badge--pass">' . esc_html__( 'AAA / AA', 'bricks-style-guide' ) . '</span>';
		$output .= '<span class="bsg-colors__glossary-badge-desc">' . esc_html__( 'Pass - Good contrast', 'bricks-style-guide' ) . '</span>';
		$output .= '</div>';
		$output .= '<div class="bsg-colors__glossary-badge-item">';
		$output .= '<span class="bsg-colors__glossary-badge bsg-colors__glossary-badge--large">' . esc_html__( 'AA Large', 'bricks-style-guide' ) . '</span>';
		$output .= '<span class="bsg-colors__glossary-badge-desc">' . esc_html__( 'Large text only', 'bricks-style-guide' ) . '</span>';
		$output .= '</div>';
		$output .= '<div class="bsg-colors__glossary-badge-item">';
		$output .= '<span class="bsg-colors__glossary-badge bsg-colors__glossary-badge--fail">' . esc_html__( 'Fail', 'bricks-style-guide' ) . '</span>';
		$output .= '<span class="bsg-colors__glossary-badge-desc">' . esc_html__( 'Insufficient contrast', 'bricks-style-guide' ) . '</span>';
		$output .= '</div>';
		$output .= '</div>';
		$output .= '</div>';

		// W/B badges explanation.
		$output .= '<div class="bsg-colors__glossary-section">';
		$output .= '<p class="bsg-colors__glossary-text bsg-colors__glossary-text--small">';
		$output .= '<strong>W</strong> = ' . esc_html__( 'contrast against white text', 'bricks-style-guide' ) . '<br>';
		$output .= '<strong>B</strong> = ' . esc_html__( 'contrast against black text', 'bricks-style-guide' );
		$output .= '</p>';
		$output .= '</div>';

		$output .= '</div>'; // .bsg-colors__glossary-inner
		$output .= '</div>'; // .bsg-colors__glossary

		// Render children elements (individual color items).
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
		$handle = 'bsg-colors';

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
			.bsg-colors {
				' . $framework_vars . '
			}

			/* Critical layout */
			.bsg-colors {
				display: flex;
				flex-direction: row;
				flex-wrap: wrap;
			}

			/* Parent display override styles */
			.bsg-colors[data-override-display="true"][data-hide-color-name="true"] .bsg-colors-item__label {
				display: none;
			}

			/* Parent variations override styles */
			/* Hide all variation columns (keep only base) - AT layout */
			.bsg-colors[data-override-variations="true"][data-hide-variations="true"] .bsg-colors-item__column {
				display: none;
			}
			/* Hide all variations - ACSS layout */
			.bsg-colors[data-override-variations="true"][data-hide-variations="true"] .bsg-colors-item__variants-wrapper {
				display: none;
			}

			/* Hide dark shades column - AT layout */
			.bsg-colors[data-override-variations="true"][data-hide-dark-shades="true"] .bsg-colors-item__column[data-variant="dark"] {
				display: none;
			}
			/* Hide dark shades - ACSS layout (individual swatches) */
			.bsg-colors[data-override-variations="true"][data-hide-dark-shades="true"] .bsg-colors-item__swatch[data-variant="dark"] {
				display: none;
			}

			/* Hide light shades column - AT layout */
			.bsg-colors[data-override-variations="true"][data-hide-light-shades="true"] .bsg-colors-item__column[data-variant="light"] {
				display: none;
			}
			/* Hide light shades - ACSS layout (individual swatches) */
			.bsg-colors[data-override-variations="true"][data-hide-light-shades="true"] .bsg-colors-item__swatch[data-variant="light"] {
				display: none;
			}

			/* Hide transparency shades column - AT layout */
			.bsg-colors[data-override-variations="true"][data-hide-transparency-shades="true"] .bsg-colors-item__column[data-variant="transparency"] {
				display: none;
			}
			/* Hide transparency shades - ACSS layout */
			.bsg-colors[data-override-variations="true"][data-hide-transparency-shades="true"] .bsg-colors-item__transparencies {
				display: none;
			}

			/* Toolbar with toggle */
			.bsg-colors__toolbar {
				width: 100%;
				display: flex;
				justify-content: flex-start;
				margin-bottom: 0.5em;
			}

			.bsg-colors__toggle {
				display: flex;
				align-items: center;
				gap: 0.375em;
				cursor: pointer;
				user-select: none;
			}

			.bsg-colors__toggle-input {
				position: absolute;
				opacity: 0;
				width: 0;
				height: 0;
			}

			/* A11Y badges - hidden by default */
			.bsg-colors .bsg-colors-item__contrast-badges {
				display: none;
			}

			/* Show A11Y badges when toggle is checked */
			.bsg-colors[data-show-a11y-badges="true"] .bsg-colors-item__contrast-badges {
				display: flex;
			}

			/* A11Y Glossary - completely hidden by default with smooth reveal */
			.bsg-colors__glossary {
				width: 100%;
				display: grid;
				grid-template-rows: 0fr;
				transition: grid-template-rows 0.3s ease-out;
			}

			.bsg-colors__glossary-inner {
				min-height: 0;
				overflow: hidden;
				display: flex;
				flex-wrap: wrap;
				gap: 1.5em;
				padding: 0;
				border: 1px solid transparent;
				transition: padding 0.3s ease-out, border-color 0.3s ease-out;
			}

			/* Show glossary when A11Y toggle is enabled AND glossary setting is on */
			.bsg-colors[data-show-a11y-badges="true"][data-show-glossary="true"] .bsg-colors__glossary {
				grid-template-rows: 1fr;
			}

			.bsg-colors[data-show-a11y-badges="true"][data-show-glossary="true"] .bsg-colors__glossary-inner {
				padding: 1em;
				border-color: var(--bsg-border-color, #d1d5db);
			}

			.bsg-colors__glossary-section {
				flex: 1 1 20rem;
				min-width: 18rem;
			}

			.bsg-colors__glossary-badges {
				display: flex;
				flex-direction: column;
				gap: 0.5em;
			}

			.bsg-colors__glossary-badge-item {
				display: flex;
				align-items: center;
				gap: 0.5em;
			}

			@layer bsg {
			/* === Settings === */
			.bsg-colors {
				--_toggle-switch-width: var(--bsg-colors-toggle-switch-width, 1.5em);
				--_toggle-switch-height: var(--bsg-colors-toggle-switch-height, 0.875em);
				--_toggle-switch-bg: var(--bsg-colors-toggle-switch-bg, var(--bsg-border-color, #d1d5db));
				--_toggle-switch-active-bg: var(--bsg-colors-toggle-switch-active-bg, var(--bsg-primary, #3b82f6));
				--_toggle-label-font-size: var(--bsg-colors-toggle-label-font-size, 0.6875em);
				--_toggle-label-color: var(--bsg-colors-toggle-label-color, var(--bsg-neutral-medium, #6b7280));
				--_glossary-bg: var(--bsg-colors-glossary-bg, var(--bsg-neutral-light, #f3f4f6));
				--_glossary-title-color: var(--bsg-colors-glossary-title-color, var(--bsg-neutral-darker, #1f2937));
				--_glossary-text-color: var(--bsg-colors-glossary-text-color, var(--bsg-neutral-medium, #6b7280));
			}

			.bsg-colors__toggle-switch {
				position: relative;
				width: var(--_toggle-switch-width);
				height: var(--_toggle-switch-height);
				background: var(--_toggle-switch-bg);
				border-radius: 0.4375em;
				transition: background 0.2s ease;
			}

			.bsg-colors__toggle-switch::after {
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

			.bsg-colors__toggle-input:checked + .bsg-colors__toggle-switch {
				background: var(--_toggle-switch-active-bg);
			}

			.bsg-colors__toggle-input:checked + .bsg-colors__toggle-switch::after {
				transform: translateX(0.625em);
			}

			.bsg-colors__toggle-label {
				font-size: var(--_toggle-label-font-size);
				color: var(--_toggle-label-color);
			}

			.bsg-colors__glossary-inner {
				background: var(--_glossary-bg);
				border-radius: var(--bsg-radius-s, 0.5em);
			}

			.bsg-colors__glossary-title {
				margin: 0 0 0.5em 0;
				font-size: 0.8125em;
				font-weight: 600;
				color: var(--_glossary-title-color);
			}

			.bsg-colors__glossary-text {
				margin: 0;
				font-size: 0.75em;
				line-height: 1.5;
				color: var(--_glossary-text-color);
			}

			.bsg-colors__glossary-text--small {
				font-size: 0.6875em;
			}

			.bsg-colors__glossary-list {
				margin: 0;
				padding-left: 1em;
				font-size: 0.75em;
				line-height: 1.6;
				color: var(--_glossary-text-color);
			}

			.bsg-colors__glossary-list li {
				margin-bottom: 0.25em;
			}

			.bsg-colors__glossary-note {
				margin: 0.5em 0 0 0;
				font-size: 0.625em;
				font-style: italic;
				color: var(--bsg-neutral-medium, #9ca3af);
			}

			.bsg-colors__glossary-badge {
				display: inline-flex;
				align-items: center;
				justify-content: center;
				padding: 0.125em 0.5em;
				font-size: 0.625em;
				font-weight: 600;
				border-radius: 0.25em;
				min-width: 3.5em;
				text-align: center;
			}

			/* A11Y badges use hardcoded white for guaranteed contrast */
			.bsg-colors__glossary-badge--pass {
				background: var(--bsg-success, #10b981);
				color: #ffffff;
			}

			.bsg-colors__glossary-badge--large {
				background: var(--bsg-warning, #f59e0b);
				color: #ffffff;
			}

			.bsg-colors__glossary-badge--fail {
				background: var(--bsg-error, #ef4444);
				color: #ffffff;
			}

			.bsg-colors__glossary-badge-desc {
				font-size: 0.6875em;
				color: var(--_glossary-text-color);
			}
			} /* end @layer bsg */
		';
	}
}
