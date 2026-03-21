<?php
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
