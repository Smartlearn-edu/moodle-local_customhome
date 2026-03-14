<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    // Add settings page to the "Local plugins" category in Site Administration.
    $settings = new admin_settingpage('local_customhome', get_string('pluginname', 'local_customhome'));
    $ADMIN->add('localplugins', $settings);

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
}
