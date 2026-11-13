<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Add meta boxes
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

// Changelog Meta Box Callback
function dwpicha313_meta_box($post)
{
    $postMeta = maybe_unserialize(get_post_meta($post->ID, '_dwp_changelog', true));
    wp_nonce_field('dwp_save_meta_box', 'dwp_nonce');
?>
    <div class="dw-meta-options">
        <div class="dw-box-header">
            <div class="dw-add-new"><?php esc_html_e('Add New Version', 'dw-picha-changelog'); ?></div>
        </div>
        <div id="dwp-box-list">
            <div class="dwp-body-area">
                <?php if ($postMeta): ?>
                    <?php foreach ($postMeta as $index => $changelog): ?>
                        <div class="dwp-box">
                            <div class="dwp-header">
                                <div class="dwp-info">
                                    <div>
                                        <div>
                                            <label>
                                                <?php esc_html_e('Version', 'dw-picha-changelog'); ?>
                                                <input type="text" name="dwp[<?php echo esc_attr($index); ?>][version]"
                                                    value="<?php echo esc_attr($changelog['version'] ?? ''); ?>">
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <?php _e('Jalali Date', 'dw-picha-changelog') ?>
                                                <input type="text"
                                                    name="dwp[<?php echo $index ?>][jalali_date]"
                                                    value="<?php echo $changelog['jalali_date'] ?? '' ?>"
                                                    data-jdp
                                                    data-jdp-only-date>
                                            </label>
                                        </div>
                                        <div>
                                            <label>
                                                <?php esc_html_e('Date', 'dw-picha-changelog'); ?>
                                                <input type="date"
                                                    name="dwp[<?php echo esc_attr($index); ?>][gregorian_date]"
                                                    value="<?php echo esc_attr($changelog['gregorian_date'] ?? ''); ?>">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="dw-delete-section dashicons dashicons-trash"></div>
                                </div>
                            </div>
                            <div class="dwp-body">
                                <div class="dwp-add-log" data-index="<?php echo esc_attr($index); ?>">
                                    <?php esc_html_e('Add Log', 'dw-picha-changelog'); ?>
                                </div>
                                <div class="dwp-add-bulk-log"
                                    data-index="<?php echo $index ?>"><?php _e('Add Bulk Log', 'dw-picha-changelog') ?></div>
                                <div class="dwp-bulk-area-wrapper">
                                    <div><?php _e('Put each item on a line.', 'dw-picha-changelog') ?></div>
                                    <textarea class="dwp-area-items" rows="10"></textarea>
                                    <span class="dwp-bulk-add-items"
                                        data-index="<?php echo $index ?>"><?php _e('Add', 'dw-picha-changelog') ?></span>
                                </div>
                                <div class="dwp_description">
                                    <label>
                                        <?php _e('Description', 'dw-picha-changelog') ?>
                                        <textarea
                                            name="dwp[<?php echo $index ?>][description]"><?php echo $changelog['description'] ?? '' ?></textarea>
                                    </label>
                                </div>
                                <ul id="dwp-body-area">
                                    <?php if (isset($changelog['item'])): ?>
                                        <?php foreach ($changelog['item'] as $itemIndex => $item): ?>
                                            <li class="dwp-body-row">
                                                <div>
                                                    <select name="dwp[<?php echo esc_attr($index); ?>][item][<?php echo esc_attr($itemIndex); ?>][status]">
                                                        <?php
                                                        $statuses = [
                                                            'added' => __('New', 'dw-picha-changelog'),
                                                            'fixed' => __('Fixed', 'dw-picha-changelog'),
                                                            'updated' => __('Update', 'dw-picha-changelog'),
                                                            'improved' => __('Improvement', 'dw-picha-changelog'),
                                                            'removed' => __('Remove', 'dw-picha-changelog'),
                                                            'deprecated' => __('Obsolete', 'dw-picha-changelog'),
                                                            'compatibility' => __('Compatibility', 'dw-picha-changelog'),
                                                            'special' => __('Special', 'dw-picha-changelog'),
                                                        ];
                                                        foreach ($statuses as $value => $label): ?>
                                                            <option value="<?php echo esc_attr($value); ?>" <?php selected($item['status'], $value); ?>><?php echo esc_html($label); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="dwp-row-log">
                                                    <input type="text"
                                                        name="dwp[<?php echo esc_attr($index); ?>][item][<?php echo esc_attr($itemIndex); ?>][content]"
                                                        value="<?php echo esc_attr($item['content'] ?? ''); ?>">
                                                </div>
                                                <div class="dw-delete-row dashicons dashicons-trash"></div>
                                            </li>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <input type="hidden" name="meta_box_flag" value="true">
<?php
}

// Changelog Options Meta Box Callback
function dwpicha313_options_meta_box($post)
{
    wp_nonce_field('dwp_save_meta_box', 'dwp_nonce');
    $postMeta = maybe_unserialize(get_post_meta($post->ID, '_dwp_changelog_options', true));
?>
    <div class="dwp-checkbox-wrapper">
        <label class="dwp-checkbox">
            <input type="checkbox" value="on"
                name="dwp_option[version]" <?php checked(isset($postMeta['version']) ? $postMeta['version'] : '', 'on'); ?>>
            <div class="dwp-checkmark"></div>
            <div class="dwp-checkbox-label"><?php esc_html_e('Show Version', 'dw-picha-changelog'); ?></div>
        </label>
    </div>
    <div class="dwp-checkbox-wrapper">
        <label class="dwp-checkbox">
            <input type="checkbox" value="on"
                name="dwp_option[j_date]" <?php checked(isset($postMeta['j_date']) ? $postMeta['j_date'] : '', 'on'); ?>>
            <div class="dwp-checkmark"></div>
            <div class="dwp-checkbox-label"><?php esc_html_e('Show Jalali Date', 'dw-picha-changelog') ?></div>
        </label>
    </div>
    <div class="dwp-checkbox-wrapper">
        <label class="dwp-checkbox">
            <input type="checkbox" value="on"
                name="dwp_option[g_date]" <?php checked(isset($postMeta['g_date']) ? $postMeta['g_date'] : '', 'on'); ?>>
            <div class="dwp-checkmark"></div>
            <div class="dwp-checkbox-label"><?php esc_html_e('Show Gregorian date', 'dw-picha-changelog'); ?></div>
        </label>
    </div>
    <div class="dwp-checkbox-wrapper">
        <label class="dwp-checkbox">
            <input type="checkbox" value="on"
                name="dwp_option[desc]" <?php checked(isset($postMeta['desc']) ? $postMeta['desc'] : '', 'on'); ?>>
            <div class="dwp-checkmark"></div>
            <div class="dwp-checkbox-label"><?php esc_html_e('Show Description', 'dw-picha-changelog') ?></div>
        </label>
    </div>
    <div class="dwp-select-wrapper">
        <label><?php esc_html_e('Template', 'dw-picha-changelog'); ?></label>
        <select name="dwp_option[template]">
            <option value="1" <?php selected(isset($postMeta['template']) ? $postMeta['template'] : '', 1); ?>><?php esc_html_e('Template 1', 'dw-picha-changelog') ?></option>
            <option value="2" <?php selected(isset($postMeta['template']) ? $postMeta['template'] : '', 2); ?>><?php esc_html_e('Template 2', 'dw-picha-changelog') ?></option>
            <option value="3" <?php selected(isset($postMeta['template']) ? $postMeta['template'] : '', 3); ?>><?php esc_html_e('Template 3', 'dw-picha-changelog') ?></option>
            <option value="4" <?php selected(isset($postMeta['template']) ? $postMeta['template'] : '', 4); ?>><?php esc_html_e('Template 4', 'dw-picha-changelog') ?></option>
        </select>
    </div>
<?php
}

// Save Meta Box Data
add_action('save_post', 'dwpich313_save_meta_box_data');
function dwpich313_save_meta_box_data($post_id)
{
    if (!isset($_POST['meta_box_flag'])) {
        return;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    if (!isset($_POST['dwp_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['dwp_nonce'])), 'dwp_save_meta_box')) {
        return;
    }

    // Save Changelog Options
    if (isset($_POST['dwp_option'])) {
        $sanitized_options = array_map('sanitize_text_field', wp_unslash($_POST['dwp_option']));
        update_post_meta($post_id, '_dwp_changelog_options', $sanitized_options);
    } else {
        delete_post_meta($post_id, '_dwp_changelog_options');
    }

    // Save Changelog Data
    if (isset($_POST['dwp'])) {
        $sanitized_data = dwpich313_sanitize_recursive(wp_unslash($_POST['dwp']));
        update_post_meta($post_id, '_dwp_changelog', $sanitized_data);
    } else {
        delete_post_meta($post_id, '_dwp_changelog');
    }
}

// Recursive Sanitization Function
function dwpich313_sanitize_recursive($data)
{
    if (is_array($data)) {
        return array_map('dwpich313_sanitize_recursive', $data);
    } elseif (is_string($data)) {
        return sanitize_text_field($data);
    } elseif (is_int($data) || is_float($data)) {
        return $data;
    } elseif (is_bool($data)) {
        return $data ? 1 : 0;
    } elseif (is_null($data)) {
        return null;
    } elseif (is_object($data)) {
        return (array) $data;
    } else {
        return '';
    }
}