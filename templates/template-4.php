<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="dwpTemplate dwpTempMinimal">
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
        <div class="dwpMinimalVersion">
            <!-- Header: version + dates -->
            <?php if ((!empty($change_options['version']) && $version) || !empty($date_parts)): ?>
                <div class="dwpMinimalHeader">
                    <?php if (!empty($change_options['version']) && $version): ?>
                        <span class="dwpMinimalVersionTag"><?php echo esc_html($version); ?></span>
                    <?php else: ?>
                        <span></span>
                    <?php endif; ?>

                    <?php if (!empty($date_parts)): ?>
                        <span class="dwpMinimalDate">
                            <?php echo implode(' · ', $date_parts); ?>
                        </span>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <!-- Description -->
            <?php if (!empty($change_options['desc']) && $description): ?>
                <div class="dwpMinimalDesc"><?php echo wp_kses_post($description); ?></div>
            <?php endif; ?>

            <!-- Items -->
            <?php if (!empty($items)): ?>
                <ul class="dwpMinimalItems">
                    <?php foreach ($items as $item): ?>
                        <?php $status = sanitize_key($item['status'] ?? ''); ?>
                        <li class="dwpMinimalItem">
                            <span class="dwpMinimalStatus dwpMinimalStatus-<?php echo esc_attr($status); ?>">
                                <?php echo esc_html(dwpicha313_log_status($status)); ?>
                            </span>
                            <span class="dwpMinimalContent">
                                <?php echo esc_html($item['content'] ?? ''); ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>