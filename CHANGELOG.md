# Changelog

All notable changes to Bricks Style Guide will be documented in this file.

## [0.0.16-beta] - 2025-12-14

### Changed
- **CSS Architecture**: All elements now use `--_` local scope pattern for easier user overrides
  - Settings block at top of each element's CSS defines public override variables
  - Example: `--_label-color: var(--bsg-typography-item-label-color, #default);`
  - Users can now override any style by setting the public variable (e.g., `--bsg-typography-item-label-color`)
- **All Elements**: Parent style presets (Bold, Colourful, Compact, Minimal) now set local scope variables instead of direct styles

## [0.0.15-beta] - 2025-12-14

### Changed
- **Box Shadows Element**: Now displays CSS variable values from stylesheet instead of computed box-shadow values

### Fixed
- **Typography Element**: Colourful preset now uses CSS variables, allowing typography controls to properly override label and meta styles

## [0.0.14-beta] - 2025-12-14

### Added
- **Colors Element**: Border control for swatches on ColorsItem and parent Style Override
- **Colors Element**: Gap control now uses default value for consistent builder/frontend behavior

### Fixed
- **Colors Element**: Gap control now works in Bricks Builder (removed hardcoded CSS value)
- **Spacing Element**: Vertical bars now display correct heights in Bricks Builder (removed `height: auto` override)

## [0.0.13-beta] - 2025-12-14

### Added
- **Colors Element**: Full keyboard accessibility - Enter/Space to open menu, Escape to close, Arrow keys for navigation
- **Colors Element**: ARIA attributes for screen readers (role, tabindex, aria-haspopup, aria-expanded, aria-controls, aria-label)
- **Colors Element**: Focus trap within color menu with Tab key cycling
- **Colors Element**: ARIA live region for screen reader announcements when copying colors

### Changed
- **Admin Instructions**: All tabs now show framework-specific CSS variable examples (AT vs ACSS)
- **Buttons Element**: Corrected ACSS button colors to only include working classes (primary, secondary with -dark/-light variants)
- **Buttons Element**: Corrected ACSS button sizes to use ACSS naming (btn--s, btn--m, btn--l, btn--xl)
- **Buttons Element**: Rounded toggle now hidden for ACSS (no btn--rounded class exists in ACSS)
- **All Elements**: Removed hardcoded colors - all colors now use framework CSS variables (except A11Y badges)
- **Buttons Element**: Plugin only provides layout CSS; button styling handled entirely by frameworks

### Fixed
- **Colors Element**: Click indicator background now uses framework variables for proper dark mode support
- **Admin Page**: Fixed blank page issue (selector mismatch for Svelte mount target)

## [0.0.12-beta] - 2025-12-14

### Changed
- **Plugin Renamed**: "Advanced Themer Style Guide" renamed to "Bricks Style Guide"
- **PHP Namespace**: Changed from `AB\ATStyleGuide` to `AB\BricksSG`
- **Constants Prefix**: Changed from `AT_STYLE_GUIDE_` to `BRICKS_SG_`
- **Text Domain**: Changed from `advanced-themer-style-guide` to `bricks-style-guide`
- **Element Names**: Changed from `at-*` prefix to `bsg-*` prefix (e.g., `at-typography` → `bsg-typography`)
- **CSS Class Prefix**: Changed from `atsg-` to `bsg-` (e.g., `.atsg-typography` → `.bsg-typography`)
- **JavaScript Functions**: Changed from `at*Init` to `bsg*Init` (e.g., `atTypographyInit` → `bsgTypographyInit`)
- **Admin Menu Slug**: Changed from `at-style-guide` to `bricks-style-guide`
- **Main Plugin File**: Renamed from `advanced-themer-styleguide.php` to `bricks-style-guide.php`

## [0.0.11-beta] - 2025-12-12

### Added
- **Automatic CSS (ACSS) Support**: Plugin now works with Automatic CSS as an alternative to Advanced Themer
- **Framework Provider Architecture**: New `src/Framework/` namespace with Strategy Pattern for multi-framework support
  - `FrameworkProviderInterface.php` - Contract for framework providers
  - `FrameworkDetector.php` - Auto-detects active framework (AT priority when both present)
  - `ATFrameworkProvider.php` - Advanced Themer implementation
  - `ACSSFrameworkProvider.php` - Automatic CSS implementation
- **Framework-agnostic Methods**: `ATColors::get_framework_colors()` and `ATColors::get_framework_color_shades()`
- **Dynamic Shade Names**: ACSS uses named shades (ultra-light, light, semi-light, hover, semi-dark, dark, ultra-dark)

### Changed
- Plugin now requires either Advanced Themer OR Automatic CSS (not just AT)
- `ATFrameworkDefaults` now acts as facade for the Framework system
- Updated admin notice to mention both supported frameworks

## [0.0.10-beta] - 2025-12-12

### Added
- **Admin Instructions Page**: New WordPress admin menu "AT Style Guide" with comprehensive documentation
- **Admin Instructions Page**: Tab-based interface with Requirements, General, and element-specific tabs
- **Admin Instructions Page**: Built with Svelte 5 using WPEA framework components
- **General Tab**: Documentation on Nestable Elements and default child items behavior
- **General Tab**: CSS Architecture section explaining BEM naming and @layer for easy overrides
- **Colors Tab**: Detailed documentation for A11Y Badges toggle, Glossary, and Click-to-Copy features

### Changed
- All element CSS now uses `@layer atsg` for decorative styles, making overrides easier
- CSS deduplication: styles only load once even when multiple instances of same element on page

## [0.0.9-beta] - 2025-12-12

### Changed
- **Colors Element**: A11Y glossary large text sizes now shown in px (24px+/19px+ bold) instead of pt
- Added note about approximate px values at 96dpi

## [0.0.8-beta] - 2025-12-12

### Added
- **Colors Element**: A11Y Glossary with WCAG contrast standards, ratio explanations, and badge legend
- **Colors Element**: "Show A11Y Glossary" control to enable/disable glossary display
- Smooth reveal animation for A11Y glossary when toggle is enabled

### Fixed
- **Colors Element**: A11Y glossary now properly respects the show/hide control setting

## [0.0.7-beta] - 2025-12-12

### Added
- Computed values now rounded to 2 decimal places (font-size, spacing, radii, box-shadow)

### Fixed
- **Box Shadows & Radii**: Box backgrounds now visible on dark backgrounds using CSS variables
- **All Elements**: Replaced fixed hex colors with CSS variables (except A11Y contrast badges)

### Changed
- **Box Shadows Element**: Removed XS size from default items

## [0.0.6-beta] - 2025-12-12

### Added
- **Typography Element**: Sample Text control on parent to set default text for all child items
- **TypographyItem Element**: Sample text inheritance - items without custom text inherit from parent
- Standalone TypographyItems use fallback text when not inside a Typography parent

### Changed
- **TypographyItem Element**: Sample Text field now empty by default (inherits from parent)

## [0.0.5-beta] - 2025-12-12

### Added
- **Typography Element**: Item Background control with parent override for consistent styling
- **Typography Element**: Class control for sample text to apply custom CSS classes
- **All Parent Elements**: Base Font Size now defaults to `var(--at-text--s)` for consistent sizing

### Fixed
- **Spacing Element**: Bar Thickness control now properly applies in both horizontal and vertical layouts
- **Typography Element**: Border and border-radius from parent now apply correctly to items
- **Typography Element**: Sample text no longer inherits Base Font Size (uses `font-size: revert`)

### Changed
- **Typography Element**: Removed "Lead" from default typography items
- **Typography Element**: Default "Small" item now includes `text--xs` class

## [0.0.4-beta] - 2025-12-11

### Added
- **Buttons Element**: Rounded and Outline toggle switches to apply classes to all buttons
- **Mobile Responsive**: Typography table layout reverts to stacked below 768px
- **Mobile Responsive**: Buttons grid switches to 2 columns below 600px
- **Mobile Responsive**: Colors default layout switches to stacked below 600px
- **Mobile Responsive**: Spacing stacks vertically below 600px

### Fixed
- Button class names no longer wrap mid-word (each class wrapped in nowrap span)
- Buttons grid layout fixed after adding toolbar wrapper
- Removed grey background from Box Shadows container

### Changed
- Consistent label/value font sizing across all elements (label: 0.875rem, values: 0.75rem)
- BoxShadows value text increased from 0.625rem to 0.75rem

## [0.0.3-beta] - 2025-12-11

### Fixed
- ZIP packaging now uses forward slashes for Linux/Unix compatibility
- ZIP script no longer incorrectly excludes src/Plugin.php

## [0.0.2-beta] - 2025-12-11

### Added
- **Colors Element**: Multiple layout modes (Default Grid, Stacked, Compact, Compact Vertical)
- **Colors Element**: Parent-level override controls for display, variations, and style settings
- **Colors Element**: Dedicated Bricks flex controls (direction, justify-content, align-items)
- **Colors Element**: WCAG contrast ratio checker in color swatch context menu
- **Colors Element**: A11Y contrast badges on swatches (W/B indicators with pass/fail colors)
- **Colors Element**: Interactive toggle switch to show/hide A11Y badges (off by default)
- **ColorsItem Element**: Click-to-show context menu with copy functionality (var, hex, RGB, HSL, OKLCH)
- **ColorsItem Element**: Transparent color detection - hides contrast info for alpha colors
- **ColorsItem Element**: Separate controls for variant swatch size and base swatch width

### Fixed
- Swatch size override no longer breaks layout in stacked mode
- Variations override now properly targets columns using data-variant attributes

## [0.0.1-beta] - 2025-12-10

### Added
- Initial plugin structure with PSR-4 autoloading
- Bricks Builder integration with custom element registration
- Colors (Nestable) and ColorsItem elements
- Typography, Spacing, Radii, Box Shadows elements
- Advanced Themer color palette integration
- ATColors helper class for palette data access
- ATFrameworkDefaults for AT variable detection
