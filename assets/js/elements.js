/**
 * AT Style Guide Elements - JavaScript
 *
 * Bricks calls these functions via the $scripts property when elements render in the builder.
 * On the frontend, we auto-initialize on DOMContentLoaded.
 */

(function() {
	'use strict';

	/**
	 * Get the original CSS value for a property, preserving CSS variable references
	 * or original units (em, rem, %, etc.) instead of computed px values.
	 *
	 * @param {HTMLElement} element - The element to inspect.
	 * @param {string} property - The CSS property name (e.g., 'line-height').
	 * @returns {string|null} The original value with units, or null if not found.
	 */
	function getOriginalCSSValue(element, property) {
		// First, check inline style
		const inlineValue = element.style.getPropertyValue(property);
		if (inlineValue && inlineValue !== '') {
			return inlineValue;
		}

		// Walk through all stylesheets to find matching rules
		try {
			const sheets = document.styleSheets;
			let matchedValue = null;
			let matchedSpecificity = -1;

			for (let i = 0; i < sheets.length; i++) {
				let rules;
				try {
					rules = sheets[i].cssRules || sheets[i].rules;
				} catch (e) {
					// Cross-origin stylesheets may throw
					continue;
				}

				if (!rules) continue;

				for (let j = 0; j < rules.length; j++) {
					const rule = rules[j];
					if (rule.type !== CSSRule.STYLE_RULE) continue;

					try {
						if (element.matches(rule.selectorText)) {
							const value = rule.style.getPropertyValue(property);
							if (value && value !== '') {
								// Simple specificity approximation (later rules win for same specificity)
								matchedValue = value;
							}
						}
					} catch (e) {
						// Some selectors may be invalid
						continue;
					}
				}
			}

			if (matchedValue) {
				// If the value is a CSS variable, try to resolve it but keep showing the variable name
				if (matchedValue.startsWith('var(')) {
					// Extract variable name
					const varMatch = matchedValue.match(/var\(([^,)]+)/);
					if (varMatch) {
						const varName = varMatch[1].trim();
						// Get the actual variable value from computed styles
						const resolvedValue = getComputedStyle(document.documentElement).getPropertyValue(varName).trim();
						// Return the resolved value but preserve its original units
						if (resolvedValue) {
							return resolvedValue;
						}
					}
				}
				return matchedValue;
			}
		} catch (e) {
			// Fall through to return null
		}

		return null;
	}

	// Make function available globally for element scripts
	window.getOriginalCSSValue = getOriginalCSSValue;

	/**
	 * Initialize all elements on the frontend.
	 */
	function initAllElements() {
		if (typeof atTypographyInit === 'function') atTypographyInit();
		if (typeof atTypographyItemInit === 'function') atTypographyItemInit();
		if (typeof atSpacingInit === 'function') atSpacingInit();
		if (typeof atSpacingItemInit === 'function') atSpacingItemInit();
		if (typeof atRadiiInit === 'function') atRadiiInit();
		if (typeof atRadiiItemInit === 'function') atRadiiItemInit();
		if (typeof atBoxShadowsInit === 'function') atBoxShadowsInit();
		if (typeof atBoxShadowsItemInit === 'function') atBoxShadowsItemInit();
		if (typeof atButtonsInit === 'function') atButtonsInit();
		if (typeof atButtonsItemInit === 'function') atButtonsItemInit();
		if (typeof atColorsInit === 'function') atColorsInit();
		if (typeof atColorsItemInit === 'function') atColorsItemInit();
	}

	// Auto-initialize on frontend (not in Bricks builder)
	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initAllElements);
	} else {
		initAllElements();
	}
})();

/**
 * Typography Element (Nestable Container) - Initialize child items.
 */
function atTypographyInit() {
	// The parent just needs to ensure children are initialized
	atTypographyItemInit();
}

/**
 * Typography Item Element - Calculate and display computed font values.
 */
function atTypographyItemInit() {
	const items = document.querySelectorAll('.atsg-typography-item');

	items.forEach(item => {
		const updateComputedValues = () => {
			const sample = item.querySelector('.atsg-typography-item__sample');
			if (!sample) return;

			const computed = window.getComputedStyle(sample);

			const familyEl = item.querySelector('[data-computed="font-family"]');
			const sizeEl = item.querySelector('[data-computed="font-size"]');
			const lineHeightEl = item.querySelector('[data-computed="line-height"]');
			const weightEl = item.querySelector('[data-computed="font-weight"]');
			const spacingEl = item.querySelector('[data-computed="letter-spacing"]');
			const colorEl = item.querySelector('[data-computed="color"]');
			const transformEl = item.querySelector('[data-computed="text-transform"]');
			const styleEl = item.querySelector('[data-computed="font-style"]');

			if (familyEl) {
				const family = computed.fontFamily.split(',')[0].replace(/["']/g, '').trim();
				familyEl.textContent = family;
			}

			if (sizeEl) {
				sizeEl.textContent = computed.fontSize;
			}

			if (lineHeightEl) {
				// Try to get the original CSS value with its units instead of computed px
				const originalLineHeight = getOriginalCSSValue(sample, 'line-height');
				if (originalLineHeight) {
					lineHeightEl.textContent = originalLineHeight;
				} else if (computed.lineHeight === 'normal') {
					lineHeightEl.textContent = 'Browser Default';
				} else {
					// No explicit line-height set, show "Browser Default"
					lineHeightEl.textContent = 'Browser Default';
				}
			}

			if (weightEl) {
				weightEl.textContent = computed.fontWeight;
			}

			if (spacingEl) {
				const spacing = computed.letterSpacing;
				spacingEl.textContent = spacing === 'normal' ? '0' : spacing;
			}

			if (colorEl) {
				// Convert RGB to hex for cleaner display
				const rgbMatch = computed.color.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)/);
				if (rgbMatch) {
					const r = parseInt(rgbMatch[1]).toString(16).padStart(2, '0');
					const g = parseInt(rgbMatch[2]).toString(16).padStart(2, '0');
					const b = parseInt(rgbMatch[3]).toString(16).padStart(2, '0');
					colorEl.textContent = `#${r}${g}${b}`.toUpperCase();
				} else {
					colorEl.textContent = computed.color;
				}
			}

			if (transformEl) {
				transformEl.textContent = computed.textTransform;
			}

			if (styleEl) {
				styleEl.textContent = computed.fontStyle;
			}
		};

		updateComputedValues();
		window.addEventListener('resize', updateComputedValues);
	});
}

/**
 * Spacing Element (Nestable Container) - Initialize child items.
 */
function atSpacingInit() {
	// The parent just needs to ensure children are initialized
	atSpacingItemInit();
}

/**
 * Spacing Item Element - Calculate and display computed spacing values.
 */
function atSpacingItemInit() {
	const items = document.querySelectorAll('.atsg-spacing-item');

	items.forEach(item => {
		const updateComputedValues = () => {
			const bar = item.querySelector('.atsg-spacing-item__bar');
			const computedEl = item.querySelector('.atsg-spacing-item__computed');

			if (!bar) return;

			const computed = window.getComputedStyle(bar);
			const parent = item.closest('.atsg-spacing');
			const isVertical = parent && parent.classList.contains('atsg-spacing--vertical');

			// For vertical, height is set via CSS variable, for horizontal it's width
			const size = isVertical ? computed.height : computed.width;

			if (computedEl) {
				computedEl.textContent = size;
			}
		};

		updateComputedValues();
		window.addEventListener('resize', updateComputedValues);
	});
}

/**
 * Radii Element (Nestable Container) - Initialize child items.
 */
function atRadiiInit() {
	// The parent just needs to ensure children are initialized
	atRadiiItemInit();
}

/**
 * Radii Item Element - Calculate and display computed border-radius values.
 */
function atRadiiItemInit() {
	const items = document.querySelectorAll('.atsg-radii-item');

	items.forEach(item => {
		const box = item.querySelector('.atsg-radii-item__box');
		const computedEl = item.querySelector('.atsg-radii-item__computed');

		if (!box || !computedEl) return;

		const computed = window.getComputedStyle(box);
		computedEl.textContent = computed.borderRadius;
	});
}

/**
 * Box Shadows Element (Nestable Container) - Initialize child items.
 */
function atBoxShadowsInit() {
	// The parent just needs to ensure children are initialized
	atBoxShadowsItemInit();
}

/**
 * Box Shadows Item Element - Calculate and display computed box-shadow values.
 */
function atBoxShadowsItemInit() {
	const items = document.querySelectorAll('.atsg-shadows-item');

	items.forEach(item => {
		const box = item.querySelector('.atsg-shadows-item__box');
		const computedEl = item.querySelector('.atsg-shadows-item__computed');

		if (!box || !computedEl) return;

		const computed = window.getComputedStyle(box);
		computedEl.textContent = computed.boxShadow;
	});
}

/**
 * Buttons Element (Nestable Container) - Initialize child items.
 */
function atButtonsInit() {
	// Initialize toggle switches
	const containers = document.querySelectorAll('.atsg-buttons');
	containers.forEach(container => {
		const toggles = container.querySelectorAll('[data-toggle]');
		toggles.forEach(toggle => {
			if (toggle.dataset.initialized) return;
			toggle.dataset.initialized = 'true';

			toggle.addEventListener('change', () => {
				const toggleType = toggle.dataset.toggle;
				const buttons = container.querySelectorAll('.bricks-button');

				if (toggleType === 'outline') {
					buttons.forEach(btn => {
						if (toggle.checked) {
							btn.classList.add('outline');
						} else {
							btn.classList.remove('outline');
						}
					});
				} else if (toggleType === 'rounded') {
					buttons.forEach(btn => {
						if (toggle.checked) {
							btn.classList.add('circle');
						} else {
							btn.classList.remove('circle');
						}
					});
				}
			});
		});
	});

	// The parent just needs to ensure children are initialized
	atButtonsItemInit();
}

/**
 * Buttons Item Element - No computed values needed, just ensures render.
 */
function atButtonsItemInit() {
	// Buttons don't need computed value display, but this ensures
	// the element is properly initialized in the builder.
	const items = document.querySelectorAll('.atsg-buttons-item');
	// Future: Could add hover state previews or other interactivity here.
}

/**
 * Colors Element (Nestable Container) - Initialize child items.
 */
function atColorsInit() {
	// Initialize A11Y badges toggle
	const containers = document.querySelectorAll('.atsg-colors');
	containers.forEach(container => {
		const toggle = container.querySelector('[data-toggle="a11y-badges"]');
		if (toggle && !toggle.dataset.initialized) {
			toggle.dataset.initialized = 'true';
			toggle.addEventListener('change', () => {
				if (toggle.checked) {
					container.setAttribute('data-show-a11y-badges', 'true');
				} else {
					container.removeAttribute('data-show-a11y-badges');
				}
			});
		}
	});

	// The parent just needs to ensure children are initialized
	atColorsItemInit();
}

/**
 * Colors Item Element - Initialize context menus and copy functionality.
 */
function atColorsItemInit() {
	const swatches = document.querySelectorAll('.atsg-colors-item__swatch, .atsg-colors-item__base');

	swatches.forEach(swatch => {
		// Skip if already initialized
		if (swatch.dataset.initialized) return;
		swatch.dataset.initialized = 'true';

		const cssVar = swatch.dataset.var;
		const menu = swatch.querySelector('.atsg-colors-item__menu');
		if (!menu || !cssVar) return;

		// Get computed color and populate menu
		const updateColorValues = () => {
			const computed = window.getComputedStyle(swatch);
			const bgColor = computed.backgroundColor;

			// Parse the color
			const colorData = parseColor(bgColor);
			if (!colorData) return;

			// Update the main copy button value
			const valueEl = menu.querySelector('.atsg-colors-item__menu-value');
			if (valueEl) {
				valueEl.textContent = colorData.hex;
			}

			// Update contrast values
			if (colorData.contrast) {
				const contrastSection = menu.querySelector('.atsg-colors-item__menu-contrast');
				const whiteValueEl = menu.querySelector('[data-contrast="white"]');
				const whiteBadgeEl = menu.querySelector('[data-contrast-badge="white"]');
				const blackValueEl = menu.querySelector('[data-contrast="black"]');
				const blackBadgeEl = menu.querySelector('[data-contrast-badge="black"]');

				// Update swatch contrast badges
				const swatchBadges = swatch.querySelector('.atsg-colors-item__contrast-badges');
				const whiteBadge = swatch.querySelector('.atsg-colors-item__contrast-badge--white');
				const blackBadge = swatch.querySelector('.atsg-colors-item__contrast-badge--black');

				// Hide contrast section and badges for transparent colors (ratio depends on background)
				if (colorData.hasAlpha) {
					if (contrastSection) {
						contrastSection.innerHTML = '<div class="atsg-colors-item__menu-contrast-header">Contrast</div>' +
							'<div class="atsg-colors-item__menu-contrast-note">N/A for transparent colors</div>';
					}
					if (swatchBadges) {
						swatchBadges.style.display = 'none';
					}
				} else {
					if (whiteValueEl) {
						whiteValueEl.textContent = colorData.contrast.white.ratioText;
					}
					if (whiteBadgeEl) {
						whiteBadgeEl.textContent = colorData.contrast.white.wcag.label;
						whiteBadgeEl.dataset.level = colorData.contrast.white.wcag.level;
					}
					if (blackValueEl) {
						blackValueEl.textContent = colorData.contrast.black.ratioText;
					}
					if (blackBadgeEl) {
						blackBadgeEl.textContent = colorData.contrast.black.wcag.label;
						blackBadgeEl.dataset.level = colorData.contrast.black.wcag.level;
					}

					// Update swatch badges
					if (whiteBadge) {
						whiteBadge.dataset.level = colorData.contrast.white.wcag.level;
					}
					if (blackBadge) {
						blackBadge.dataset.level = colorData.contrast.black.wcag.level;
					}
				}
			}

			// Store color data on swatch for copy buttons
			swatch._colorData = colorData;
		};

		// Add contrast badges to swatch (only for non-transparent colors)
		const contrastBadges = document.createElement('div');
		contrastBadges.className = 'atsg-colors-item__contrast-badges';
		contrastBadges.innerHTML =
			'<span class="atsg-colors-item__contrast-badge atsg-colors-item__contrast-badge--white">W</span>' +
			'<span class="atsg-colors-item__contrast-badge atsg-colors-item__contrast-badge--black">B</span>';
		swatch.appendChild(contrastBadges);

		// Initialize color values
		updateColorValues();

		// Click to show menu
		let isMenuOpen = false;

		// Add click hint element
		const hint = document.createElement('span');
		hint.className = 'atsg-colors-item__hint';
		hint.textContent = 'Click';
		swatch.appendChild(hint);

		const showMenu = () => {
			isMenuOpen = true;
			positionMenuAtSwatch(swatch, menu);
			menu.style.opacity = '1';
			menu.style.visibility = 'visible';
			menu.style.pointerEvents = 'auto';
			hint.style.display = 'none';
		};

		const closeMenu = () => {
			isMenuOpen = false;
			hideMenu(menu);
			hint.style.display = '';
		};

		// Click swatch to toggle menu
		swatch.addEventListener('click', (e) => {
			e.stopPropagation();
			if (isMenuOpen) {
				closeMenu();
			} else {
				// Close any other open menus first
				document.querySelectorAll('.atsg-colors-item__menu').forEach(m => {
					if (m !== menu) {
						m.style.opacity = '0';
						m.style.visibility = 'hidden';
						m.style.pointerEvents = 'none';
					}
				});
				showMenu();
			}
		});

		// Hide menu when leaving it
		menu.addEventListener('mouseleave', closeMenu);

		// Hide menu when clicking elsewhere
		document.addEventListener('click', (e) => {
			if (isMenuOpen && !menu.contains(e.target) && !swatch.contains(e.target)) {
				closeMenu();
			}
		});

		// Handle CSS variable click to copy
		const varBtn = menu.querySelector('.atsg-colors-item__menu-var');
		if (varBtn) {
			varBtn.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();
				const varValue = varBtn.dataset.varValue;
				if (varValue) {
					copyToClipboard(varValue, varBtn);
				}
			});
		}

		// Handle copy button clicks
		const buttons = menu.querySelectorAll('.atsg-colors-item__menu-btn');
		buttons.forEach(btn => {
			btn.addEventListener('click', (e) => {
				e.preventDefault();
				e.stopPropagation();

				const action = btn.dataset.action;
				const colorData = swatch._colorData;
				if (!colorData) return;

				let valueToCopy = '';

				switch (action) {
					case 'copy-hex':
						valueToCopy = colorData.hasAlpha ? colorData.rgba : colorData.hex;
						break;
					case 'copy-rgb':
						valueToCopy = colorData.hasAlpha ? colorData.rgba : colorData.rgb;
						break;
					case 'copy-hsl':
						valueToCopy = colorData.hasAlpha ? colorData.hsla : colorData.hsl;
						break;
					case 'copy-oklch':
						valueToCopy = colorData.oklch;
						break;
				}

				if (valueToCopy) {
					copyToClipboard(valueToCopy, btn);
				}
			});
		});
	});
}

/**
 * Position menu relative to swatch element.
 */
function positionMenuAtSwatch(swatch, menu) {
	const gap = 8;
	const swatchRect = swatch.getBoundingClientRect();
	const viewportWidth = window.innerWidth;
	const viewportHeight = window.innerHeight;

	// Make menu visible briefly to get its dimensions
	menu.style.visibility = 'hidden';
	menu.style.display = 'block';
	const menuRect = menu.getBoundingClientRect();

	// Default: position to the right of swatch
	let left = swatchRect.right + gap;
	let top = swatchRect.top;

	// If menu would go off right edge, position to the left
	if (left + menuRect.width > viewportWidth - 10) {
		left = swatchRect.left - menuRect.width - gap;
	}

	// If still off screen (swatch near left edge), position below
	if (left < 10) {
		left = swatchRect.left;
		top = swatchRect.bottom + gap;
	}

	// Adjust if menu would go off bottom edge
	if (top + menuRect.height > viewportHeight - 10) {
		top = viewportHeight - menuRect.height - 10;
	}

	// Ensure menu doesn't go off top
	top = Math.max(10, top);

	menu.style.position = 'fixed';
	menu.style.left = left + 'px';
	menu.style.top = top + 'px';
	menu.style.transform = 'none';
	menu.style.visibility = '';
}

/**
 * Hide the menu.
 */
function hideMenu(menu) {
	menu.style.opacity = '0';
	menu.style.visibility = 'hidden';
	menu.style.pointerEvents = 'none';
}

/**
 * Parse a color string and return various formats.
 */
function parseColor(colorStr) {
	// Parse rgba/rgb
	const rgbaMatch = colorStr.match(/rgba?\((\d+),\s*(\d+),\s*(\d+)(?:,\s*([\d.]+))?\)/);
	if (!rgbaMatch) return null;

	const r = parseInt(rgbaMatch[1]);
	const g = parseInt(rgbaMatch[2]);
	const b = parseInt(rgbaMatch[3]);
	const a = rgbaMatch[4] !== undefined ? parseFloat(rgbaMatch[4]) : 1;
	const hasAlpha = a < 1;

	// Convert to hex
	const toHex = (n) => n.toString(16).padStart(2, '0');
	const hex = `#${toHex(r)}${toHex(g)}${toHex(b)}`;
	const hex8 = `#${toHex(r)}${toHex(g)}${toHex(b)}${toHex(Math.round(a * 255))}`;

	// RGB/RGBA strings
	const rgb = `rgb(${r}, ${g}, ${b})`;
	const rgba = `rgba(${r}, ${g}, ${b}, ${a})`;

	// Convert to HSL
	const hsl = rgbToHsl(r, g, b);
	const hslStr = `hsl(${hsl.h}, ${hsl.s}%, ${hsl.l}%)`;
	const hslaStr = `hsla(${hsl.h}, ${hsl.s}%, ${hsl.l}%, ${a})`;

	// Convert to OKLCH
	const oklch = rgbToOklch(r, g, b, a);
	const oklchStr = `oklch(${oklch.l}% ${oklch.c} ${oklch.h}${hasAlpha ? ` / ${a}` : ''})`;

	// Calculate contrast info
	const contrast = calculateContrastInfo(r, g, b);

	return {
		r, g, b, a,
		hasAlpha,
		hex: hasAlpha ? hex8 : hex,
		rgb,
		rgba,
		hsl: hslStr,
		hsla: hslaStr,
		oklch: oklchStr,
		contrast
	};
}

/**
 * Convert RGB to HSL.
 */
function rgbToHsl(r, g, b) {
	r /= 255;
	g /= 255;
	b /= 255;

	const max = Math.max(r, g, b);
	const min = Math.min(r, g, b);
	let h, s;
	const l = (max + min) / 2;

	if (max === min) {
		h = s = 0;
	} else {
		const d = max - min;
		s = l > 0.5 ? d / (2 - max - min) : d / (max + min);

		switch (max) {
			case r: h = ((g - b) / d + (g < b ? 6 : 0)) / 6; break;
			case g: h = ((b - r) / d + 2) / 6; break;
			case b: h = ((r - g) / d + 4) / 6; break;
		}
	}

	return {
		h: Math.round(h * 360),
		s: Math.round(s * 100),
		l: Math.round(l * 100)
	};
}

/**
 * Convert RGB to OKLCH (simplified approximation).
 */
function rgbToOklch(r, g, b, a = 1) {
	// Convert to linear RGB
	const toLinear = (c) => {
		c = c / 255;
		return c <= 0.04045 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4);
	};

	const lr = toLinear(r);
	const lg = toLinear(g);
	const lb = toLinear(b);

	// Convert to OKLab
	const l_ = 0.4122214708 * lr + 0.5363325363 * lg + 0.0514459929 * lb;
	const m_ = 0.2119034982 * lr + 0.6806995451 * lg + 0.1073969566 * lb;
	const s_ = 0.0883024619 * lr + 0.2817188376 * lg + 0.6299787005 * lb;

	const l = Math.cbrt(l_);
	const m = Math.cbrt(m_);
	const s = Math.cbrt(s_);

	const L = 0.2104542553 * l + 0.7936177850 * m - 0.0040720468 * s;
	const A = 1.9779984951 * l - 2.4285922050 * m + 0.4505937099 * s;
	const B = 0.0259040371 * l + 0.7827717662 * m - 0.8086757660 * s;

	// Convert to OKLCH
	const C = Math.sqrt(A * A + B * B);
	let H = Math.atan2(B, A) * 180 / Math.PI;
	if (H < 0) H += 360;

	return {
		l: (L * 100).toFixed(1),
		c: C.toFixed(3),
		h: H.toFixed(1)
	};
}

/**
 * Calculate relative luminance for WCAG contrast.
 * @see https://www.w3.org/TR/WCAG21/#dfn-relative-luminance
 */
function getLuminance(r, g, b) {
	const toLinear = (c) => {
		c = c / 255;
		return c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4);
	};

	const lr = toLinear(r);
	const lg = toLinear(g);
	const lb = toLinear(b);

	return 0.2126 * lr + 0.7152 * lg + 0.0722 * lb;
}

/**
 * Calculate WCAG contrast ratio between two colors.
 * @see https://www.w3.org/TR/WCAG21/#dfn-contrast-ratio
 */
function getContrastRatio(l1, l2) {
	const lighter = Math.max(l1, l2);
	const darker = Math.min(l1, l2);
	return (lighter + 0.05) / (darker + 0.05);
}

/**
 * Get WCAG compliance level based on contrast ratio.
 */
function getWcagLevel(ratio) {
	if (ratio >= 7) {
		return { level: 'AAA', label: 'AAA', pass: true };
	} else if (ratio >= 4.5) {
		return { level: 'AA', label: 'AA', pass: true };
	} else if (ratio >= 3) {
		return { level: 'AA-large', label: 'AA Large', pass: true };
	} else {
		return { level: 'fail', label: 'Fail', pass: false };
	}
}

/**
 * Calculate contrast info for a color against white and black.
 */
function calculateContrastInfo(r, g, b) {
	const luminance = getLuminance(r, g, b);
	const whiteLuminance = 1; // White = rgb(255, 255, 255)
	const blackLuminance = 0; // Black = rgb(0, 0, 0)

	const whiteContrast = getContrastRatio(luminance, whiteLuminance);
	const blackContrast = getContrastRatio(luminance, blackLuminance);

	return {
		luminance,
		white: {
			ratio: whiteContrast,
			ratioText: whiteContrast.toFixed(1) + ':1',
			wcag: getWcagLevel(whiteContrast)
		},
		black: {
			ratio: blackContrast,
			ratioText: blackContrast.toFixed(1) + ':1',
			wcag: getWcagLevel(blackContrast)
		},
		bestChoice: whiteContrast > blackContrast ? 'white' : 'black'
	};
}

/**
 * Copy text to clipboard and show feedback.
 */
function copyToClipboard(text, btn) {
	navigator.clipboard.writeText(text).then(() => {
		// Show copied feedback
		btn.classList.add('copied');
		const originalText = btn.innerHTML;

		// For the main button, update text
		if (btn.dataset.action === 'copy-hex') {
			btn.innerHTML = '<span class="atsg-colors-item__menu-btn-icon">✓</span> Copied!';
		} else {
			btn.textContent = '✓';
		}

		setTimeout(() => {
			btn.classList.remove('copied');
			btn.innerHTML = originalText;
		}, 1500);
	}).catch(err => {
		console.error('Failed to copy:', err);
	});
}
