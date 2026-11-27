<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="dwpTemplate dwpTempClassic">
    <?php foreach ($change_logs as $changelog): ?>
        <?php
        $version        = $changelog['version'] ?? '';
        $jalali_date    = $changelog['jalali_date'] ?? '';
        $gregorian_date = $changelog['gregorian_date'] ?? '';
        $description    = $changelog['description'] ?? '';
        $items          = $changelog['item'] ?? [];

        // Build header parts
        $header_parts = [];
        if (!empty($change_options['version']) && $version) {
            $header_parts[] = '<span class="dwpClassicVersion">' . esc_html($version) . '</span>';
        }
        if (!empty($change_options['j_date']) && $jalali_date) {
            $header_parts[] = '<span class="dwpClassicDate">' . esc_html($jalali_date) . '</span>';
        }
        if (!empty($change_options['g_date']) && $gregorian_date) {
            $header_parts[] = '<span class="dwpClassicDate">' . esc_html($gregorian_date) . '</span>';
        }
        ?>
        <div class="dwpClassicVersionWrapper">
            <?php if (!empty($header_parts)): ?>
                <div class="dwpClassicHeader">
                    <?php echo implode('<span class="dwpClassicSeparator">·</span>', $header_parts); ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($change_options['desc']) && $description): ?>
                <div class="dwpClassicDesc"><?php echo wp_kses_post($description); ?></div>
            <?php endif; ?>

            <?php if (!empty($items)): ?>
                <ul class="dwpClassicItems">
                    <?php foreach ($items as $item): ?>
                        <?php $status = sanitize_key($item['status'] ?? ''); ?>
                        <li class="dwpClassicItem">
                            <span class="dwpstatus dwp<?php echo esc_attr($status); ?>">
                                <?php echo esc_html(dwpicha313_log_status($status)); ?>
                            </span>
                            <span class="dwpClassicContent">
                                <?php echo esc_html($item['content'] ?? ''); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>