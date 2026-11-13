<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
} ?>
<div class="dwpTemplate dwpTempTwo">
    <?php foreach ($change_logs as $changelog) : ?>
        <div class="dwpVersionWrapper">
            <div class="dwpHead">
                <div class="dwpHeadDetails">
                    <?php if (isset($change_options['version'])) {
                        echo '<span>' . esc_html($changelog['version']) . '</span>';
                    }
                    if (isset($change_options['j_date']) || isset($change_options['gregorian_date'])) {
                        echo '(';
                    }
                    if (isset($change_options['j_date'])) {
                        echo ' ' . esc_html($changelog['jalali_date']);
                    }
                    if (isset($change_options['g_date'])) {
                        echo ' ' . esc_html($changelog['gregorian_date']);
                    }
                    if (isset($change_options['j_date']) || isset($change_options['gregorian_date'])) {
                        echo ')';
                    } ?>
                </div>
            </div>
            <?php if (isset($change_options['desc']) && $changelog['description']): ?>
                <div class="dwpDesc"><?php echo $changelog['description'] ?></div>
            <?php endif; ?>
            <?php if ($changelog['item']): ?>
                <ul>
                    <?php foreach ($changelog['item'] as $item): ?>
                        <li class="dwpLogWrapper">
                            <div class="dwpstatus dwp<?php echo esc_html($item['status']) ?>"><?php echo esc_html(dwpicha313LogStatus($item['status'])) ?></div>
                            <div class="dwpLog dwpLog<?php echo esc_html($item['status']) ?>"><?php echo esc_html($item['content']) ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>