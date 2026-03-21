<?php

// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Hooks handlers for local_customhome
 *
 * @package    local_customhome
 * @copyright  2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

namespace local_customhome\hook;

/**
 * Class before_http_headers
 *
 * Handles the redirect hook before HTTP headers are sent.
 *
 * @package    local_customhome
 * @copyright  2024 Smart Learn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class before_http_headers
{
    /**
     * Hook callback for core\hook\output\before_http_headers
     *
     * @param \core\hook\output\before_http_headers $hook
     */
    public static function execute(\core\hook\output\before_http_headers $hook): void
    {
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
