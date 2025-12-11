# Changelog

All notable changes to Advanced Themer Style Guide will be documented in this file.

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
