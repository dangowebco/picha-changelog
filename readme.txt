=== Picha – Changelog & Release Notes ===
Contributors: dangoweb
Tags: changelog, release-notes, product-updates, software, version-history
Requires at least: 6.5
Tested up to: 7.2
Stable tag: 2.3
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Create and display attractive changelogs for physical and digital products, software, and product updates. Organize version information, choose from multiple templates, customize colors, and display your changelog anywhere on your WordPress site using a shortcode. All features are available for free.

== Description ==

Picha Changelog helps you create and display clear, visually appealing changelogs for your physical or digital products and software.

Keep customers and website visitors informed about product updates, new features, improvements, and fixes. Instead of presenting updates as plain text, Picha helps you turn changelog content into an organized display using a choice of templates.

You can add changelog entries directly in the WordPress dashboard, organize them by version, and use the generated shortcode to display the changelog on a page or post. Each changelog can have its own color scheme, color mode (light, dark, or auto), and layout, making it easy to match the visual identity of each product.

== Key Features ==

* 5 distinct templates: Classic, Modern Card, Timeline, Minimal, and Accordion — each with a unique visual style.
* Shortcode support: Display your changelog anywhere using the generated shortcode.
* Drag & drop sorting: Reorder versions and log entries with drag & drop.
* Duplicate versions: Quickly duplicate an existing version section.
* Version descriptions: Add a description to each version to provide more context.
* Bulk log management: Manage changelog entries in bulk.
* Jalali date support: Use Jalali (Persian) dates for changelog entries.
* Per-changelog custom colors: Choose a primary color, text color, and surface color for each changelog.
* Color mode: Choose between Auto (follow system), Always Light, or Always Dark for each changelog.
* Live preview: Preview the rendered changelog before publishing.
* REST API: Access changelog data as JSON via the WordPress REST API.
* Theme template override: Override the built-in templates from your theme.
* RTL support: Full right-to-left support for Persian, Arabic, and Hebrew.
* Print-friendly: Clean print styles for all templates.
* Reduced-motion support: Respects the user's reduced-motion preference.
* Fully accessible: Keyboard navigation, ARIA labels, and focus states.

Picha Changelog is completely free. All features are included, and no Pro version or paid upgrade is required.

== Who Can Use Picha? ==

Picha Changelog can be useful for:

* Software developers who publish version updates.
* WordPress theme and plugin developers.
* Businesses that sell physical or digital products.
* Product managers who want to keep customers informed.
* Website owners who need to publish an organized product update history.

== Installation ==

1. Upload the `dw-picha-changelog-lite` folder to the `/wp-content/plugins/` directory, or install the plugin through the WordPress Plugins screen.
2. Activate Picha Changelog through the Plugins menu in WordPress.
3. Open the Picha Changelog menu in your WordPress dashboard.
4. Add a new changelog and fill in the version details.
5. Choose a template and customize the appearance if needed.
6. Copy the generated shortcode and paste it into the page or post where you want the changelog to appear.

== Frequently Asked Questions ==

= What is Picha Changelog? =

Picha Changelog is a WordPress plugin for creating and displaying changelogs for physical and digital products and software.

= How do I display a changelog on my website? =

After creating your changelog, copy the generated shortcode and add it to the page or post where you want the changelog to appear. You can also use the shortcode block in the block editor.

= Can I choose how my changelog looks? =

Yes. Picha includes 5 distinct templates (Classic, Modern Card, Timeline, Minimal, Accordion). Each changelog can also have its own custom colors and color mode. Developers can override templates from their theme by placing `picha/template-N.php` inside the active theme.

= Can I add descriptions to versions? =

Yes. You can add a description to each version.

= Does Picha support the Jalali calendar? =

Yes. Picha includes Jalali date support.

= Can I use different colors for each changelog? =

Yes. Each changelog can have its own primary color, text color, and surface color. You can also choose a color mode (Auto, Always Light, or Always Dark) per changelog.

= Can I access changelog data programmatically? =

Yes. Changelog data is available as JSON via `GET /wp-json/picha/v1/changelog/{id}`. The `{id}` is the changelog post ID.

= Is Picha Changelog free? =

Yes. Picha Changelog is completely free, and all features are included. There is no separate Pro version or paid upgrade.

== Screenshots ==

1. Changelog editor with drag & drop, color-coded statuses, and live preview.
2. Changelog displayed on the frontend (Timeline template).
3. Changelog displayed on the frontend (Modern Card template).
4. Per-changelog appearance settings (custom colors and color mode).

== Changelog ==

= 2.3 =
* Major release with redesigned templates and appearance settings.
* Templates:
  - Classic: Clean inline layout with colored status badges (merges old Templates 1 and 2).
  - Modern Card: Card-based layout with accent bar and sub-cards (redesigned old Template 4).
  - Timeline: Vertical timeline with connecting line and reveal-on-scroll animation (was Template 5 in v2.2).
  - Minimal: Typography-first layout with no cards or shadows (new).
  - Accordion: Collapsible layout using native <details>/<summary>, perfect for long changelogs (new).
* Appearance settings (per changelog):
  - Custom primary color, text color, and surface color.
  - Color mode: Auto (follow system), Always Light, or Always Dark.
  - Reset to defaults button.
* Admin UI redesign:
  - Card-based layout with drag handles for versions and log entries.
  - Color-coded status dropdowns for quick visual scanning.
  - Item counter per version.
  - Sticky toolbar with version count.
  - Empty-state hints for better onboarding.
  - Responsive layout for tablets and mobile.
  - Full RTL support using CSS logical properties.
  - Improved accessibility (focus states, ARIA labels, button semantics).
* Live Preview:
  - Preview the rendered changelog before publishing.
  - Modal with the selected template and appearance settings.
* CSS variables:
  - Customize colors and spacing without editing plugin files.
  - Brand color (#f0932b) used as default accent.
* Theme integration:
  - Full RTL support.
  - Dark mode (Auto / Always Light / Always Dark).
  - Print-friendly styles for all templates.
  - Reduced-motion support for animations.
* Developer features:
  - Theme template override (yourtheme/picha/template-N.php).
  - REST API endpoint: GET /wp-json/picha/v1/changelog/{id}.
* Security:
  - Escaped all template output (description uses wp_kses_post()).
  - Added null-coalescing checks for all meta array access.
  - Replaced spoofable meta_box_flag with get_post_type() check.
  - Added is_array() guard for dwp_option before array_map().
* Fixed:
  - Duplicate input names in bulk-add (itemIndex now increments correctly).
  - Jalali datepicker now re-initializes after dynamic elements are added.
  - Sortable rows preserve correct array indexes on save.
  - Duplicate version now copies all items (not just the header).
  - Auto dark mode now correctly applies on systems with dark preference.
  - Custom colors now correctly override dark mode when enabled.
* Improved:
  - Standard load_plugin_textdomain() usage.
  - All functions prefixed consistently with dwpicha313_.
  - Assets are only loaded on the plugin screen.
  - Backward-compatible aliases kept for v2.0 functions.
* Removed:
  - Old Template 3 (basic timeline) — replaced by Timeline.
  - Old Template 5 (timeline v2.2) — moved to Template 3.

= 2.0 =
* Made all previously Pro features available in the free version.
* Added bulk changelog management.
* Added more changelog templates.
* Added Jalali date support.
* Added the ability to add descriptions to individual versions.

= 1.0 =
* Initial release.