<?php
/**
 * Hooks handlers for local_customhome
 *
 * @package    local_customhome
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_customhome\hook;

defined('MOODLE_INTERNAL') || die();

class before_http_headers {
    /**
     * Hook callback for core\hook\output\before_http_headers
     *
     * @param \core\hook\output\before_http_headers $hook
     */
    public static function execute(\core\hook\output\before_http_headers $hook): void {
        global $PAGE;

        if ($PAGE->pagetype === 'site-index') {
            $targeturl = get_config('local_customhome', 'redirecturl');
            if (empty($targeturl)) {
                return;
            }

            $skipadmin = get_config('local_customhome', 'skipadmin');
            if ($skipadmin && is_siteadmin()) {
                return;
            }

            $bypass = optional_param('noredirect', 0, PARAM_INT);
            if ($bypass == 1) {
                return;
            }

            redirect($targeturl);
        }
    }
}
