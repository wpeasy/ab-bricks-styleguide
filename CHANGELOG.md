# Changelog

All notable changes to Advanced Themer Style Guide will be documented in this file.

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
