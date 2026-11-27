=== Picha – Changelog & Release Notes ===
Contributors: dangoweb
Tags: changelog, release-notes, product-updates, software, version-history
Requires at least: 6.5
Tested up to: 7.2
Stable tag: 2.3
Requires PHP: 7.4
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Create and display attractive changelogs for products and software. 5 templates, custom colors, dark mode, RTL, and live preview. All features free.

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
* Redesigned the template system with 5 distinct templates: Classic, Modern Card, Timeline, Minimal, and Accordion.
* Added per-changelog appearance settings: custom primary color, text color, surface color, and color mode (Auto, Light, Dark).
* Redesigned the admin interface with a modern card-based layout, drag & drop sorting, color-coded statuses, and empty states.
* Added live preview of the rendered changelog before publishing.
* Added duplicate version, bulk add, and theme template override.
* Added CSS variables for easy customization (default brand color #f0932b).
* Added full RTL, dark mode, and print-friendly support.
* Improved mobile layouts and accessibility across all templates.
* Added REST API endpoint for accessing changelog data as JSON.
* Various security and stability improvements.

= 2.0 =
* Made all previously Pro features available in the free version.
* Added bulk changelog management.
* Added more changelog templates.
* Added Jalali date support.
* Added the ability to add descriptions to individual versions.

= 1.0 =
* Initial release.