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
 * CORS-enabled session check endpoint for services.smartlearn.education
 *
 * DEPLOY INSTRUCTIONS
 * -------------------
 * Copy this file to:   /path/to/moodle/local/customhome/whoami.php
 * That's it. No version.php bump needed.
 *
 * The services website (services.smartlearn.education) calls this endpoint on
 * every page load with `credentials: "include"` so that Moodle's session
 * cookie is forwarded. This endpoint returns the current user's info as JSON
 * so the Navbar can show either a "Student Login" button or the user's avatar.
 *
 * @package    local_customhome
 * @copyright  2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

define('NO_MOODLE_COOKIES', false); // We need the session cookie.
define('AJAX_SCRIPT', true);        // Suppress HTML output on error.
define('NO_DEBUG_DISPLAY', true);   // Never leak stack traces to a foreign origin.

require_once(__DIR__ . '/../../config.php');

// ---------------------------------------------------------------------------
// CORS headers — must be sent before any output.
// ---------------------------------------------------------------------------
$allowed_origin = 'https://services.smartlearn.education';
$origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

if ($origin === $allowed_origin) {
    header('Access-Control-Allow-Origin: ' . $allowed_origin);
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Allow-Methods: GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type, Accept');
    header('Access-Control-Max-Age: 3600');
}

// Handle pre-flight request.
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

header('Content-Type: application/json; charset=utf-8');
// Prevent this response from being cached.
header('Cache-Control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');

// ---------------------------------------------------------------------------
// Session check.
// ---------------------------------------------------------------------------
if (!isloggedin() || isguestuser()) {
    echo json_encode(['loggedin' => false]);
    exit;
}

// ---------------------------------------------------------------------------
// Build user picture URL.
// ---------------------------------------------------------------------------
$PAGE->set_context(context_system::instance());
$userpicture = new user_picture($USER);
$userpicture->size = 64; // pixels
$pictureurl = $userpicture->get_url($PAGE)->out(false);

echo json_encode([
    'loggedin'     => true,
    'name'         => fullname($USER),
    'firstname'    => $USER->firstname,
    'picture'      => $pictureurl,
    'dashboardurl' => (new moodle_url('/my/'))->out(false),
]);
