# CLAUDE.md – Advanced Themer Style Guide

## Required Reading

Before working on this project, you MUST read the following documentation file:

- **SVELTE5_IMPLEMENTATION.md** - Svelte 5 implementation details, runes system, WordPress integration patterns, and Vite build configuration

This file contains essential context about Svelte 5 patterns used in this project.

---

## Purpose

The **Advanced Themer Style Guide** plugin adds Svelte-based custom elements to the **Bricks Builder** editor to visually document and verify a site's design system, with a focus on setups using **Advanced Themer**.

It allows implementers to build live, on-page style guide layouts that reflect the actual CSS variables, Bricks theme settings, and Advanced Themer configuration used on the site.

- **Plugin Name:** Advanced Themer Style Guide
- **Description:** Adds Svelte based Elements to Bricks Builder for creating Style Guides based on Advanced Themer
- **PHP Namespace:** `AB\ATStyleGuide`
- **Constants Prefix:** `AT_STYLE_GUIDE_`
- **Textdomain (derived):** `advanced-themer-style-guide`
- **Admin functionality:** None (no dedicated settings pages initially)
- **Frontend / Builder functionality:** Bricks Builder elements for live style guides


## Functionality

### Overview

The plugin registers a set of custom Bricks Builder elements whose purpose is to render a comprehensive style guide for a site's design system. These elements will:

- Read actual CSS variables and computed styles
- Reflect real font stacks, spacing scales, radii, shadows, and color palettes
- Update responsively on resize where relevant (e.g. spacing, font sizes)
- Be composed using Bricks' **Nested Elements** where appropriate

All UI exposed to the user is via Bricks Builder element controls; there is deliberately **no separate WordPress admin settings UI** at this stage.

---

### Bricks Elements

#### 1. Styleguide Wrapper

A container element that:

- Enqueues any required **CSS** and **JS** assets for all style guide elements
- Provides a consistent wrapper for typography, spacing, radii, shadows, and color sections
- May provide global layout options (e.g. width, grid layout, section spacing) for the style guide page

**Key behaviors:**

- When placed on a page, it ensures all other style guide elements have their required scripts/styles loaded once.
- Intended as the top-level "Style Guide Page" wrapper.

---

#### 2. Typography Element

A typography layout displaying headings and body text in a structured, repeatable format.

**Features:**

- Renders a table or stacked layout of typography samples, e.g.:
  - H1 / H2 / H3 / H4 / H5 / H6
  - Body / Lead / Small / Meta text
- Each row includes:
  - A **sample text** (user-configurable or default sample)
  - **Font family** (calculated from applied CSS / computed styles)
  - **Font size** (in `px`, calculated and kept in sync on window resize)
- Supports mapping to underlying CSS variables / Bricks theme settings where possible.

**Behavior:**

- On render and on window resize:
  - The element calculates the computed font size for each sample and displays it in `px`.
  - The element reads the computed font family string and displays it.

---

#### 3. Spacing Element

A visual representation of the spacing scale used in the design system.

**Features per row:**

- A **bar** representing the visual space (e.g. height of the bar corresponds to spacing value)
- A **calculated value in `px`**, based on the current viewport size (for clamp-based or responsive spacing)
- The associated **CSS variable name** (e.g. `--at-space-m`, `--at-gap-xl`)

**Behavior:**

- For each configured spacing token:
  - Reads the value from CSS (including clamp expressions).
  - Computes the current effective pixel value and displays it.
- Updates on **window resize** to reflect responsive spacing changes.

---

#### 4. Radii Element

Displays box samples showing border radius tokens.

**Features:**

- A grid/list of boxes, each styled with a particular radius variable.
- Each box:
  - Uses a border radius from a variable (e.g. `--at-radius-s`).
  - Shows the **variable name** centered in the box (e.g. `--at-radius-l`).
- Optional display of computed `px` value.

**Behavior:**

- Reads CSS variables for radii and applies them to each sample box.
- May support grouping (small / medium / large / pill, etc.), depending on configuration.

---

#### 5. Box Shadows Element

Visually represents the site's shadow tokens.

**Features:**

- A set of boxes similar to the Radii element, but demonstrating **box-shadow** variables.
- For each shadow token:
  - A card/box with the shadow applied.
  - The **variable name** displayed (e.g. `--at-shadow-soft-xl`).
  - Optional textual representation of the shadow definition (offset/blur/spread).

**Behavior:**

- Reads the CSS variable for each shadow token and applies it to the preview box.
- Maintains consistent background and contrast to make shadows clearly visible.

---

#### 6. Colours Element

Displays color palettes and variations in a structured layout, sourced from Bricks and Advanced Themer.

**Default color sets:**

- Primary
- Secondary
- Neutral
- Black
- White

**Extended color selection:**

- Users can select **additional colors** from Bricks color palettes where the color key/name begins with `at-`.
  - Example: `at-primary`, `at-accent-1`, `at-neutral-900`, etc.

**Layout (using Bricks Nested Elements):**

- The element is composed using Bricks **Nested Elements** to handle complex layout:
  - **Left side:** A full-height **primary color swatch** representing the base color.
  - **Right side:** Columns for **variation sets**, currently:
    - `Light`
    - `Dark`
    - `Transparent`
  - For each variation set:
    - Default to **6 variations** (e.g. Light 1–6, Dark 1–6, Transparent 1–6).
    - Each variation displayed as a swatch with:
      - Visual color block
      - Label / variable name (e.g. `--at-primary-l3`, `--at-primary-d2`, `--at-primary-t4`)
      - Optional hex/oklch display if desired.

**Behavior:**

- Resolves color values by reading:
  - Bricks color palette data
  - Underlying CSS variables, especially those beginning with `at-`
- Generates derived variations (if implemented) or maps to pre-defined tokens for light/dark/transparent sets.

---

### Admin Functionality

- **None at this stage**.
- No dedicated WordPress admin menu, settings pages, or configuration panels.
- All configuration is intended to occur:
  - Via Bricks Builder element controls
  - Via CSS variables, Bricks theme settings, and Advanced Themer configuration

Future enhancements may add an optional admin "Preview Style Guide" link or minimal config, but the baseline assumption is **builder-only UI**.

---

## Code Style Guidelines

### General

1. All JavaScript, CSS, and third-party libraries must be **downloaded and served locally**.
   - No CDN dependencies in production.
   - Any build tooling should bundle everything into plugin-local assets.

---

### PHP Conventions

1. **Namespace**
   - All PHP classes must use the namespace:
     `AB\ATStyleGuide`
   - PSR-4 autoloading must map this namespace to the plugin's `src/` directory (or equivalent).

2. **Loading (Autoloading)**
   - Use **PSR-4 Autoloading** via Composer.
   - No manual `require` or `include` for classes except the Composer autoload bootstrap.

3. **Class Structure**
   - Classes that integrate with WordPress hooks should generally be `final`.
   - Prefer static methods for WordPress hook registration where appropriate, for example:
     - `StyleGuide_Plugin::init()`
     - `Bricks_Elements_Registrar::init()`
   - Group responsibilities logically:
     - Bootstrapping / plugin lifecycle
     - Bricks element registration
     - REST API (if needed)
     - Asset registration/enqueueing

4. **Security**
   - Every PHP file that can be accessed directly must begin with:
     ```php
     defined('ABSPATH') || exit;
     ```
   - Avoid echoing unsanitized output.

5. **Sanitization**
   - Use WordPress sanitization functions extensively:
     - `sanitize_text_field()`
     - `esc_html()`, `esc_attr()`, `esc_url()`
     - `wp_kses_post()` where richer HTML is allowed
   - Sanitize all user-supplied or database-derived data before output.

6. **Nonces**
   - Use WordPress nonces on all forms and AJAX/REST actions that modify data.
   - For REST API endpoints, define and validate a **custom nonce** field alongside any authentication you use.

7. **Constants**
   - Define plugin paths and URLs as constants using the **constants prefix** `AT_STYLE_GUIDE_`, for example:
     - `AT_STYLE_GUIDE_PLUGIN_PATH`
     - `AT_STYLE_GUIDE_PLUGIN_URL`
     - `AT_STYLE_GUIDE_VERSION`
   - Use these constants consistently for asset loading and includes.

---

### Method Patterns

- `init()`
  - Static initializer methods to register:
    - WordPress hooks
    - Bricks elements
    - Asset registration
    - REST routes (if used)

- `render()`
  - Methods that output HTML for Bricks elements or other front-end components.
  - All output must be escaped appropriately.

- `handle_*()`
  - Methods that process requests (AJAX, REST, form submissions).
  - Must validate:
    - Nonces
    - Capabilities
    - Input parameters

- Private helper methods may be prefixed with an underscore when appropriate, e.g. `_get_spacing_tokens()`, `_compute_clamp_value()`.

- Always perform:
  - Parameter validation
  - Type checking
  - Early returns on invalid input

---

### JavaScript Conventions

1. **Local Libraries Only**
   - All JS libraries must be bundled and served from within the plugin.

2. **AlpineJS Usage**
   - Where AlpineJS is useful for small interactions (e.g. toggling sections), it may be used.
   - Initialize code with the `init` event (e.g. Alpine `x-init`), keeping logic encapsulated.

3. **Svelte**
   - Use **Svelte v5** for the main interactive style guide components, particularly:
     - Bricks-side UI inside the editor panel
     - In-canvas interactive behavior (live updates on resize, etc.)
   - Svelte components should be compiled to production-ready JS bundles served locally by the plugin.

4. **ES6 Only**
   - Use modern ES6+ JavaScript.
   - **Never use jQuery** for new code.
   - Prefer modules and clear separation of concerns.

5. **Admin Interfaces**
   - If any admin interfaces are introduced in future:
     - Use JS/CSS-based tab switching (no full page reloads).
     - Auto-save settings on change; do not rely on a "Save" button.
     - Provide a status indicator for "saving" / "saved" state.

---

### CSS

1. **@layer Usage**
   - For **frontend-generated CSS** (style guide layouts), use `@layer` to namespace and control specificity.
   - **Do not** use `@layer` for admin area CSS.

2. **Nested CSS**
   - Use nested CSS (via PostCSS or appropriate tooling) where it aids readability and structure.

3. **Container Queries Preferred**
   - Favor **Container Queries** over global media queries where possible.
   - This is especially relevant for style guide components that live within Bricks layouts of varying widths.

---

### Security Practices

Where the plugin exposes REST API endpoints or interactive features:

- **Rate Limiting**
  - Implement rate limiting (e.g. 30 requests per 60 seconds per IP) for sensitive endpoints.

- **Same-Origin Enforcement**
  - Enforce same-origin checks in REST API logic.
  - Reject cross-site requests unless explicitly needed and safely handled.

- **Nonce Validation**
  - Require and validate nonces for all endpoints that change data or reveal non-public information.

- **Sanitization**
  - Sanitize all user inputs (including query parameters, POST data, and JSON bodies) before use.

---

### WordPress Integration

- Follow **WordPress Coding Standards** for PHP, JS, and CSS as closely as possible.
- Use WordPress APIs extensively where relevant:
  - Settings API (if/when settings are introduced)
  - REST API (for Svelte-based UIs if needed)
  - Transients / Options APIs for caching
- Make the plugin **translation-ready**:
  - Wrap strings in `__()`, `_e()`, `_x()`, etc. with textdomain `advanced-themer-style-guide`.
- Integrate cleanly with Bricks Builder APIs for:
  - Custom element registration
  - Nested Elements definition
  - Control panels for element options
- Ensure **multisite compatibility**:
  - No assumptions that options or data are global across network.
  - Respect site-specific contexts and `is_multisite()` where relevant.

---

### Development Features

- **CodeMirror 6 Integration (Future/Optional)**
  - If a CSS editor is introduced in admin, use CodeMirror 6 for CSS editing with:
    - Syntax highlighting
    - Local assets
  - Provide a textarea fallback if CodeMirror cannot load.

- **Composer Autoloading (PSR-4)**
  - Use Composer for autoloading all PHP classes:
    - Namespace: `AB\ATStyleGuide`
    - PSR-4 mapping in `composer.json`

- **Graceful Fallbacks**
  - If Alpine.js or Svelte fail to load:
    - Ensure the page still renders basic content without breaking.
  - Provide non-JS fallbacks for critical information if possible.

- **Error Handling & Validation**
  - Fail gracefully when:
    - Bricks is not active
    - Required Advanced Themer variables are missing
    - Expected palettes or tokens cannot be resolved
  - Log meaningful errors (using `error_log` or a custom logger) in development scenarios, but avoid noisy logs in production environments.

---

## Bricks Builder Reference

### Documentation
- Nestable Elements Guide: https://academy.bricksbuilder.io/article/nestable-elements/

### Source Code Reference
For understanding how Bricks Builder implements nestable elements, refer to the Bricks source code at:

`C:\Users\Alan.Blair\LIBRARIES\BricksBuilder\bricks`

Study these nestable element implementations as reference:
- **Accordion (Nestable)** - `includes/elements/accordion-nested.php`
- **Slider (Nestable)** - `includes/elements/slider-nested.php`
- **Tabs (Nestable)** - `includes/elements/tabs-nested.php`

These examples demonstrate the patterns and structure for creating custom nestable elements in Bricks Builder.

---

## Advanced Themer Integration

### Accessing AT Color Data

The primary method to access Advanced Themer colors:

```php
$palettes = get_option('bricks_color_palette', []);
```

### Color Palette Structure

Each palette in the array contains:

```php
[
    'id'     => 'brxc_color_12345678',  // Unique palette ID
    'name'   => 'Primary Colors',       // Palette display name
    'prefix' => 'primary',              // CSS variable prefix
    'status' => 'enabled',              // 'enabled' or 'disabled'
    'colors' => [
        [
            'name'          => 'blue',
            'id'            => 'brxc_color_blue',
            'raw'           => 'var(--primary-blue)',      // CSS variable reference
            'hex'           => '#0066FF',                   // Hex value (when available)
            'rawValue'      => [
                'light' => '#0066FF',                      // Light mode value
                'dark'  => '#003366'                       // Dark mode value
            ],
            'shadeChildren' => true,                       // Has variations
        ]
    ]
]
```

### Color Variations/Shades

When `shadeChildren` is enabled on a color, AT generates these variations:
- **Light shades:** `l-1`, `l-2`, `l-3`, `l-4`, `l-5`, `l-6`
- **Dark shades:** `d-1`, `d-2`, `d-3`, `d-4`, `d-5`, `d-6`

### Available Filter Hook

```php
// Modify palette settings before processing
apply_filters('at/color_palettes/override_palette_settings', $palette);
```

### Key AT Classes

- `AT__Global_Colors::load_colors_variables_on_frontend()` - Returns [light_css, dark_css, gutenberg_colors]
- `AT__Global_Colors::load_converted_colors_variables_on_frontend()` - Returns CSS with HSL values

### Storage Locations

- **WordPress Option:** `bricks_color_palette`
- **Custom Post Type:** `brxc_color_palette` (not REST exposed)

### Source Code Reference

For understanding Advanced Themer internals, refer to:

`C:\Users\Alan.Blair\LIBRARIES\wordpress\wp-content\plugins\bricks-advanced-themer`

Key files:
- `classes/global_colors.php` - Main color management class
- `classes/acf.php` - ACF field definitions (line 1308+)
- `classes/ajax.php` - AJAX handlers for import/export
