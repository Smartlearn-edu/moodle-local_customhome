<?php
/**
 * Hooks declaration for local_customhome
 *
 * @package    local_customhome
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$callbacks = [
    [
        'hook' => \core\hook\output\before_http_headers::class,
        'callback' => [\local_customhome\hook\before_http_headers::class, 'execute'],
        'priority' => 100,
    ],
];
