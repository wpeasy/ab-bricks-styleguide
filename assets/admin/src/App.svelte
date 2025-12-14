<script lang="ts">
  import Tabs from '$lib/Tabs.svelte';
  import Card from '$lib/Card.svelte';
  import Alert from '$lib/Alert.svelte';

  // Props passed from PHP via wp_localize_script
  interface Props {
    activeFramework?: 'at' | 'acss';
    frameworkName?: string;
  }

  let { activeFramework = 'at', frameworkName = 'Advanced Themer' }: Props = $props();

  // Reactive check for which framework
  const isAT = $derived(activeFramework === 'at');
  const isACSS = $derived(activeFramework === 'acss');

  // Copy feedback state
  let copiedVar = $state<string | null>(null);
  let copiedAll = $state<string | null>(null);

  // Copy single variable to clipboard
  async function copyVariable(varName: string) {
    await navigator.clipboard.writeText(varName);
    copiedVar = varName;
    setTimeout(() => copiedVar = null, 1500);
  }

  // Copy all variables as a CSS block
  async function copyAllVariables(elementName: string, variables: string[]) {
    const cssBlock = `.your-custom-class {\n${variables.map(v => `  ${v}: ;`).join('\n')}\n}`;
    await navigator.clipboard.writeText(cssBlock);
    copiedAll = elementName;
    setTimeout(() => copiedAll = null, 1500);
  }

  // CSS Override Variables for each element
  const typographyItemVars = [
    '--bsg-typography-item-label-color',
    '--bsg-typography-item-label-font-size',
    '--bsg-typography-item-label-font-weight',
    '--bsg-typography-item-label-text-transform',
    '--bsg-typography-item-label-letter-spacing',
    '--bsg-typography-item-meta-font-size',
    '--bsg-typography-item-meta-color',
    '--bsg-typography-item-meta-bg',
    '--bsg-typography-item-meta-text-color',
    '--bsg-typography-item-meta-label-color'
  ];

  const typographyVars = [
    '--bsg-typography-placeholder-padding',
    '--bsg-typography-placeholder-bg',
    '--bsg-typography-placeholder-border-color',
    '--bsg-typography-placeholder-color'
  ];

  const spacingItemVars = [
    '--bsg-spacing-item-label-font-weight',
    '--bsg-spacing-item-label-font-size',
    '--bsg-spacing-item-label-color',
    '--bsg-spacing-item-variable-font-size',
    '--bsg-spacing-item-variable-color',
    '--bsg-spacing-item-variable-bg',
    '--bsg-spacing-item-bar-color',
    '--bsg-spacing-item-bar-radius',
    '--bsg-spacing-item-value-font-size',
    '--bsg-spacing-item-value-color',
    '--bsg-spacing-item-value-label-color'
  ];

  const spacingVars = [
    '--bsg-spacing-placeholder-padding',
    '--bsg-spacing-placeholder-bg',
    '--bsg-spacing-placeholder-border-color',
    '--bsg-spacing-placeholder-color'
  ];

  const radiiItemVars = [
    '--bsg-radii-item-box-size',
    '--bsg-radii-item-box-bg',
    '--bsg-radii-item-box-border-color',
    '--bsg-radii-item-label-font-weight',
    '--bsg-radii-item-label-font-size',
    '--bsg-radii-item-label-color',
    '--bsg-radii-item-variable-font-size',
    '--bsg-radii-item-variable-color',
    '--bsg-radii-item-variable-bg',
    '--bsg-radii-item-value-font-size',
    '--bsg-radii-item-value-color',
    '--bsg-radii-item-value-label-color'
  ];

  const radiiVars = [
    '--bsg-radii-placeholder-padding',
    '--bsg-radii-placeholder-bg',
    '--bsg-radii-placeholder-border-color',
    '--bsg-radii-placeholder-color'
  ];

  const shadowsItemVars = [
    '--bsg-shadows-item-box-size',
    '--bsg-shadows-item-box-bg',
    '--bsg-shadows-item-box-border-color',
    '--bsg-shadows-item-box-radius',
    '--bsg-shadows-item-label-font-weight',
    '--bsg-shadows-item-label-font-size',
    '--bsg-shadows-item-label-color',
    '--bsg-shadows-item-variable-font-size',
    '--bsg-shadows-item-variable-color',
    '--bsg-shadows-item-variable-bg',
    '--bsg-shadows-item-value-font-size',
    '--bsg-shadows-item-value-color',
    '--bsg-shadows-item-value-label-color'
  ];

  const shadowsVars = [
    '--bsg-shadows-placeholder-padding',
    '--bsg-shadows-placeholder-bg',
    '--bsg-shadows-placeholder-border-color',
    '--bsg-shadows-placeholder-color'
  ];

  const buttonsItemVars = [
    '--bsg-buttons-item-description-font-weight',
    '--bsg-buttons-item-description-font-size',
    '--bsg-buttons-item-description-color',
    '--bsg-buttons-item-classes-font-size',
    '--bsg-buttons-item-classes-color',
    '--bsg-buttons-item-classes-bg'
  ];

  const buttonsVars = [
    '--bsg-buttons-toggle-switch-width',
    '--bsg-buttons-toggle-switch-height',
    '--bsg-buttons-toggle-switch-bg',
    '--bsg-buttons-toggle-switch-active-bg',
    '--bsg-buttons-toggle-label-font-size',
    '--bsg-buttons-toggle-label-color'
  ];

  const colorsItemVars = [
    // Placeholder
    '--bsg-colors-item-placeholder-padding',
    '--bsg-colors-item-placeholder-bg',
    '--bsg-colors-item-placeholder-border-color',
    '--bsg-colors-item-placeholder-color',
    // Label Typography
    '--bsg-colors-item-label-font-family',
    '--bsg-colors-item-label-font-size',
    '--bsg-colors-item-label-font-weight',
    '--bsg-colors-item-label-line-height',
    '--bsg-colors-item-label-letter-spacing',
    '--bsg-colors-item-label-text-transform',
    '--bsg-colors-item-label-color',
    // Menu Header Typography
    '--bsg-colors-item-menu-header-font-family',
    '--bsg-colors-item-menu-header-font-size',
    '--bsg-colors-item-menu-header-font-weight',
    '--bsg-colors-item-menu-header-line-height',
    '--bsg-colors-item-menu-header-letter-spacing',
    '--bsg-colors-item-menu-header-text-transform',
    '--bsg-colors-item-menu-header-color',
    // Menu Code Typography
    '--bsg-colors-item-menu-code-font-family',
    '--bsg-colors-item-menu-code-font-size',
    '--bsg-colors-item-menu-code-font-weight',
    '--bsg-colors-item-menu-code-line-height',
    '--bsg-colors-item-menu-code-letter-spacing',
    '--bsg-colors-item-menu-code-color',
    // Menu Button Typography
    '--bsg-colors-item-menu-btn-font-family',
    '--bsg-colors-item-menu-btn-font-size',
    '--bsg-colors-item-menu-btn-font-weight',
    '--bsg-colors-item-menu-btn-line-height',
    '--bsg-colors-item-menu-btn-letter-spacing',
    '--bsg-colors-item-menu-btn-text-transform',
    // Contrast Label Typography
    '--bsg-colors-item-contrast-label-font-family',
    '--bsg-colors-item-contrast-label-font-size',
    '--bsg-colors-item-contrast-label-font-weight',
    '--bsg-colors-item-contrast-label-line-height',
    '--bsg-colors-item-contrast-label-letter-spacing',
    '--bsg-colors-item-contrast-label-color'
  ];

  const colorsVars = [
    '--bsg-colors-toggle-switch-width',
    '--bsg-colors-toggle-switch-height',
    '--bsg-colors-toggle-switch-bg',
    '--bsg-colors-toggle-switch-active-bg',
    '--bsg-colors-toggle-label-font-size',
    '--bsg-colors-toggle-label-color',
    '--bsg-colors-glossary-bg',
    '--bsg-colors-glossary-title-color',
    '--bsg-colors-glossary-text-color'
  ];

  // Tab content snippets must be defined inline
  const tabs = [
    { id: 'requirements', label: 'Requirements', content: requirementsContent },
    { id: 'general', label: 'General', content: generalContent },
    { id: 'colors', label: 'Colors', content: colorsContent },
    { id: 'typography', label: 'Typography', content: typographyContent },
    { id: 'spacing', label: 'Spacing', content: spacingContent },
    { id: 'radii', label: 'Radii', content: radiiContent },
    { id: 'box-shadows', label: 'Box Shadows', content: boxShadowsContent },
    { id: 'buttons', label: 'Buttons', content: buttonsContent }
  ];
</script>

{#snippet cssVariablesSection(title: string, elementName: string, variables: string[])}
  <div class="bsg-instructions__section">
    <h4>{title}</h4>
    <p>Override these CSS variables in your custom CSS to customize the element's appearance:</p>
    <div class="bsg-var-list">
      <div class="bsg-var-list__header">
        <span class="bsg-var-list__title">CSS Variables</span>
        <button
          class="bsg-var-list__copy-all"
          onclick={() => copyAllVariables(elementName, variables)}
        >
          {copiedAll === elementName ? '✓ Copied!' : 'Copy All'}
        </button>
      </div>
      <ul class="bsg-var-list__items">
        {#each variables as varName}
          <li class="bsg-var-list__item">
            <code class="bsg-var-list__code">{varName}</code>
            <button
              class="bsg-var-list__copy"
              onclick={() => copyVariable(varName)}
            >
              {copiedVar === varName ? '✓' : 'Copy'}
            </button>
          </li>
        {/each}
      </ul>
    </div>
  </div>
{/snippet}

{#snippet requirementsContent()}
  <div class="bsg-instructions__content">
    <Card title="Requirements">
      <Alert variant="success">
        <strong>Active Framework:</strong> {frameworkName}
      </Alert>

      {#if isACSS}
        <Alert variant="warning">
          <strong>Important:</strong> Some ACSS options may be disabled in your settings. For Style Guide elements to work properly, ensure that the required styles (typography scale, spacing scale, colors, etc.) are enabled in your Automatic CSS dashboard.
        </Alert>
      {/if}

      {#if isAT}
        <div class="bsg-instructions__section">
          <h4>Advanced Themer Variables</h4>
          <p>The Style Guide elements read CSS variables defined by Advanced Themer. Ensure you have configured:</p>
          <ul>
            <li><code>--at-primary</code>, <code>--at-secondary</code>, <code>--at-neutral</code> - Core color palette</li>
            <li><code>--at-text--*</code> - Typography scale variables (2xs, xs, s, m, l, xl, 2xl, 3xl)</li>
            <li><code>--at-space--*</code> - Spacing scale variables (3xs, 2xs, xs, s, m, l, xl, 2xl, 3xl)</li>
            <li><code>--at-radius--*</code> - Border radius variables (xs, s, m, l)</li>
            <li><code>--at-shadow--*</code> - Box shadow variables (s, m, l, xl, 2xl)</li>
          </ul>
        </div>

        <div class="bsg-instructions__section">
          <h4>Color Shades</h4>
          <p>Advanced Themer generates light and dark shades for each color:</p>
          <ul>
            <li><strong>Light shades:</strong> <code>-l-1</code> through <code>-l-6</code> (e.g., <code>--at-primary-l-3</code>)</li>
            <li><strong>Dark shades:</strong> <code>-d-1</code> through <code>-d-6</code> (e.g., <code>--at-primary-d-2</code>)</li>
            <li><strong>Transparent:</strong> <code>-t-1</code> through <code>-t-6</code> (e.g., <code>--at-primary-t-4</code>)</li>
          </ul>
        </div>
      {:else}
        <div class="bsg-instructions__section">
          <h4>Automatic CSS Variables</h4>
          <p>The Style Guide elements read CSS variables defined by Automatic CSS. Ensure you have configured:</p>
          <ul>
            <li><code>--primary</code>, <code>--secondary</code>, <code>--neutral</code> - Core color palette</li>
            <li><code>--text-*</code> - Typography scale variables (xs, s, m, l, xl, xxl)</li>
            <li><code>--space-*</code> - Spacing scale variables (xs, s, m, l, xl, xxl)</li>
            <li><code>--radius-*</code> - Border radius variables (xs, s, m, l, xl, xxl)</li>
            <li><code>--box-shadow-*</code> - Box shadow variables (m, l, xl)</li>
          </ul>
        </div>

        <div class="bsg-instructions__section">
          <h4>Color Shades</h4>
          <p>Automatic CSS uses named shades for each color:</p>
          <ul>
            <li><strong>Light shades:</strong> <code>-ultra-light</code>, <code>-light</code>, <code>-semi-light</code></li>
            <li><strong>Dark shades:</strong> <code>-semi-dark</code>, <code>-dark</code>, <code>-ultra-dark</code></li>
            <li><strong>Hover:</strong> <code>-hover</code> (e.g., <code>--primary-hover</code>)</li>
            <li><strong>Transparent:</strong> <code>-trans-*</code> (e.g., <code>--primary-trans-50</code>)</li>
          </ul>
        </div>
      {/if}

      {#if isAT}
        <div class="bsg-instructions__section">
          <h4>Bricks Theme Styles</h4>
          <p>The Button element uses Bricks' built-in button classes:</p>
          <ul>
            <li><code>.bricks-button</code> - Base button class</li>
            <li><code>.bricks-color-*</code> - Color variants (primary, secondary, dark, light, etc.)</li>
            <li><code>.sm</code>, <code>.md</code>, <code>.lg</code>, <code>.xl</code> - Size classes</li>
            <li><code>.outline</code> - Outline variant</li>
            <li><code>.round</code>, <code>.square</code>, <code>.circle</code> - Shape variants</li>
          </ul>
        </div>
      {:else}
        <div class="bsg-instructions__section">
          <h4>ACSS Button Classes</h4>
          <p>The Button element uses Automatic CSS button classes:</p>
          <ul>
            <li><code>.btn</code> - Base button class</li>
            <li><code>.btn--primary</code>, <code>.btn--primary-dark</code>, <code>.btn--primary-light</code> - Primary variants</li>
            <li><code>.btn--secondary</code>, <code>.btn--secondary-dark</code>, <code>.btn--secondary-light</code> - Secondary variants</li>
            <li><code>.btn--s</code>, <code>.btn--m</code>, <code>.btn--l</code>, <code>.btn--xl</code> - Size classes</li>
            <li><code>.btn--outline</code> - Outline variant (combine with color class)</li>
          </ul>
          <p><em>Note: ACSS does not have a rounded/pill button class.</em></p>
        </div>
      {/if}
    </Card>
  </div>
{/snippet}

{#snippet generalContent()}
  <div class="bsg-instructions__content">
    <Card title="General Usage">
      <div class="bsg-instructions__section">
        <h4>Nestable Elements with Default Children</h4>
        <p>All Style Guide elements use Bricks' <strong>Nestable Elements</strong> pattern. When you add a parent element (e.g., Colors, Typography, Spacing), it automatically creates a set of default child items based on your {frameworkName} configuration.</p>
        <ul>
          <li><strong>Colors</strong> - Creates Color Items for each root color in your {isAT ? 'AT' : 'ACSS'} palette</li>
          <li><strong>Typography</strong> - Creates Typography Items for common heading and text styles</li>
          <li><strong>Spacing</strong> - Creates Spacing Items for your spacing scale tokens</li>
          <li><strong>Radii</strong> - Creates Radii Items for your border radius tokens</li>
          <li><strong>Box Shadows</strong> - Creates Box Shadow Items for your shadow tokens</li>
          <li><strong>Buttons</strong> - Creates Button Items showing color and size combinations</li>
        </ul>
        <p>You can add, remove, or reorder child items as needed. The defaults are just a starting point.</p>
      </div>

      <div class="bsg-instructions__section">
        <h4>Using Child Items Independently</h4>
        <p>While child items are designed to work within their parent containers, they can also be used independently:</p>
        <ul>
          <li>Add a single <strong>Color Item</strong> to showcase a specific color anywhere on your page</li>
          <li>Use <strong>Typography Items</strong> individually to demonstrate specific text styles</li>
          <li>Place <strong>Button Items</strong> as standalone examples in documentation</li>
        </ul>
        <p>Independent child items inherit default styling but won't have access to parent-level override controls or toolbar features.</p>
      </div>
    </Card>

    <Card title="CSS Architecture">
      <div class="bsg-instructions__section">
        <h4>BEM Naming Convention</h4>
        <p>All Style Guide elements follow the <strong>BEM (Block Element Modifier)</strong> naming methodology for predictable, maintainable CSS:</p>
        <ul>
          <li><strong>Block:</strong> <code>.bsg-colors</code>, <code>.bsg-typography</code>, <code>.bsg-spacing</code></li>
          <li><strong>Element:</strong> <code>.bsg-colors__toolbar</code>, <code>.bsg-colors-item__swatch</code></li>
          <li><strong>Modifier:</strong> <code>.bsg-colors--compact</code>, <code>.bsg-buttons--grid</code></li>
        </ul>
        <p>The <code>bsg-</code> prefix (Bricks Style Guide) prevents conflicts with other plugins and themes.</p>
      </div>

      <div class="bsg-instructions__section">
        <h4>CSS @layer for Easy Overrides</h4>
        <p>Decorative styles are wrapped in <code>@layer bsg</code>, making them easy to override without specificity battles:</p>
        <div class="bsg-instructions__code-block">
          <code>/* Plugin styles use @layer */<br>
@layer bsg &#123;<br>
&nbsp;&nbsp;.bsg-colors-item__label &#123;<br>
&nbsp;&nbsp;&nbsp;&nbsp;font-weight: 600;<br>
&nbsp;&nbsp;&#125;<br>
&#125;<br><br>
/* Your overrides win automatically */<br>
.bsg-colors-item__label &#123;<br>
&nbsp;&nbsp;font-weight: 400;<br>
&nbsp;&nbsp;text-transform: uppercase;<br>
&#125;</code>
        </div>
        <p>Critical layout styles (display, flex, grid) remain outside the layer to ensure proper rendering.</p>
      </div>

      <div class="bsg-instructions__section">
        <h4>Framework CSS Variables</h4>
        <p>Elements use {isAT ? 'AT' : 'ACSS'} CSS variables with fallback values, ensuring graceful degradation:</p>
        {#if isAT}
          <ul>
            <li><code>var(--at-space--m, 1rem)</code> - Spacing with fallback</li>
            <li><code>var(--at-radius--m, 8px)</code> - Radius with fallback</li>
            <li><code>var(--at-neutral-d-2, #6b7280)</code> - Colors with fallback</li>
          </ul>
        {:else}
          <ul>
            <li><code>var(--space-m, 1rem)</code> - Spacing with fallback</li>
            <li><code>var(--radius-m, 8px)</code> - Radius with fallback</li>
            <li><code>var(--neutral-dark, #6b7280)</code> - Colors with fallback</li>
          </ul>
        {/if}
      </div>

      <div class="bsg-instructions__section">
        <h4>CSS Override Variables</h4>
        <p>Each element uses a <strong>local scope pattern</strong> with public override variables. This makes customization simple without fighting specificity:</p>
        <div class="bsg-instructions__code-block">
          <code>/* How it works internally */<br>
.bsg-typography-item &#123;<br>
&nbsp;&nbsp;/* Settings block defines local variables */<br>
&nbsp;&nbsp;--_label-color: var(--bsg-typography-item-label-color, #6b7280);<br>
&nbsp;&nbsp;--_label-font-size: var(--bsg-typography-item-label-font-size, 0.75em);<br>
&#125;<br>
.bsg-typography-item__label &#123;<br>
&nbsp;&nbsp;/* Rules use local variables */<br>
&nbsp;&nbsp;color: var(--_label-color);<br>
&nbsp;&nbsp;font-size: var(--_label-font-size);<br>
&#125;</code>
        </div>
        <p>To override, simply set the public variable (prefixed with <code>--bsg-</code>) in your CSS:</p>
        <div class="bsg-instructions__code-block">
          <code>/* Your custom styles */<br>
.bsg-typography-item &#123;<br>
&nbsp;&nbsp;--bsg-typography-item-label-color: #1e40af;<br>
&nbsp;&nbsp;--bsg-typography-item-label-font-size: 0.875em;<br>
&#125;<br><br>
/* Or scope to a specific container */<br>
.my-style-guide .bsg-typography-item &#123;<br>
&nbsp;&nbsp;--bsg-typography-item-label-color: var(--at-primary);<br>
&#125;</code>
        </div>
        <p>See each element's tab for the complete list of override variables with click-to-copy functionality.</p>
      </div>

      <div class="bsg-instructions__section">
        <h4>Override Methods (Best to Least Preferred)</h4>
        <ol>
          <li><strong>CSS Variables</strong> - Set <code>--bsg-*</code> variables (cleanest, most maintainable)</li>
          <li><strong>Direct CSS</strong> - Target BEM classes outside <code>@layer</code> (automatic specificity win)</li>
          <li><strong>Bricks Controls</strong> - Use element style controls in the builder (inline styles)</li>
        </ol>
      </div>
    </Card>

    <Card title="Important Notes">
      <div class="bsg-instructions__section">
        <h4>Base Font Size Control</h4>
        <p>Each parent element includes a <strong>Base Font Size</strong> setting. Child elements use <code>em</code> units relative to this base, allowing you to scale the entire style guide proportionally.</p>
      </div>

      <div class="bsg-instructions__section">
        <h4>Responsive Behavior</h4>
        <p>Style Guide elements are responsive by default:</p>
        <ul>
          <li>Grid layouts adjust columns on smaller screens</li>
          <li>Spacing and typography values update when using <code>clamp()</code> expressions</li>
          <li>Mobile breakpoints switch to stacked layouts where appropriate</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>Builder vs Frontend</h4>
        <p>Elements behave identically in the Bricks Builder and on the frontend. JavaScript features (like click-to-copy) work in both contexts, allowing you to test functionality while editing.</p>
      </div>

      <div class="bsg-instructions__section">
        <h4>Performance</h4>
        <p>CSS is output inline with each element and deduplicated automatically. If the same element appears multiple times on a page, styles are only loaded once.</p>
      </div>
    </Card>
  </div>
{/snippet}

{#snippet colorsContent()}
  <div class="bsg-instructions__content">
    <Card title="Colors Element">
      <p>The <strong>Colors (Nestable)</strong> element displays your color palette with light, dark, and transparent variations, featuring accessibility testing and click-to-copy functionality.</p>

      <div class="bsg-instructions__section">
        <h4>Structure</h4>
        <ul>
          <li><strong>Colors</strong> - Parent container element with toolbar and glossary</li>
          <li><strong>Colors Item</strong> - Individual color row showing base color + variations</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>A11Y Badges Toggle</h4>
        <p>The parent Colors element includes an <strong>A11Y Badges</strong> toggle switch in the toolbar:</p>
        <ul>
          <li>When enabled, displays WCAG contrast badges on each color swatch</li>
          <li>Badges show <strong>W</strong> (white text contrast) and <strong>B</strong> (black text contrast)</li>
          <li>Color-coded: <span style="color: var(--wpea-color--success);">Green</span> = AAA/AA pass, <span style="color: var(--wpea-color--warning, #f59e0b);">Orange</span> = AA Large only, <span style="color: var(--wpea-color--danger);">Red</span> = Fail</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>A11Y Glossary</h4>
        <p>When A11Y Badges are enabled and "Show A11Y Glossary" is checked in settings, an expandable glossary appears explaining:</p>
        <ul>
          <li><strong>WCAG Contrast Standards</strong> - Overview of accessibility guidelines</li>
          <li><strong>Contrast Ratios</strong> - AAA (7:1+), AA (4.5:1+), AA Large (3:1+) thresholds</li>
          <li><strong>Badge Legend</strong> - Visual guide to badge colors and meanings</li>
          <li><strong>W/B Explanation</strong> - What the white and black text badges represent</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>Click-to-Copy Context Menu</h4>
        <p>Clicking any color swatch opens a context menu with:</p>
        <ul>
          <li><strong>CSS Variable</strong> - Click to copy <code>var({isAT ? '--at-primary' : '--primary'})</code> format</li>
          <li><strong>Copy Hex</strong> - Copy the computed hex value (e.g., <code>#3b82f6</code>)</li>
          <li><strong>Copy RGB</strong> - Copy RGB format (e.g., <code>rgb(59, 130, 246)</code>)</li>
          <li><strong>Copy HSL</strong> - Copy HSL format (e.g., <code>hsl(217, 91%, 60%)</code>)</li>
          <li><strong>Copy OKLCH</strong> - Copy OKLCH format for modern color spaces</li>
          <li><strong>Contrast Checker</strong> - Shows exact contrast ratios against white and black text</li>
        </ul>
        <p>A visual "Copied!" confirmation appears after copying any value.</p>
      </div>

      <div class="bsg-instructions__section">
        <h4>Layout Modes</h4>
        <p>The parent Colors element supports different layout modes:</p>
        <ul>
          <li><strong>Default (Grid)</strong> - Base color on left, variations in columns to the right</li>
          <li><strong>Stacked (Vertical)</strong> - Base color on top, variations in horizontal rows below</li>
          <li><strong>Compact</strong> - Smaller swatches with labels appearing on hover</li>
          <li><strong>Compact Vertical</strong> - Combines compact sizing with vertical stacking</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>Colors Item Settings</h4>
        <ul>
          <li><strong>Select Color</strong> - Choose from {isAT ? 'Advanced Themer Color Manager' : 'Automatic CSS'} palette</li>
          <li><strong>Variation Count</strong> - Number of variations per column (1-6)</li>
          <li><strong>Hide Dark/Light/Transparency Variants</strong> - Toggle individual variant columns</li>
          <li><strong>Hide Color Name</strong> - Hide the color label above the swatches</li>
          <li><strong>Swatch Style</strong> - Customize swatch size, base width, border radius, and gap</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>Parent Override Controls</h4>
        <p>The parent Colors element can override settings for all child items:</p>
        <ul>
          <li><strong>Display Override</strong> - Hide color name, CSS variable, hex value, or shade labels globally</li>
          <li><strong>Variations Override</strong> - Hide all variations or specific shade columns (light/dark/transparency)</li>
          <li><strong>Style Override</strong> - Set swatch size, base width, gap, and border radius for all items</li>
        </ul>
      </div>
    </Card>

    <Card title="CSS Override Variables">
      <p>Set these variables in your stylesheet to customize the element's appearance.</p>
      {@render cssVariablesSection('Colors Item Variables', 'colorsItem', colorsItemVars)}
      {@render cssVariablesSection('Colors Parent Variables', 'colors', colorsVars)}
    </Card>
  </div>
{/snippet}

{#snippet typographyContent()}
  <div class="bsg-instructions__content">
    <Card title="Typography Element">
      <p>The <strong>Typography (Nestable)</strong> element displays your typography scale with live computed values.</p>

      <div class="bsg-instructions__section">
        <h4>Structure</h4>
        <ul>
          <li><strong>Typography</strong> - Parent container element</li>
          <li><strong>Typography Item</strong> - Individual typography sample</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>Typography Item Settings</h4>
        <ul>
          <li><strong>Label</strong> - Display name (e.g., "Heading 1", "Body Text")</li>
          <li><strong>Sample Text</strong> - Preview text to display</li>
          <li><strong>CSS Variable</strong> - The {isAT ? 'AT' : 'ACSS'} font-size variable (e.g., <code>{isAT ? '--at-text--3xl' : '--text-xxl'}</code>)</li>
          <li><strong>HTML Element</strong> - The semantic element to use (h1-h6, p, span)</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>Live Updates</h4>
        <p>The element automatically calculates and displays:</p>
        <ul>
          <li>Computed font size in pixels</li>
          <li>Font family name</li>
          <li>Line height (if specified)</li>
        </ul>
        <p>Values update on window resize for responsive typography scales.</p>
      </div>
    </Card>

    <Card title="CSS Override Variables">
      <p>The plugin uses a local scope CSS variable pattern. Set these variables on a parent element or in your stylesheet to override the default styles.</p>
      {@render cssVariablesSection('Typography Item Variables', 'typographyItem', typographyItemVars)}
      {@render cssVariablesSection('Typography Parent Variables', 'typography', typographyVars)}
    </Card>
  </div>
{/snippet}

{#snippet spacingContent()}
  <div class="bsg-instructions__content">
    <Card title="Spacing Element">
      <p>The <strong>Spacing (Nestable)</strong> element visualizes your spacing scale with responsive bars.</p>

      <div class="bsg-instructions__section">
        <h4>Structure</h4>
        <ul>
          <li><strong>Spacing</strong> - Parent container element</li>
          <li><strong>Spacing Item</strong> - Individual spacing token visualization</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>Spacing Item Settings</h4>
        <ul>
          <li><strong>Label</strong> - Display name (e.g., "Small", "Medium", "Large")</li>
          <li><strong>CSS Variable</strong> - The {isAT ? 'AT' : 'ACSS'} spacing variable (e.g., <code>{isAT ? '--at-space--m' : '--space-m'}</code>)</li>
          <li><strong>Bar Color</strong> - Color for the visual bar</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>Live Updates</h4>
        <p>The element calculates the current pixel value from clamp() expressions and updates on window resize.</p>
      </div>
    </Card>

    <Card title="CSS Override Variables">
      <p>Set these variables in your stylesheet to customize the element's appearance.</p>
      {@render cssVariablesSection('Spacing Item Variables', 'spacingItem', spacingItemVars)}
      {@render cssVariablesSection('Spacing Parent Variables', 'spacing', spacingVars)}
    </Card>
  </div>
{/snippet}

{#snippet radiiContent()}
  <div class="bsg-instructions__content">
    <Card title="Radii Element">
      <p>The <strong>Radii (Nestable)</strong> element displays your border radius tokens as visual boxes.</p>

      <div class="bsg-instructions__section">
        <h4>Structure</h4>
        <ul>
          <li><strong>Radii</strong> - Parent container with grid layout</li>
          <li><strong>Radii Item</strong> - Individual radius preview box</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>Radii Item Settings</h4>
        <ul>
          <li><strong>Label</strong> - Display name (e.g., "Small", "Large", "Pill")</li>
          <li><strong>CSS Variable</strong> - The {isAT ? 'AT' : 'ACSS'} radius variable (e.g., <code>{isAT ? '--at-radius--m' : '--radius-m'}</code>)</li>
          <li><strong>Show Variable Name</strong> - Display the CSS variable name</li>
          <li><strong>Show Computed Value</strong> - Display the pixel value</li>
        </ul>
      </div>
    </Card>

    <Card title="CSS Override Variables">
      <p>Set these variables in your stylesheet to customize the element's appearance.</p>
      {@render cssVariablesSection('Radii Item Variables', 'radiiItem', radiiItemVars)}
      {@render cssVariablesSection('Radii Parent Variables', 'radii', radiiVars)}
    </Card>
  </div>
{/snippet}

{#snippet boxShadowsContent()}
  <div class="bsg-instructions__content">
    <Card title="Box Shadows Element">
      <p>The <strong>Box Shadows (Nestable)</strong> element showcases your shadow tokens on preview cards.</p>

      <div class="bsg-instructions__section">
        <h4>Structure</h4>
        <ul>
          <li><strong>Box Shadows</strong> - Parent container with grid layout</li>
          <li><strong>Box Shadow Item</strong> - Individual shadow preview card</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>Box Shadow Item Settings</h4>
        <ul>
          <li><strong>Label</strong> - Display name (e.g., "Small", "Medium", "Large")</li>
          <li><strong>CSS Variable</strong> - The {isAT ? 'AT' : 'ACSS'} shadow variable (e.g., <code>{isAT ? '--at-shadow--m' : '--box-shadow-m'}</code>)</li>
          <li><strong>Show Variable Name</strong> - Display the CSS variable name</li>
          <li><strong>Show Shadow Definition</strong> - Display the raw shadow value</li>
        </ul>
      </div>
    </Card>

    <Card title="CSS Override Variables">
      <p>Set these variables in your stylesheet to customize the element's appearance.</p>
      {@render cssVariablesSection('Box Shadow Item Variables', 'shadowsItem', shadowsItemVars)}
      {@render cssVariablesSection('Box Shadows Parent Variables', 'shadows', shadowsVars)}
    </Card>
  </div>
{/snippet}

{#snippet buttonsContent()}
  <div class="bsg-instructions__content">
    <Card title="Buttons Element">
      <p>The <strong>Buttons (Nestable)</strong> element displays button variants using {isAT ? "Bricks' native button styles" : 'Automatic CSS button classes'}.</p>

      <div class="bsg-instructions__section">
        <h4>Structure</h4>
        <ul>
          <li><strong>Buttons</strong> - Parent container with toolbar toggles</li>
          <li><strong>Button Item</strong> - Individual button sample</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>Button Item Settings</h4>
        <ul>
          <li><strong>Label</strong> - Button text</li>
          <li><strong>Description</strong> - Optional description (auto-generated if empty)</li>
          <li><strong>Variant</strong> - Solid or Outline</li>
          <li><strong>Color</strong> - Primary, Secondary, Dark, Light, Info, Success, Warning, Danger</li>
          <li><strong>Size</strong> - Small, Medium, Large, Extra Large</li>
          <li><strong>Shape</strong> - Default, Square, Round, Circle</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>Interactive Toolbar</h4>
        <p>The parent element includes toggle switches to:</p>
        <ul>
          <li><strong>Rounded</strong> - Apply rounded corners to all buttons</li>
          <li><strong>Outline</strong> - Switch all buttons to outline variant</li>
        </ul>
      </div>

      <div class="bsg-instructions__section">
        <h4>Layout Modes</h4>
        <ul>
          <li><strong>Grid</strong> - Buttons arranged in a configurable grid</li>
          <li><strong>Rows</strong> - Buttons grouped by color in horizontal rows</li>
        </ul>
      </div>
    </Card>

    <Card title="CSS Override Variables">
      <p>Set these variables in your stylesheet to customize the element's appearance.</p>
      {@render cssVariablesSection('Button Item Variables', 'buttonsItem', buttonsItemVars)}
      {@render cssVariablesSection('Buttons Parent Variables', 'buttons', buttonsVars)}
    </Card>
  </div>
{/snippet}

<div class="bsg-instructions">
  <header class="bsg-instructions__header">
    <h1>Bricks Style Guide</h1>
    <p class="bsg-instructions__subtitle">Bricks Builder Elements for {frameworkName}</p>
  </header>

  <Tabs {tabs} />
</div>

<style>
  .bsg-instructions {
    max-width: 960px;
    margin: 0 auto;
    padding: var(--wpea-space--lg) var(--wpea-space--md);
  }

  .bsg-instructions__header {
    text-align: center;
    margin-bottom: var(--wpea-space--xl);
  }

  .bsg-instructions__header h1 {
    font-size: var(--wpea-text--3xl);
    font-weight: 700;
    margin: 0 0 var(--wpea-space--xs) 0;
    color: var(--wpea-surface--text);
  }

  .bsg-instructions__subtitle {
    font-size: var(--wpea-text--md);
    color: var(--wpea-surface--text-muted);
    margin: 0;
  }

  .bsg-instructions__content {
    padding: var(--wpea-space--md) 0;
    display: flex;
    flex-direction: column;
    gap: var(--wpea-space--lg);
  }

  .bsg-instructions__section {
    margin-top: var(--wpea-space--lg);
  }

  .bsg-instructions__section h4 {
    font-size: var(--wpea-text--md);
    font-weight: 600;
    margin: 0 0 var(--wpea-space--sm) 0;
    color: var(--wpea-surface--text);
  }

  .bsg-instructions__section p {
    margin: 0 0 var(--wpea-space--sm) 0;
    color: var(--wpea-surface--text-muted);
  }

  .bsg-instructions__section ul,
  .bsg-instructions__section ol {
    margin: 0;
    padding-left: var(--wpea-space--lg);
    color: var(--wpea-surface--text-muted);
  }

  .bsg-instructions__section li {
    margin-bottom: var(--wpea-space--xs);
  }

  .bsg-instructions__section ol {
    list-style-type: decimal;
  }

  .bsg-instructions__section code {
    background: var(--wpea-surface--muted);
    padding: 0.125em 0.375em;
    border-radius: var(--wpea-radius--xs);
    font-size: 0.875em;
    color: var(--wpea-color--primary);
  }

  .bsg-instructions__code-block {
    background: var(--wpea-surface--muted);
    border-radius: var(--wpea-radius--sm);
    padding: var(--wpea-space--md);
    margin: var(--wpea-space--sm) 0;
    overflow-x: auto;
  }

  .bsg-instructions__code-block code {
    background: transparent;
    padding: 0;
    font-size: 0.8125em;
    line-height: 1.6;
    color: var(--wpea-surface--text);
    display: block;
    white-space: pre-wrap;
  }

  :global(.wpea-alert) {
    margin-bottom: var(--wpea-space--md);
  }

  /* CSS Variable List Styles */
  .bsg-var-list {
    background: var(--wpea-surface--muted);
    border-radius: var(--wpea-radius--sm);
    overflow: hidden;
    margin-top: var(--wpea-space--sm);
  }

  .bsg-var-list__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--wpea-space--sm) var(--wpea-space--md);
    background: var(--wpea-surface--muted);
    border-bottom: 1px solid var(--wpea-border--default);
  }

  .bsg-var-list__title {
    font-weight: 600;
    font-size: var(--wpea-text--sm);
    color: var(--wpea-surface--text);
  }

  .bsg-var-list__copy-all {
    background: var(--wpea-color--primary);
    color: white;
    border: none;
    padding: 0.375em 0.75em;
    border-radius: var(--wpea-radius--xs);
    font-size: var(--wpea-text--xs);
    cursor: pointer;
    transition: background 0.15s ease;
  }

  .bsg-var-list__copy-all:hover {
    background: var(--wpea-color--primary-hover, #1d4ed8);
  }

  .bsg-var-list__items {
    list-style: none;
    margin: 0;
    padding: 0;
    max-height: 300px;
    overflow-y: auto;
  }

  .bsg-var-list__item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: var(--wpea-space--xs) var(--wpea-space--md);
    border-bottom: 1px solid var(--wpea-border--default);
    margin-bottom: 0;
  }

  .bsg-var-list__item:last-child {
    border-bottom: none;
  }

  .bsg-var-list__item:hover {
    background: var(--wpea-surface--hover, rgba(0, 0, 0, 0.03));
  }

  .bsg-var-list__code {
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
    font-size: var(--wpea-text--xs);
    color: var(--wpea-color--primary);
    background: transparent;
    padding: 0;
  }

  .bsg-var-list__copy {
    background: transparent;
    color: var(--wpea-surface--text-muted);
    border: 1px solid var(--wpea-border--default);
    padding: 0.25em 0.5em;
    border-radius: var(--wpea-radius--xs);
    font-size: var(--wpea-text--xs);
    cursor: pointer;
    transition: all 0.15s ease;
    min-width: 3.5em;
  }

  .bsg-var-list__copy:hover {
    background: var(--wpea-surface--muted);
    color: var(--wpea-surface--text);
    border-color: var(--wpea-border--strong);
  }
</style>
