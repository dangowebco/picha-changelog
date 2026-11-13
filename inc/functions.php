<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}
function dwpicha313LogStatus($status)
{
    if ($status == 'added') {
        return __('New', 'dw-picha-changelog');
    } elseif ($status == 'updated') {
        return __('Update', 'dw-picha-changelog');
    } elseif ($status == 'improved') {
        return __('Improvement', 'dw-picha-changelog');
    } elseif ($status == 'removed') {
        return __('Remove', 'dw-picha-changelog');
    } elseif ($status == 'deprecated') {
        return __('Obsolete', 'dw-picha-changelog');
    } elseif ($status == 'compatibility') {
        return __('Compatibility', 'dw-picha-changelog');
    } elseif ($status == 'special') {
        return __('Special', 'dw-picha-changelog');
    } elseif ($status == 'fixed') {
        return __('Fixed', 'dw-picha-changelog');
    }
}