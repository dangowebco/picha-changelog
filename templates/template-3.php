<?php
if (!defined('ABSPATH')) {
    exit;
}
?>
<div class="dwpTemplate dwpTempTimeline">
    <div class="dwpTimeline">
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
            <div class="dwpTimelineItem">
                <!-- Marker -->
                <div class="dwpTimelineMarker">
                    <span class="dwpTimelineDot"></span>
                </div>

                <!-- Content -->
                <div class="dwpTimelineContent">
                    <div class="dwpTimelineHeader">
                        <?php if (!empty($change_options['version']) && $version): ?>
                            <span class="dwpTimelineVersion"><?php echo esc_html($version); ?></span>
                        <?php endif; ?>

                        <?php if (!empty($date_parts)): ?>
                            <span class="dwpTimelineDate">
                                <?php echo implode(' · ', $date_parts); ?>
                            </span>
                        <?php endif; ?>
                    </div>

                    <?php if (!empty($change_options['desc']) && $description): ?>
                        <div class="dwpTimelineDesc"><?php echo wp_kses_post($description); ?></div>
                    <?php endif; ?>

                    <?php if (!empty($items)): ?>
                        <ul class="dwpTimelineItems">
                            <?php foreach ($items as $item): ?>
                                <?php $status = sanitize_key($item['status'] ?? ''); ?>
                                <li class="dwpTimelineLog">
                                    <span class="dwpstatus dwp<?php echo esc_attr($status); ?>">
                                        <?php echo esc_html(dwpicha313_log_status($status)); ?>
                                    </span>
                                    <span class="dwpTimelineLogContent">
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
</div>