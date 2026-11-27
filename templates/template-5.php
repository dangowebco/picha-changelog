<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="dwpTemplate dwpTempAccordion">
    <?php
    $first_item = true;
    foreach ($change_logs as $changelog):
        $version        = $changelog['version'] ?? '';
        $jalali_date    = $changelog['jalali_date'] ?? '';
        $gregorian_date = $changelog['gregorian_date'] ?? '';
        $description    = $changelog['description'] ?? '';
        $items          = $changelog['item'] ?? [];
        $item_count     = count($items);

        // Build date parts
        $date_parts = [];
        if (!empty($change_options['j_date']) && $jalali_date) {
            $date_parts[] = esc_html($jalali_date);
        }
        if (!empty($change_options['g_date']) && $gregorian_date) {
            $date_parts[] = esc_html($gregorian_date);
        }

        // Entry count label
        $entry_label = sprintf(
            _n('%s entry', '%s entries', $item_count, 'dw-picha-changelog'),
            number_format_i18n($item_count)
        );
        ?>
        <details class="dwpAccordionItem" <?php echo $first_item ? 'open' : ''; ?>>
            <summary class="dwpAccordionSummary">
                <span class="dwpAccordionChevron" aria-hidden="true">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4 6l4 4 4-4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>

                <span class="dwpAccordionHeaderContent">
                    <?php if (!empty($change_options['version']) && $version): ?>
                        <span class="dwpAccordionVersion"><?php echo esc_html($version); ?></span>
                    <?php endif; ?>

                    <?php if (!empty($date_parts)): ?>
                        <span class="dwpAccordionDate"><?php echo implode(' · ', $date_parts); ?></span>
                    <?php endif; ?>

                    <?php if ($item_count > 0): ?>
                        <span class="dwpAccordionCount"><?php echo esc_html($entry_label); ?></span>
                    <?php endif; ?>
                </span>
            </summary>

            <div class="dwpAccordionBody">
                <?php if (!empty($change_options['desc']) && $description): ?>
                    <div class="dwpAccordionDesc"><?php echo wp_kses_post($description); ?></div>
                <?php endif; ?>

                <?php if (!empty($items)): ?>
                    <ul class="dwpAccordionItems">
                        <?php foreach ($items as $item): ?>
                            <?php $status = sanitize_key($item['status'] ?? ''); ?>
                            <li class="dwpAccordionLog">
                                <span class="dwpstatus dwp<?php echo esc_attr($status); ?>">
                                    <?php echo esc_html(dwpicha313_log_status($status)); ?>
                                </span>
                                <span class="dwpAccordionLogContent">
                                    <?php echo esc_html($item['content'] ?? ''); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </details>
        <?php
        $first_item = false;
    endforeach;
    ?>
</div>