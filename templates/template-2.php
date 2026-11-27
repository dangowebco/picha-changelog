<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="dwpTemplate dwpTempModernCard">
    <?php foreach ($change_logs as $changelog): ?>
        <?php
        $version        = $changelog['version'] ?? '';
        $jalali_date    = $changelog['jalali_date'] ?? '';
        $gregorian_date = $changelog['gregorian_date'] ?? '';
        $description    = $changelog['description'] ?? '';
        $items          = $changelog['item'] ?? [];

        // Build date parts
        $date_parts = [];
        if (!empty($change_options['j_date']) && $jalali_date) {
            $date_parts[] = esc_html($jalali_date);
        }
        if (!empty($change_options['g_date']) && $gregorian_date) {
            $date_parts[] = esc_html($gregorian_date);
        }
        ?>
        <div class="dwpCard">
            <!-- Accent bar (via ::before) -->
            <div class="dwpCardInner">
                <!-- Header: version + dates -->
                <?php if ((!empty($change_options['version']) && $version) || !empty($date_parts)): ?>
                    <div class="dwpCardHeader">
                        <?php if (!empty($change_options['version']) && $version): ?>
                            <span class="dwpCardVersion"><?php echo esc_html($version); ?></span>
                        <?php else: ?>
                            <span></span>
                        <?php endif; ?>

                        <?php if (!empty($date_parts)): ?>
                            <span class="dwpCardDate">
                                <?php echo implode(' · ', $date_parts); ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <!-- Description -->
                <?php if (!empty($change_options['desc']) && $description): ?>
                    <div class="dwpCardDesc"><?php echo wp_kses_post($description); ?></div>
                <?php endif; ?>

                <!-- Items as sub-cards -->
                <?php if (!empty($items)): ?>
                    <ul class="dwpCardItems">
                        <?php foreach ($items as $item): ?>
                            <?php $status = sanitize_key($item['status'] ?? ''); ?>
                            <li class="dwpCardItem">
                                <span class="dwpstatus dwp<?php echo esc_attr($status); ?>">
                                    <?php echo esc_html(dwpicha313_log_status($status)); ?>
                                </span>
                                <span class="dwpCardItemContent">
                                    <?php echo esc_html($item['content'] ?? ''); ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>