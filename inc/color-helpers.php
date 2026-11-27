<?php
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Convert a hex color to rgba() string.
 *
 * @param string $hex   Hex color (with or without #).
 * @param float  $alpha Alpha (0-1).
 * @return string
 */
function dwpicha313_hex_to_rgba($hex, $alpha = 1)
{
    $hex = ltrim((string) $hex, '#');

    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
        return 'rgba(0,0,0,' . (float) $alpha . ')';
    }

    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    return sprintf('rgba(%d,%d,%d,%s)', $r, $g, $b, rtrim(rtrim(number_format((float) $alpha, 3, '.', ''), '0'), '.'));
}

/**
 * Darken a hex color by a percentage.
 *
 * @param string $hex     Hex color.
 * @param int    $percent 0-100.
 * @return string
 */
function dwpicha313_darken_hex($hex, $percent = 10)
{
    $hex = ltrim((string) $hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
        return '#000000';
    }

    $percent = max(0, min(100, (int) $percent));
    $shift   = (int) round(255 * $percent / 100);

    $r = max(0, hexdec(substr($hex, 0, 2)) - $shift);
    $g = max(0, hexdec(substr($hex, 2, 2)) - $shift);
    $b = max(0, hexdec(substr($hex, 4, 2)) - $shift);

    return sprintf('#%02x%02x%02x', $r, $g, $b);
}

/**
 * Lighten a hex color by a percentage.
 *
 * @param string $hex     Hex color.
 * @param int    $percent 0-100.
 * @return string
 */
function dwpicha313_lighten_hex($hex, $percent = 10)
{
    $hex = ltrim((string) $hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
        return '#ffffff';
    }

    $percent = max(0, min(100, (int) $percent));
    $shift   = (int) round(255 * $percent / 100);

    $r = min(255, hexdec(substr($hex, 0, 2)) + $shift);
    $g = min(255, hexdec(substr($hex, 2, 2)) + $shift);
    $b = min(255, hexdec(substr($hex, 4, 2)) + $shift);

    return sprintf('#%02x%02x%02x', $r, $g, $b);
}

/**
 * Determine if a hex color is "dark" (for contrast decisions).
 *
 * @param string $hex
 * @return bool
 */
function dwpicha313_is_dark_color($hex)
{
    $hex = ltrim((string) $hex, '#');
    if (strlen($hex) === 3) {
        $hex = $hex[0] . $hex[0] . $hex[1] . $hex[1] . $hex[2] . $hex[2];
    }
    if (strlen($hex) !== 6 || !ctype_xdigit($hex)) {
        return false;
    }

    $r = hexdec(substr($hex, 0, 2));
    $g = hexdec(substr($hex, 2, 2));
    $b = hexdec(substr($hex, 4, 2));

    $luminance = (0.299 * $r + 0.587 * $g + 0.114 * $b) / 255;
    return $luminance < 0.5;
}

/**
 * Validate a hex color string.
 *
 * @param string $color
 * @return bool
 */
function dwpicha313_is_valid_hex($color)
{
    return (bool) preg_match('/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', (string) $color);
}

/**
 * Build the inline CSS for a given post's appearance settings.
 *
 * @param int   $post_id
 * @param array $appearance
 * @return string
 */
function dwpicha313_build_appearance_css($post_id, $appearance)
{
    if (empty($appearance['enabled'])) {
        return '';
    }

    $vars = [];

    // Primary color
    if (!empty($appearance['primary']) && dwpicha313_is_valid_hex($appearance['primary'])) {
        $primary = $appearance['primary'];
        $vars['--dwp-primary']       = $primary;
        $vars['--dwp-primary-hover'] = dwpicha313_darken_hex($primary, 10);
        $vars['--dwp-primary-dark']  = dwpicha313_darken_hex($primary, 20);
        $vars['--dwp-primary-light'] = dwpicha313_lighten_hex($primary, 88);
        $vars['--dwp-primary-ring']  = dwpicha313_hex_to_rgba($primary, 0.2);
    }

    // Text color
    if (!empty($appearance['text']) && dwpicha313_is_valid_hex($appearance['text'])) {
        $vars['--dwp-text'] = $appearance['text'];
        // Derived muted text (mix with 40% gray)
        $vars['--dwp-text-muted'] = dwpicha313_lighten_hex($appearance['text'], 25);
    }

    // Surface color
    if (!empty($appearance['surface']) && dwpicha313_is_valid_hex($appearance['surface'])) {
        $vars['--dwp-surface'] = $appearance['surface'];
        // Border derived from surface (subtle)
        $vars['--dwp-border'] = dwpicha313_is_dark_color($appearance['surface'])
            ? dwpicha313_lighten_hex($appearance['surface'], 8)
            : dwpicha313_darken_hex($appearance['surface'], 8);
    }

    if (empty($vars)) {
        return '';
    }

    $selector = '#dwpicha-' . (int) $post_id . ' .dwpTemplate';
    $css      = $selector . ' {';
    foreach ($vars as $name => $value) {
      $css .= ' ' . $name . ': ' . esc_attr($value) . ' !important;';
    }
    $css .= ' }';

    return $css;
}