/**
 * Picha Changelog — Admin JS
 */
(function ($) {
    'use strict';

    // ============================================================
    // Utility functions
    // ============================================================

    /**
     * Escape HTML for safe insertion into attributes/values.
     */
    function escapeHtml(str) {
        return $('<div>').text(str == null ? '' : String(str)).html();
    }

    /**
     * Build the status <option> list once and reuse.
     */
    var STATUS_LIST = ['added', 'fixed', 'updated', 'improved', 'removed', 'deprecated', 'compatibility', 'special'];

    function buildStatusOptions(selected) {
        var html = '';
        STATUS_LIST.forEach(function (status) {
            var sel = (status === selected) ? ' selected' : '';
            html += '<option value="' + status + '"' + sel + '>' + escapeHtml(dwp[status] || status) + '</option>';
        });
        return html;
    }

    /**
     * Build a single log row <li>.
     */
    function buildRow(index, itemIndex, value, status) {
        status = status || 'added';
        return $(
            '<li class="dwp-body-row">' +
                '<div class="dwp-row-drag" title="' + escapeHtml(dwp.dragToReorder) + '">' +
                    '<span class="dashicons dashicons-menu"></span>' +
                '</div>' +
                '<div class="dwp-row-status">' +
                    '<select name="dwp[' + index + '][item][' + itemIndex + '][status]" ' +
                        'class="dwp-status-select dwp-status-' + status + '">' +
                        buildStatusOptions(status) +
                    '</select>' +
                '</div>' +
                '<div class="dwp-row-content">' +
                    '<input type="text" ' +
                        'name="dwp[' + index + '][item][' + itemIndex + '][content]" ' +
                        'value="' + escapeHtml(value) + '" ' +
                        'class="dwp-input" ' +
                        'placeholder="' + escapeHtml(dwp.describeChange) + '">' +
                '</div>' +
                '<button type="button" class="dwp-icon-btn dwp-icon-btn-danger dw-delete-row" ' +
                    'title="' + escapeHtml(dwp.delete) + '" ' +
                    'aria-label="' + escapeHtml(dwp.delete) + '">' +
                    '<span class="dashicons dashicons-trash"></span>' +
                '</button>' +
            '</li>'
        );
    }

    /**
     * Build a complete new version section.
     */
    function buildSection(index) {
        return $(
            '<div class="dwp-box" data-index="' + index + '">' +
                '<div class="dwp-header">' +
                    '<div class="dwp-drag-handle" title="' + escapeHtml(dwp.dragToReorder) + '">' +
                        '<span class="dashicons dashicons-menu"></span>' +
                    '</div>' +
                    '<div class="dwp-header-main">' +
                        '<div class="dwp-header-row">' +
                            '<div class="dwp-field dwp-field-version">' +
                                '<label>' + escapeHtml(dwp.version) + '</label>' +
                                '<input type="text" name="dwp[' + index + '][version]" ' +
                                    'class="dwp-input dwp-input-version" ' +
                                    'placeholder="' + escapeHtml(dwp.versionPlaceholder) + '">' +
                            '</div>' +
                            '<div class="dwp-field dwp-field-jdate">' +
                                '<label>' + escapeHtml(dwp.jalaliDate) + '</label>' +
                                '<input type="text" name="dwp[' + index + '][jalali_date]" ' +
                                    'data-jdp data-jdp-only-date ' +
                                    'class="dwp-input dwp-input-date" ' +
                                    'placeholder="' + escapeHtml(dwp.jalaliPlaceholder) + '">' +
                            '</div>' +
                            '<div class="dwp-field dwp-field-gdate">' +
                                '<label>' + escapeHtml(dwp.gregorianDate) + '</label>' +
                                '<input type="date" name="dwp[' + index + '][gregorian_date]" ' +
                                    'class="dwp-input dwp-input-date">' +
                            '</div>' +
                        '</div>' +
                    '</div>' +
                    '<div class="dwp-header-actions">' +
                        '<span class="dwp-item-count" title="' + escapeHtml(dwp.itemCountTitle) + '">' +
                            '0 <span class="dashicons dashicons-list-view"></span>' +
                        '</span>' +
                        '<button type="button" class="dwp-icon-btn dw-duplicate-section" ' +
                            'title="' + escapeHtml(dwp.duplicate) + '" ' +
                            'aria-label="' + escapeHtml(dwp.duplicate) + '">' +
                            '<span class="dashicons dashicons-admin-page"></span>' +
                        '</button>' +
                        '<button type="button" class="dwp-icon-btn dwp-icon-btn-danger dw-delete-section" ' +
                            'title="' + escapeHtml(dwp.delete) + '" ' +
                            'aria-label="' + escapeHtml(dwp.delete) + '">' +
                            '<span class="dashicons dashicons-trash"></span>' +
                        '</button>' +
                    '</div>' +
                '</div>' +
                '<div class="dwp-body">' +
                    '<div class="dwp-description-wrapper">' +
                        '<label class="dwp-description-label">' +
                            escapeHtml(dwp.description) +
                            '<span class="dwp-hint">' + escapeHtml(dwp.descriptionHint) + '</span>' +
                        '</label>' +
                        '<textarea name="dwp[' + index + '][description]" rows="3" ' +
                            'class="dwp-textarea" ' +
                            'placeholder="' + escapeHtml(dwp.descriptionPlaceholder) + '"></textarea>' +
                    '</div>' +
                    '<div class="dwp-items-section">' +
                        '<div class="dwp-items-header">' +
                            '<span class="dwp-items-title">' + escapeHtml(dwp.logEntries) + '</span>' +
                            '<div class="dwp-items-actions">' +
                                '<button type="button" class="dwp-btn dwp-btn-secondary dwp-add-bulk-log" ' +
                                    'data-index="' + index + '">' +
                                    '<span class="dashicons dashicons-editor-ul"></span> ' +
                                    escapeHtml(dwp.addBulk) +
                                '</button>' +
                                '<button type="button" class="dwp-btn dwp-btn-primary dwp-add-log" ' +
                                    'data-index="' + index + '">' +
                                    '<span class="dashicons dashicons-plus-alt"></span> ' +
                                    escapeHtml(dwp.add) +
                                '</button>' +
                            '</div>' +
                        '</div>' +
                        '<div class="dwp-bulk-area-wrapper">' +
                            '<div class="dwp-bulk-hint">' +
                                '<span class="dashicons dashicons-info-outline"></span> ' +
                                escapeHtml(dwp.bulkDesc) +
                            '</div>' +
                            '<textarea class="dwp-area-items dwp-textarea" rows="5" ' +
                                'placeholder="' + escapeHtml(dwp.bulkPlaceholder) + '"></textarea>' +
                            '<div class="dwp-bulk-footer">' +
                                '<button type="button" class="dwp-btn dwp-btn-secondary dwp-bulk-cancel">' +
                                    escapeHtml(dwp.cancel) +
                                '</button>' +
                                '<button type="button" class="dwp-btn dwp-btn-primary dwp-bulk-add-items" ' +
                                    'data-index="' + index + '">' +
                                    '<span class="dashicons dashicons-yes"></span> ' +
                                    escapeHtml(dwp.addAll) +
                                '</button>' +
                            '</div>' +
                        '</div>' +
                        '<ul class="dwp-body-area dwp-items-list"></ul>' +
                        '<div class="dwp-empty-items">' +
                            '<span class="dashicons dashicons-editor-ul"></span>' +
                            '<p>' + escapeHtml(dwp.noEntries) + '</p>' +
                        '</div>' +
                    '</div>' +
                '</div>' +
            '</div>'
        );
    }

    // ============================================================
    // Jalali datepicker
    // ============================================================

    function refreshJalali() {
        if (typeof jalaliDatepicker === 'undefined') {
            return;
        }
        try {
            jalaliDatepicker.startWatch({
                minDate: 'attr',
                maxDate: 'attr',
                zIndex: 99999,
                time: false,
                separatorChars: { between: ' - ' }
            });
        } catch (e) {
            // Ignore — picker may already be watching these inputs.
        }
    }

    // ============================================================
    // Sortable (drag & drop)
    // ============================================================

    function initSectionSortable() {
        if (!$.fn.sortable) {
            return;
        }
        var $list = $('#dwp-box-list');
        if ($list.hasClass('ui-sortable')) {
            return; // already initialized
        }
        $list.sortable({
            items: '.dwp-box',
            handle: '.dwp-drag-handle',
            placeholder: 'dwp-sortable-placeholder',
            forcePlaceholderSize: true,
            tolerance: 'pointer',
            stop: function () {
                reindexAll();
            }
        });
    }

    function initRowSortable($scope) {
        if (!$.fn.sortable) {
            return;
        }
        $scope = $scope || $('.dwp-items-list');
        $scope.each(function () {
            var $ul = $(this);
            if ($ul.hasClass('ui-sortable')) {
                return;
            }
            $ul.sortable({
                items: '.dwp-body-row',
                handle: '.dwp-row-drag',
                placeholder: 'dwp-sortable-placeholder',
                forcePlaceholderSize: true,
                tolerance: 'pointer'
            });
        });
    }

    // ============================================================
    // Index maintenance (critical after sort/duplicate/delete)
    // ============================================================

    function reindexAll() {
        $('#dwp-box-list > .dwp-box').each(function (sectionIndex) {
            var $box = $(this);
            $box.attr('data-index', sectionIndex);

            // Update all names inside this box that start with dwp[N]
            $box.find('input, select, textarea').each(function () {
                var $el = $(this);
                var name = $el.attr('name');
                if (!name) {
                    return;
                }
                name = name.replace(/^dwp\[\d+\]/, 'dwp[' + sectionIndex + ']');
                // Re-index item rows too
                name = name.replace(/\[item\]\[\d+\]/, function (match) {
                    var $row = $el.closest('.dwp-body-row');
                    var rowIdx = $row.index();
                    return '[item][' + rowIdx + ']';
                });
                $el.attr('name', name);
            });

            // Update data-index attributes on buttons inside this box
            $box.find('[data-index]').attr('data-index', sectionIndex);

            // Update item counter
            updateItemCount($box);
        });

        updateVersionCount();
    }

    function updateItemCount($box) {
        var count = $box.find('.dwp-body-row').length;
        $box.find('.dwp-item-count').html(
            count + ' <span class="dashicons dashicons-list-view"></span>'
        );
        $box.find('.dwp-empty-items').toggle(count === 0);
    }

    function updateVersionCount() {
        var count = $('#dwp-box-list > .dwp-box').length;
        $('.dwp-version-count strong').text(count);

        // Show/hide empty state
        var $empty = $('.dwp-empty-state');
        if (count === 0 && !$empty.length) {
            // Insert empty state HTML
            var emptyHtml =
                '<div class="dwp-empty-state">' +
                    '<div class="dwp-empty-icon">' +
                        '<span class="dashicons dashicons-clipboard"></span>' +
                    '</div>' +
                    '<h3>' + escapeHtml(dwp.emptyTitle) + '</h3>' +
                    '<p>' + escapeHtml(dwp.emptyDesc) + '</p>' +
                    '<button type="button" class="dwp-btn dwp-btn-primary dw-add-new">' +
                        '<span class="dashicons dashicons-plus-alt"></span> ' +
                        escapeHtml(dwp.createFirst) +
                    '</button>' +
                '</div>';
            $('#dwp-box-list').html(emptyHtml);
        } else if (count > 0 && $empty.length) {
            $empty.remove();
        }
    }

    // ============================================================
    // Document ready
    // ============================================================

    $(document).ready(function () {
        refreshJalali();
        initSectionSortable();
        initRowSortable();

        // Shortcode input: select on click
        $(document).on('click', '.dwp_shortcode', function () {
            this.select();
        });

        // ---------------------------------------------
        // Add new version
        // ---------------------------------------------
        $(document).on('click', '.dw-add-new', function (e) {
            e.preventDefault();

            // Remove empty state if present
            $('#dwp-box-list .dwp-empty-state').remove();

            var index = $('#dwp-box-list > .dwp-box').length;
            var $section = buildSection(index);
            $('#dwp-box-list').prepend($section);

            refreshJalali();
            initSectionSortable();
            initRowSortable($section.find('.dwp-items-list'));
            reindexAll();

            // Focus on the version input
            $section.find('.dwp-input-version').trigger('focus');
        });

        // ---------------------------------------------
        // Toggle bulk area
        // ---------------------------------------------
        $(document).on('click', '.dwp-add-bulk-log', function (e) {
            e.preventDefault();
            var $wrapper = $(this).closest('.dwp-items-section').find('.dwp-bulk-area-wrapper');
            $wrapper.slideToggle(200, function () {
                if ($(this).is(':visible')) {
                    $(this).find('.dwp-area-items').trigger('focus');
                }
            });
        });

        // Cancel bulk
        $(document).on('click', '.dwp-bulk-cancel', function (e) {
            e.preventDefault();
            $(this).closest('.dwp-bulk-area-wrapper').slideUp(200);
        });

        // ---------------------------------------------
        // Add single log row
        // ---------------------------------------------
        $(document).on('click', '.dwp-add-log', function (e) {
            e.preventDefault();
            var $btn = $(this);
            var $box = $btn.closest('.dwp-box');
            var index = $box.attr('data-index');
            var itemIndex = $box.find('.dwp-body-row').length;

            var $row = buildRow(index, itemIndex, '', 'added');
            $box.find('.dwp-items-list').append($row);

            // Reinitialize sortable if this list wasn't sortable yet
            initRowSortable($box.find('.dwp-items-list'));

            // Update state
            updateItemCount($box);

            // Focus the new content input
            $row.find('input[type="text"]').trigger('focus');
        });

        // ---------------------------------------------
        // Bulk add rows
        // ---------------------------------------------
        $(document).on('click', '.dwp-bulk-add-items', function (e) {
            e.preventDefault();
            var $btn = $(this);
            var $box = $btn.closest('.dwp-box');
            var $wrapper = $btn.closest('.dwp-bulk-area-wrapper');
            var $textarea = $wrapper.find('.dwp-area-items');

            var raw = $textarea.val() || '';
            var lines = raw.split('\n').filter(function (line) {
                return line.trim() !== '';
            });

            if (!lines.length) {
                $textarea.trigger('focus');
                return;
            }

            var index = $box.attr('data-index');
            var itemIndex = $box.find('.dwp-body-row').length;
            var $list = $box.find('.dwp-items-list');

            lines.forEach(function (line) {
                var $row = buildRow(index, itemIndex, line.trim(), 'added');
                $list.append($row);
                itemIndex++;
            });

            $textarea.val('');
            $wrapper.slideUp(200);
            initRowSortable($list);
            updateItemCount($box);
        });

        // ---------------------------------------------
        // Delete row
        // ---------------------------------------------
        $(document).on('click', '.dw-delete-row', function (e) {
            e.preventDefault();
            var $box = $(this).closest('.dwp-box');
            $(this).closest('.dwp-body-row').remove();
            updateItemCount($box);
        });

        // ---------------------------------------------
        // Delete section
        // ---------------------------------------------
        $(document).on('click', '.dw-delete-section', function (e) {
            e.preventDefault();
            if (!window.confirm(dwp.confirmDelete)) {
                return;
            }
            $(this).closest('.dwp-box').remove();
            reindexAll();
            updateVersionCount();
        });

        // ---------------------------------------------
        // Duplicate section (full copy including items)
        // ---------------------------------------------
        $(document).on('click', '.dw-duplicate-section', function (e) {
            e.preventDefault();
            var $box = $(this).closest('.dwp-box');
            var $clone = $box.clone();

            // Preserve all values (version, dates, description, items, statuses).
            // Only the jalali datepicker needs re-binding on the clone because
            // cloned inputs lose their picker instance.

            // Insert clone after original
            $box.after($clone);

            // Refresh the Jalali datepicker for the cloned inputs
            refreshJalali();

            // Re-init sortable on the cloned items list
            initRowSortable($clone.find('.dwp-items-list'));

            // Re-index all names to keep PHP arrays clean
            reindexAll();

            // Update the item counter for the clone
            updateItemCount($clone);

            // Focus on version input of the clone (so user can edit)
            $clone.find('.dwp-input-version').trigger('focus');
        });

        // ---------------------------------------------
        // Status select: change color class
        // ---------------------------------------------
        $(document).on('change', '.dwp-status-select', function () {
            var val = $(this).val();
            $(this).removeClass(function (i, c) {
                return (c.match(/dwp-status-\S+/g) || []).join(' ');
            }).addClass('dwp-status-' + val);
        });

        // ============================================================
        // LIVE PREVIEW
        // ============================================================

 function collectFormData() {
    var logs = [];
    var options = {};

    // Simple checkboxes (dwp_option[version], dwp_option[desc], ...)
    $('input[type="checkbox"][name^="dwp_option["]').each(function () {
        var name = $(this).attr('name');
        var match = name.match(/^dwp_option\[([^\[\]]+)\]$/);
        if (match) {
            options[match[1]] = this.checked ? 'on' : '';
        }
    });

    // Template select
    var template = $('select[name="dwp_option[template]"]').val();
    if (template) {
        options.template = template;
    }

    // Appearance (nested)
    var appearance = {};
    var appearanceEnabled = $('#dwp-custom-colors-toggle').is(':checked');
    if (appearanceEnabled) {
        appearance.enabled = 'on';
        appearance.primary = $('#dwp-color-primary').val() || '';
        appearance.text = $('#dwp-color-text').val() || '';
        appearance.surface = $('#dwp-color-surface').val() || '';
    }
    var colorMode = $('input[name="dwp_option[appearance][color_mode]"]:checked').val();
    if (colorMode) {
        appearance.color_mode = colorMode;
    }
    if (Object.keys(appearance).length) {
        options.appearance = appearance;
    }

    // Versions — unchanged
    $('#dwp-box-list > .dwp-box').each(function () {
        var $box = $(this);
        var entry = {
            version:        $box.find('input[name$="[version]"]').val() || '',
            jalali_date:    $box.find('input[name$="[jalali_date]"]').val() || '',
            gregorian_date: $box.find('input[name$="[gregorian_date]"]').val() || '',
            description:    $box.find('textarea[name$="[description]"]').val() || '',
            item:           []
        };
        $box.find('.dwp-body-area > .dwp-body-row').each(function () {
            var $row = $(this);
            entry.item.push({
                status:  $row.find('select').val() || 'added',
                content: $row.find('input[type="text"]').val() || ''
            });
        });
        if (entry.version || entry.description || entry.item.length) {
            logs.push(entry);
        }
    });

    return { logs: logs, options: options };
}

        function openPreviewModal() {
            $('#dwp-preview-modal').show().attr('aria-hidden', 'false');
            $('body').addClass('dwp-preview-open');
        }

        function closePreviewModal() {
            $('#dwp-preview-modal').hide().attr('aria-hidden', 'true');
            $('body').removeClass('dwp-preview-open');
        }

        $(document).on('click', '.dw-preview-btn', function (e) {
            e.preventDefault();

            var data = collectFormData();

            if (!data.logs.length) {
                window.alert(dwp.previewEmpty);
                return;
            }

            var $modal   = $('#dwp-preview-modal');
            var $loading = $modal.find('.dwp-preview-loading');
            var $content = $modal.find('.dwp-preview-content');
            var $error   = $modal.find('.dwp-preview-error');

            $loading.show();
            $content.empty();
            $error.hide().empty();
            openPreviewModal();

            $.ajax({
                url: dwp.ajaxUrl,
                type: 'POST',
                dataType: 'json',
                data: {
                    action:  'dwpicha313_preview',
                    nonce:   dwp.nonce,
                    logs:    JSON.stringify(data.logs),
                    options: JSON.stringify(data.options)
                }
            })
            .done(function (response) {
                $loading.hide();
                if (response && response.success && response.data && response.data.html) {
                    $content.html(response.data.html);
                } else {
                    var msg = (response && response.data && response.data.message)
                        ? response.data.message
                        : dwp.previewError;
                    $error.text(msg).show();
                }
            })
            .fail(function () {
                $loading.hide();
                $error.text(dwp.previewError).show();
            });
        });

        $(document).on('click', '.dwp-preview-close, .dwp-preview-overlay', function (e) {
            e.preventDefault();
            closePreviewModal();
        });

        $(document).on('keyup', function (e) {
            if (e.key === 'Escape' && $('#dwp-preview-modal').is(':visible')) {
                closePreviewModal();
            }
        });

        // ============================================================
// APPEARANCE — Color Pickers
// ============================================================

// Initialize WP color pickers
if ($.fn.wpColorPicker) {
    $('.dwp-color-picker').wpColorPicker({
        change: function (event, ui) {
            // Optional: live preview update
        },
        clear: function () {
            // Optional: reset to default
        }
    });
}

// Toggle color pickers visibility
$(document).on('change', '#dwp-custom-colors-toggle', function () {
    var $pickers = $('#dwp-color-pickers');
    if (this.checked) {
        $pickers.slideDown(200);
    } else {
        $pickers.slideUp(200);
    }
});

// Reset colors to defaults
$(document).on('click', '.dwp-reset-colors', function (e) {
    e.preventDefault();

    if (!window.confirm(dwp.confirmResetColors)) {
        return;
    }

    var defaults = {
        '#dwp-color-primary': '#f0932b',
        '#dwp-color-text':    '#1d2327',
        '#dwp-color-surface': '#ffffff'
    };

    $.each(defaults, function (selector, value) {
        var $input = $(selector);
        if ($input.length) {
            $input.val(value);
            // Refresh color picker UI
            if ($input.hasClass('wp-color-picker')) {
                $input.wpColorPicker('color', value);
            }
        }
    });
});
    });

})(jQuery);