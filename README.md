# Custom Home Page Redirect (local_customhome)

A simple, lightweight Moodle local plugin that automatically redirects users from the default Moodle front page (`site-index`) to a custom URL of your choice.

This is incredibly useful if you have a separate website, landing page, or custom HTML page that you want users to see when they visit your root domain, while still keeping your Moodle instance running efficiently behind the scenes.

## Features

*   **Custom Redirection URL:** Set any absolute URL to replace the Moodle front page.
*   **Admin Bypass:** Automatically skip the redirect for Site Administrators, ensuring you can still access Moodle's administrative blocks and front page settings without locking yourself out. 
*   **Emergency Bypass:** Use a simple URL parameter to manually skip the redirect for testing or emergency access.
*   **No Core Hacks:** Accomplishes the redirect cleanly using Moodle's built-in Navigation hooks, meaning your code is safe across Moodle core updates.

## Requirements

*   Moodle 4.0 or greater.

## Installation

1. Download the plugin or clone the repository.
2. Rename the downloaded folder to `customhome` (if it isn't already).
3. Copy or extract the `customhome` folder into your Moodle installation's `local/` directory so it looks like this: `yourmoodle/local/customhome`.
4. Log in to your Moodle site as an administrator.
5. Moodle will automatically detect the new plugin and prompt you to upgrade your database. Follow the on-screen instructions.
6. Alternatively, you can run the upgrade script from your terminal: `php admin/cli/upgrade.php`.

## Configuration

Once installed, you can configure the plugin's behavior by navigating to:

**Site administration > Plugins > Local plugins > Custom Home Page Redirect**

Here you will find the following settings:

*   **Custom Home URL (`redirecturl`):** The absolute URL you want to replace the Moodle front page with (e.g., `https://example.com` or `https://smartlearn.education/example.html`). Leave this field empty to disable the redirect completely.
*   **Skip Admin Redirect (`skipadmin`):** If enabled, logged-in site administrators will *not* be redirected. They will see the normal Moodle front page. This allows admins to manage the site normally while all other users and guests are continuously redirected. (Enabled by default).

## Emergency Bypass / Testing

If you ever need to view the default Moodle front page but the redirect is currently active (and you aren't logged in as an admin), simply append `?noredirect=1` to the end of your site URL.

**Example:** `https://yourmoodlesite.com/?noredirect=1`

## License

This plugin is licensed under the [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl-3.0.html).
