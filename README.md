<div align="center">
  <h1>🚀 Moodle Custom Home Page Redirect & AI Tools</h1>
  <p><i>A powerful, lightweight Moodle local plugin by Smart Learn.</i></p>
  
  [![Moodle](https://img.shields.io/badge/Moodle-4.0%2B-F98012?style=flat-square&logo=moodle)](https://moodle.org)
  [![License](https://img.shields.io/badge/License-GPLv3-blue.svg?style=flat-square)](https://www.gnu.org/licenses/gpl-3.0)
  [![Status](https://img.shields.io/badge/Status-Stable-brightgreen?style=flat-square)]()
</div>

<br />

## 📖 Overview

**Custom Home Page Redirect (`local_customhome`)** is an essential tool designed to take full control of your Moodle instance's front door. It seamlessly redirects users from the default Moodle front page (`site-index`) to a beautiful custom URL of your choice.

This is incredibly useful if you have a separate website, landing page, or custom HTML page that you want users to see when they visit your root domain, while still keeping your Moodle backend running perfectly.

Additionally, it features an **AI Prompt Generator** to help you instantly scaffold breathtaking landing pages based on your actual live Moodle data!

---

## ✨ Key Features

* 🔗 **Custom Redirection URL:** Set any absolute URL to replace the Moodle front page.
* 🛡️ **Admin Bypass:** Automatically skip the redirect for Site Administrators, ensuring you can still manage Moodle's administrative blocks without locking yourself out. 
* 🚨 **Emergency Bypass:** Append `?noredirect=1` to the end of your site URL to manually skip the redirect for quick testing or emergency access.
* 🤖 **AI Prompt Generator:** Dynamically fetches your visible Moodle categories/courses and generates a massive, optimized system prompt you can feed into AI tools (Claude, ChatGPT, Bolt, v0) to generate a premium landing page tailored specifically to your site's data!
* 🛠️ **No Core Hacks:** Accomplishes the redirect cleanly using Moodle's built-in `before_http_headers` hooks, ensuring your code remains safe across all Moodle core updates.

---

## ⚙️ Requirements

* **Moodle Version:** 4.0 or greater.

---

## 📥 Installation

1. Download the plugin or clone the repository.
2. Rename the downloaded folder to `customhome` (if it isn't already).
3. Copy or extract the `customhome` folder into your Moodle installation's `local/` directory: 
   ```bash
   yourmoodle/local/customhome
   ```
4. Log in to your Moodle site as an administrator.
5. Moodle will automatically detect the new plugin and prompt you to upgrade your database. Follow the on-screen instructions.
   *(Alternatively, run the upgrade script from your terminal: `php admin/cli/upgrade.php`)*

---

## 🛠️ Configuration & Usage

Once installed, you can configure the plugin by navigating to:
**`Site administration > Plugins > Local plugins > Custom Home Page Redirect`**

* **Custom Home URL (`redirecturl`):** The absolute URL you want to replace the Moodle front page with (e.g., `https://smartlearn.education/example.html`). Leave this empty to disable the redirect completely.
* **Skip Admin Redirect (`skipadmin`):** Enabled by default. Logged-in site administrators will *not* be redirected.

### 🪄 The AI Prompt Generator
To build your new landing page, navigate to the **AI Prompt Generator** in your plugin settings:
1. Provide your branding details, social links, and tone.
2. The generator will harvest your live Moodle categories.
3. Click "Generate" to receive an elite-level prompt.
4. Paste the prompt into an AI of your choice (e.g. Claude Artifacts, v0, Cursor) to instantly generate an ultra-premium, Tailwind-powered `index.html` file that you can host as your new custom home!

---

## 📄 License & Copyright

This plugin is licensed under the [GNU General Public License v3.0](https://www.gnu.org/licenses/gpl-3.0.html) or later.

© 2025 **Mohammad Nabil** • `<mohammad@smartlearn.education>`
