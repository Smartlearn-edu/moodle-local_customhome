<?php
// This file is part of Moodle - http://moodle.org/
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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Settings for local_customhome
 *
 * @package    local_customhome
 * @copyright  2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // Create a new category under "Local plugins".
    $category = new admin_category('local_customhome_category', get_string('pluginname', 'local_customhome'));
    $ADMIN->add('localplugins', $category);

    // Add general settings page to the new category.
    $settings = new admin_settingpage('local_customhome', get_string('settings', 'local_customhome'));
    $ADMIN->add('local_customhome_category', $settings);

    // Add a text field for the custom URL.
    $settings->add(new admin_setting_configtext(
        'local_customhome/redirecturl',
        get_string('redirecturl', 'local_customhome'),
        get_string('redirecturl_desc', 'local_customhome'),
        '', // Default is empty.
        PARAM_URL
    ));

    // Add a checkbox to skip redirecting site administrators.
    $settings->add(new admin_setting_configcheckbox(
        'local_customhome/skipadmin',
        get_string('skipadmin', 'local_customhome'),
        get_string('skipadmin_desc', 'local_customhome'),
        1 // Default to checked.
    ));

    // Add the Prompt Generator external page to the same category.
    $ADMIN->add('local_customhome_category', new admin_externalpage(
        'local_customhome_prompt',
        get_string('promptgenerator', 'local_customhome'),
        new moodle_url('/local/customhome/prompt.php')
    ));
}
