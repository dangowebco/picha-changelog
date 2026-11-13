<?php
if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
} ?>
<div class="dwpTemplate dwpTempOne">
    <?php foreach ($change_logs as $changelog) : ?>
        <div class="dwpVersionWrapper">
            <div class="dwpHead">
                <div class="dwpHeadDetails">
                    <?php
                    if (isset($change_options['j_date'])) {
                        echo ' ' . esc_html($changelog['jalali_date']);
                    }
                    if (isset($change_options['g_date'])) {
                        echo ' - ' . esc_html($changelog['gregorian_date']);
                    } ?>
                </div>
            </div>
            <div class="dwpVersion">
                <?php if (isset($change_options['version'])) {
                    echo __('Version ', 'dw-picha-changelog') . '<strong>' . esc_html($changelog['version']) . '</strong>';
                }
                ?>
            </div>
            <?php if (isset($change_options['desc']) && $changelog['description']): ?>
                <div class="dwpDesc"><?php echo $changelog['description'] ?></div>
            <?php endif; ?>
            <?php if ($changelog['item']): ?>
                <ul>
                    <?php foreach ($changelog['item'] as $item): ?>
                        <li class="dwpLogWrapper">
                            <div class="dwpLog dwpLog<?php echo esc_html($item['status']) ?>"><?php echo dwpicha313LogStatus($item['status']) . ': ' . esc_html($item['content']) ?></div>
                        </li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>