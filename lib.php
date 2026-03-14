<?php
defined('MOODLE_INTERNAL') || die();

function local_customhome_before_http_headers() {
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
