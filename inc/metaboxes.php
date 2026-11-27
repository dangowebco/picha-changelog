<?php
if (!defined('ABSPATH')) {
    exit;
}

add_action('add_meta_boxes', function () {
    add_meta_box(
        'dwpicha313_meta_box',
        __('Changelog', 'dw-picha-changelog'),
        'dwpicha313_meta_box',
        'dw_picha_changelog',
        'advanced',
        'high'
    );
    add_meta_box(
        'dwpicha313_meta_box_options',
        __('Changelog Options', 'dw-picha-changelog'),
        'dwpicha313_options_meta_box',
        'dw_picha_changelog',
        'side',
        'high'
    );
});

/**
 * Render a single version section (used both for existing and new).
 *
 * @param int|string $index
 * @param array      $changelog
 */
/**
 * Render a single version section (v2.2 modern UI).
 *
 * @param int|string $index
 * @param array      $changelog
 */
function dwpicha313_render_version_section($index, $changelog = [])
{
    $statuses       = dwpicha313_get_statuses();
    $version        = $changelog['version'] ?? '';
    $jalali_date    = $changelog['jalali_date'] ?? '';
    $gregorian_date = $changelog['gregorian_date'] ?? '';
    $description    = $changelog['description'] ?? '';
    $items          = $changelog['item'] ?? [];
    $item_count     = count($items);
?>
    <div class="dwp-box" data-index="<?php echo esc_attr($index); ?>">
        <!-- Header: drag handle + version + dates + actions -->
        <div class="dwp-header">
            <div class="dwp-drag-handle" title="<?php esc_attr_e('Drag to reorder', 'dw-picha-changelog'); ?>">
                <span class="dashicons dashicons-menu"></span>
            </div>

            <div class="dwp-header-main">
                <div class="dwp-header-row">
                    <div class="dwp-field dwp-field-version">
                        <label for="dwp-version-<?php echo esc_attr($index); ?>">
                            <?php esc_html_e('Version', 'dw-picha-changelog'); ?>
                        </label>
                        <input type="text"
                            id="dwp-version-<?php echo esc_attr($index); ?>"
                            name="dwp[<?php echo esc_attr($index); ?>][version]"
                            value="<?php echo esc_attr($version); ?>"
                            placeholder="<?php esc_attr_e('e.g. 2.1.0', 'dw-picha-changelog'); ?>"
                            class="dwp-input dwp-input-version">
                    </div>

                    <div class="dwp-field dwp-field-jdate">
                        <label for="dwp-jdate-<?php echo esc_attr($index); ?>">
                            <?php esc_html_e('Jalali Date', 'dw-picha-changelog'); ?>
                        </label>
                        <input type="text"
                            id="dwp-jdate-<?php echo esc_attr($index); ?>"
                            name="dwp[<?php echo esc_attr($index); ?>][jalali_date]"
                            value="<?php echo esc_attr($jalali_date); ?>"
                            placeholder="<?php esc_attr_e('1403/09/06', 'dw-picha-changelog'); ?>"
                            data-jdp data-jdp-only-date
                            class="dwp-input dwp-input-date">
                    </div>

                    <div class="dwp-field dwp-field-gdate">
                        <label for="dwp-gdate-<?php echo esc_attr($index); ?>">
                            <?php esc_html_e('Gregorian Date', 'dw-picha-changelog'); ?>
                        </label>
                        <input type="date"
                            id="dwp-gdate-<?php echo esc_attr($index); ?>"
                            name="dwp[<?php echo esc_attr($index); ?>][gregorian_date]"
                            value="<?php echo esc_attr($gregorian_date); ?>"
                            class="dwp-input dwp-input-date">
                    </div>
                </div>
            </div>

            <div class="dwp-header-actions">
                <span class="dwp-item-count" title="<?php esc_attr_e('Number of log entries', 'dw-picha-changelog'); ?>">
                    <?php echo esc_html($item_count); ?>
                    <span class="dashicons dashicons-list-view"></span>
                </span>
                <button type="button" class="dwp-icon-btn dw-duplicate-section"
                    title="<?php esc_attr_e('Duplicate', 'dw-picha-changelog'); ?>"
                    aria-label="<?php esc_attr_e('Duplicate this version', 'dw-picha-changelog'); ?>">
                    <span class="dashicons dashicons-admin-page"></span>
                </button>
                <button type="button" class="dwp-icon-btn dwp-icon-btn-danger dw-delete-section"
                    title="<?php esc_attr_e('Delete', 'dw-picha-changelog'); ?>"
                    aria-label="<?php esc_attr_e('Delete this version', 'dw-picha-changelog'); ?>">
                    <span class="dashicons dashicons-trash"></span>
                </button>
            </div>
        </div>

        <!-- Body: description + items -->
        <div class="dwp-body">
            <!-- Description -->
            <div class="dwp-description-wrapper">
                <label class="dwp-description-label" for="dwp-desc-<?php echo esc_attr($index); ?>">
                    <?php esc_html_e('Description', 'dw-picha-changelog'); ?>
                    <span class="dwp-hint"><?php esc_html_e('Optional summary of this release', 'dw-picha-changelog'); ?></span>
                </label>
                <textarea id="dwp-desc-<?php echo esc_attr($index); ?>"
                    name="dwp[<?php echo esc_attr($index); ?>][description]"
                    rows="3"
                    class="dwp-textarea"
                    placeholder="<?php esc_attr_e('Describe what changed in this version...', 'dw-picha-changelog'); ?>"><?php echo esc_textarea($description); ?></textarea>
            </div>

            <!-- Log items -->
            <div class="dwp-items-section">
                <div class="dwp-items-header">
                    <span class="dwp-items-title">
                        <?php esc_html_e('Log Entries', 'dw-picha-changelog'); ?>
                    </span>
                    <div class="dwp-items-actions">
                        <button type="button" class="dwp-btn dwp-btn-secondary dwp-add-bulk-log"
                            data-index="<?php echo esc_attr($index); ?>">
                            <span class="dashicons dashicons-editor-ul"></span>
                            <?php esc_html_e('Bulk Add', 'dw-picha-changelog'); ?>
                        </button>
                        <button type="button" class="dwp-btn dwp-btn-primary dwp-add-log"
                            data-index="<?php echo esc_attr($index); ?>">
                            <span class="dashicons dashicons-plus-alt"></span>
                            <?php esc_html_e('Add Entry', 'dw-picha-changelog'); ?>
                        </button>
                    </div>
                </div>

                <!-- Bulk area (collapsed by default) -->
                <div class="dwp-bulk-area-wrapper">
                    <div class="dwp-bulk-hint">
                        <span class="dashicons dashicons-info-outline"></span>
                        <?php esc_html_e('Paste multiple entries (one per line) below, then click "Add All".', 'dw-picha-changelog'); ?>
                    </div>
                    <textarea class="dwp-area-items dwp-textarea" rows="5"
                        placeholder="<?php esc_attr_e("Added feature A&#10;Fixed bug B&#10;Improved performance", 'dw-picha-changelog'); ?>"></textarea>
                    <div class="dwp-bulk-footer">
                        <button type="button" class="dwp-btn dwp-btn-secondary dwp-bulk-cancel">
                            <?php esc_html_e('Cancel', 'dw-picha-changelog'); ?>
                        </button>
                        <button type="button" class="dwp-btn dwp-btn-primary dwp-bulk-add-items"
                            data-index="<?php echo esc_attr($index); ?>">
                            <span class="dashicons dashicons-yes"></span>
                            <?php esc_html_e('Add All', 'dw-picha-changelog'); ?>
                        </button>
                    </div>
                </div>

                <!-- Sortable item list -->
                <ul class="dwp-body-area dwp-items-list">
                    <?php foreach ($items as $itemIndex => $item): ?>
                        <?php dwpicha313_render_log_row($index, $itemIndex, $item, $statuses); ?>
                    <?php endforeach; ?>
                </ul>

                <!-- Empty state -->
                <div class="dwp-empty-items" <?php echo $items ? 'style="display:none;"' : ''; ?>>
                    <span class="dashicons dashicons-editor-ul"></span>
                    <p><?php esc_html_e('No entries yet. Click "Add Entry" to start.', 'dw-picha-changelog'); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php
}

/**
 * Render a single log row.
 *
 * @param int|string $index
 * @param int|string $itemIndex
 * @param array      $item
 * @param array      $statuses
 */
function dwpicha313_render_log_row($index, $itemIndex, $item = [], $statuses = null)
{
    if ($statuses === null) {
        $statuses = dwpicha313_get_statuses();
    }
    $status  = $item['status'] ?? 'added';
    $content = $item['content'] ?? '';
?>
    <li class="dwp-body-row">
        <div class="dwp-row-drag" title="<?php esc_attr_e('Drag to reorder', 'dw-picha-changelog'); ?>">
            <span class="dashicons dashicons-menu"></span>
        </div>

        <div class="dwp-row-status">
            <select name="dwp[<?php echo esc_attr($index); ?>][item][<?php echo esc_attr($itemIndex); ?>][status]"
                class="dwp-status-select dwp-status-<?php echo esc_attr($status); ?>">
                <?php foreach ($statuses as $value => $label): ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($status, $value); ?>>
                        <?php echo esc_html($label); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="dwp-row-content">
            <input type="text"
                name="dwp[<?php echo esc_attr($index); ?>][item][<?php echo esc_attr($itemIndex); ?>][content]"
                value="<?php echo esc_attr($content); ?>"
                placeholder="<?php esc_attr_e('Describe the change...', 'dw-picha-changelog'); ?>"
                class="dwp-input">
        </div>

        <button type="button" class="dwp-icon-btn dwp-icon-btn-danger dw-delete-row"
            title="<?php esc_attr_e('Delete', 'dw-picha-changelog'); ?>"
            aria-label="<?php esc_attr_e('Delete this entry', 'dw-picha-changelog'); ?>">
            <span class="dashicons dashicons-trash"></span>
        </button>
    </li>
<?php
}

function dwpicha313_meta_box($post)
{
    $postMeta = maybe_unserialize(get_post_meta($post->ID, '_dwp_changelog', true));
    if (!is_array($postMeta)) {
        $postMeta = [];
    }

    wp_nonce_field('dwp_save_meta_box', 'dwp_nonce');
?>
    <div class="dwp-meta-wrapper">
        <!-- Toolbar -->
        <div class="dwp-toolbar">
            <div class="dwp-toolbar-left">
                <button type="button" class="dwp-btn dwp-btn-primary dw-add-new">
                    <span class="dashicons dashicons-plus-alt"></span>
                    <?php esc_html_e('New Version', 'dw-picha-changelog'); ?>
                </button>
                <button type="button" class="dwp-btn dwp-btn-secondary dw-preview-btn">
                    <span class="dashicons dashicons-visibility"></span>
                    <?php esc_html_e('Preview', 'dw-picha-changelog'); ?>
                </button>
            </div>
            <div class="dwp-toolbar-right">
                <span class="dwp-version-count">
                    <strong><?php echo esc_html(count($postMeta)); ?></strong>
                    <?php esc_html_e('versions', 'dw-picha-changelog'); ?>
                </span>
            </div>
        </div>

        <!-- Version list -->
        <div id="dwp-box-list" class="dwp-box-list">
            <?php if (empty($postMeta)): ?>
                <div class="dwp-empty-state">
                    <div class="dwp-empty-icon">
                        <span class="dashicons dashicons-clipboard"></span>
                    </div>
                    <h3><?php esc_html_e('No versions yet', 'dw-picha-changelog'); ?></h3>
                    <p><?php esc_html_e('Click "New Version" to add your first changelog entry.', 'dw-picha-changelog'); ?></p>
                    <button type="button" class="dwp-btn dwp-btn-primary dw-add-new">
                        <span class="dashicons dashicons-plus-alt"></span>
                        <?php esc_html_e('Create First Version', 'dw-picha-changelog'); ?>
                    </button>
                </div>
            <?php else: ?>
                <?php foreach ($postMeta as $index => $changelog): ?>
                    <?php dwpicha313_render_version_section($index, (array) $changelog); ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Preview modal (unchanged from v2.1) -->
        <div id="dwp-preview-modal" class="dwp-preview-modal" style="display:none;" aria-hidden="true">
            <div class="dwp-preview-overlay"></div>
            <div class="dwp-preview-dialog" role="dialog" aria-modal="true" aria-labelledby="dwp-preview-title">
                <div class="dwp-preview-header">
                    <h2 id="dwp-preview-title"><?php esc_html_e('Changelog Preview', 'dw-picha-changelog'); ?></h2>
                    <button type="button" class="dwp-preview-close" aria-label="<?php esc_attr_e('Close', 'dw-picha-changelog'); ?>">
                        <span class="dashicons dashicons-no-alt"></span>
                    </button>
                </div>
                <div class="dwp-preview-body">
                    <div class="dwp-preview-loading">
                        <span class="spinner is-active"></span>
                        <span><?php esc_html_e('Loading preview...', 'dw-picha-changelog'); ?></span>
                    </div>
                    <div class="dwp-preview-content"></div>
                    <div class="dwp-preview-error" style="display:none;"></div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="dwp_meta_box_present" value="1">
<?php
}

function dwpicha313_options_meta_box($post)
{
    $postMeta = maybe_unserialize(get_post_meta($post->ID, '_dwp_changelog_options', true));
    if (!is_array($postMeta)) {
        $postMeta = [];
    }
    $templates = dwpicha313_get_templates();
?>
    <div class="dwp-checkbox-wrapper">
        <label class="dwp-checkbox">
            <input type="checkbox" value="on" name="dwp_option[version]"
                <?php checked($postMeta['version'] ?? '', 'on'); ?>>
            <div class="dwp-checkmark"></div>
            <div class="dwp-checkbox-label"><?php esc_html_e('Show Version', 'dw-picha-changelog'); ?></div>
        </label>
    </div>
    <div class="dwp-checkbox-wrapper">
        <label class="dwp-checkbox">
            <input type="checkbox" value="on" name="dwp_option[j_date]"
                <?php checked($postMeta['j_date'] ?? '', 'on'); ?>>
            <div class="dwp-checkmark"></div>
            <div class="dwp-checkbox-label"><?php esc_html_e('Show Jalali Date', 'dw-picha-changelog'); ?></div>
        </label>
    </div>
    <div class="dwp-checkbox-wrapper">
        <label class="dwp-checkbox">
            <input type="checkbox" value="on" name="dwp_option[g_date]"
                <?php checked($postMeta['g_date'] ?? '', 'on'); ?>>
            <div class="dwp-checkmark"></div>
            <div class="dwp-checkbox-label"><?php esc_html_e('Show Gregorian date', 'dw-picha-changelog'); ?></div>
        </label>
    </div>
    <div class="dwp-checkbox-wrapper">
        <label class="dwp-checkbox">
            <input type="checkbox" value="on" name="dwp_option[desc]"
                <?php checked($postMeta['desc'] ?? '', 'on'); ?>>
            <div class="dwp-checkmark"></div>
            <div class="dwp-checkbox-label"><?php esc_html_e('Show Description', 'dw-picha-changelog'); ?></div>
        </label>
    </div>
    <div class="dwp-select-wrapper">
        <label><?php esc_html_e('Template', 'dw-picha-changelog'); ?></label>
        <select name="dwp_option[template]">
            <?php foreach (dwpicha313_get_templates() as $slug => $label): ?>
                <option value="<?php echo esc_attr($slug); ?>"
                    <?php selected($postMeta['template'] ?? '1', $slug); ?>>
                    <?php echo esc_html($label); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php
    // Existing template select ends here...
    $appearance = $postMeta['appearance'] ?? [];
    $custom_enabled = !empty($appearance['enabled']);
    $custom_primary = $appearance['primary'] ?? '#f0932b';
    $custom_text    = $appearance['text']    ?? '#1d2327';
    $custom_surface = $appearance['surface'] ?? '#ffffff';
    $color_mode     = $appearance['color_mode'] ?? 'auto';
    ?>

    <!-- Appearance Section -->
    <div class="dwp-appearance-section">
        <div class="dwp-appearance-header">
            <span class="dwp-appearance-title"><?php esc_html_e('Appearance', 'dw-picha-changelog'); ?></span>
        </div>

        <!-- Toggle: Use custom colors -->
        <div class="dwp-checkbox-wrapper">
            <label class="dwp-checkbox">
                <input type="checkbox"
                    value="on"
                    name="dwp_option[appearance][enabled]"
                    id="dwp-custom-colors-toggle"
                    <?php checked($custom_enabled); ?>>
                <div class="dwp-checkmark"></div>
                <div class="dwp-checkbox-label"><?php esc_html_e('Use custom colors', 'dw-picha-changelog'); ?></div>
            </label>
        </div>

        <!-- Color pickers (hidden until toggle is on) -->
        <div class="dwp-color-pickers" id="dwp-color-pickers" <?php echo $custom_enabled ? '' : 'style="display:none;"'; ?>>
            <div class="dwp-color-field">
                <label for="dwp-color-primary"><?php esc_html_e('Primary color', 'dw-picha-changelog'); ?></label>
                <input type="text"
                    id="dwp-color-primary"
                    name="dwp_option[appearance][primary]"
                    value="<?php echo esc_attr($custom_primary); ?>"
                    class="dwp-color-picker"
                    data-default-color="#f0932b">
            </div>

            <div class="dwp-color-field">
                <label for="dwp-color-text"><?php esc_html_e('Text color', 'dw-picha-changelog'); ?></label>
                <input type="text"
                    id="dwp-color-text"
                    name="dwp_option[appearance][text]"
                    value="<?php echo esc_attr($custom_text); ?>"
                    class="dwp-color-picker"
                    data-default-color="#1d2327">
            </div>

            <div class="dwp-color-field">
                <label for="dwp-color-surface"><?php esc_html_e('Surface color', 'dw-picha-changelog'); ?></label>
                <input type="text"
                    id="dwp-color-surface"
                    name="dwp_option[appearance][surface]"
                    value="<?php echo esc_attr($custom_surface); ?>"
                    class="dwp-color-picker"
                    data-default-color="#ffffff">
            </div>

            <button type="button" class="dwp-btn dwp-btn-secondary dwp-reset-colors">
                <span class="dashicons dashicons-image-rotate"></span>
                <?php esc_html_e('Reset to defaults', 'dw-picha-changelog'); ?>
            </button>
        </div>

        <!-- Color mode -->
        <div class="dwp-color-mode">
            <label class="dwp-color-mode-label"><?php esc_html_e('Color mode', 'dw-picha-changelog'); ?></label>
            <div class="dwp-color-mode-options">
                <label class="dwp-radio">
                    <input type="radio" name="dwp_option[appearance][color_mode]" value="auto" <?php checked($color_mode, 'auto'); ?>>
                    <span><?php esc_html_e('Auto (follow system)', 'dw-picha-changelog'); ?></span>
                </label>
                <label class="dwp-radio">
                    <input type="radio" name="dwp_option[appearance][color_mode]" value="light" <?php checked($color_mode, 'light'); ?>>
                    <span><?php esc_html_e('Always light', 'dw-picha-changelog'); ?></span>
                </label>
                <label class="dwp-radio">
                    <input type="radio" name="dwp_option[appearance][color_mode]" value="dark" <?php checked($color_mode, 'dark'); ?>>
                    <span><?php esc_html_e('Always dark', 'dw-picha-changelog'); ?></span>
                </label>
            </div>
        </div>
    </div>

<?php
}

add_action('save_post', 'dwpicha313_save_meta_box_data');
function dwpicha313_save_meta_box_data($post_id)
{
    // Ensure it's our post type.
    if (get_post_type($post_id) !== 'dw_picha_changelog') {
        return;
    }

    // Only run on our meta box submission.
    if (!isset($_POST['dwp_meta_box_present'])) {
        return;
    }

    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }

    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    if (!isset($_POST['dwp_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['dwp_nonce'])), 'dwp_save_meta_box')) {
        return;
    }

    // Save options.
    if (isset($_POST['dwp_option']) && is_array($_POST['dwp_option'])) {
        $sanitized_options = array_map('sanitize_text_field', wp_unslash($_POST['dwp_option']));
        
        // Sanitize appearance (nested array)
        if (isset($_POST['dwp_option']['appearance']) && is_array($_POST['dwp_option']['appearance'])) {
            $app_raw = wp_unslash($_POST['dwp_option']['appearance']);
            $appearance = [
                'enabled'    => !empty($app_raw['enabled']) ? 'on' : '',
                'primary'    => dwpicha313_is_valid_hex($app_raw['primary'] ?? '') ? $app_raw['primary'] : '#f0932b',
                'text'       => dwpicha313_is_valid_hex($app_raw['text'] ?? '')    ? $app_raw['text']    : '#1d2327',
                'surface'    => dwpicha313_is_valid_hex($app_raw['surface'] ?? '') ? $app_raw['surface'] : '#ffffff',
                'color_mode' => in_array($app_raw['color_mode'] ?? 'auto', ['auto', 'light', 'dark'], true)
                    ? $app_raw['color_mode']
                    : 'auto',
            ];
            $sanitized_options['appearance'] = $appearance;
        } else {
            unset($sanitized_options['appearance']);
        }

        update_post_meta($post_id, '_dwp_changelog_options', $sanitized_options);
    } else {
        delete_post_meta($post_id, '_dwp_changelog_options');
    }

    // Save changelog data.
    if (isset($_POST['dwp']) && is_array($_POST['dwp'])) {
        $sanitized_data = dwpicha313_sanitize_recursive(wp_unslash($_POST['dwp']));
        update_post_meta($post_id, '_dwp_changelog', $sanitized_data);
    } else {
        delete_post_meta($post_id, '_dwp_changelog');
    }
}

function dwpicha313_sanitize_recursive($data)
{
    if (is_array($data)) {
        return array_map('dwpicha313_sanitize_recursive', $data);
    }
    if (is_string($data)) {
        return sanitize_text_field($data);
    }
    if (is_int($data) || is_float($data)) {
        return $data;
    }
    if (is_bool($data)) {
        return $data ? 1 : 0;
    }
    if (is_null($data)) {
        return null;
    }
    if (is_object($data)) {
        return (array) $data;
    }
    return '';
}
