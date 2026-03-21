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
 * English language strings for local_customhome.
 *
 * @package    local_customhome
 * @copyright  2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

$string['pluginname'] = 'Custom Home Page Redirect';
$string['redirecturl'] = 'Custom Home URL';
$string['redirecturl_desc'] = 'The absolute URL you want to replace the Moodle front page with (e.g., https://smartlearn.education/example.html). Leave empty to disable.';
$string['skipadmin'] = 'Skip Admin Redirect';
$string['skipadmin_desc'] = 'If enabled, site administrators will see the normal Moodle front page so they can manage the site.';

// Prompt Generator Strings
$string['settings'] = 'General Settings';
$string['promptgenerator'] = 'AI Prompt Generator';
$string['promptgenerator_desc'] = 'Generate an AI prompt to build your custom landing page.';
$string['template'] = 'Design Template';
$string['template_modern'] = 'Modern Tech (Dark mode, neon accents)';
$string['template_corporate'] = 'Clean Corporate (White/blue, professional, minimalist)';
$string['template_playful'] = 'Playful & Creative (Bright colors, rounded corners)';
$string['herovideo'] = 'Hero Video Link (YouTube/Vimeo/etc)';
$string['aboutus'] = 'About Us / Vision';
$string['generateprompt'] = 'Generate Prompt';
$string['generatedprompt'] = 'Your Generated Prompt:';
$string['copyclipboard'] = 'Copy prompt to clipboard';

// New Prompt Generator Options
$string['sitetype_hdr'] = 'Site Identity & Type';
$string['sitecategory'] = 'Primary Site Category';
$string['sitesubcategory'] = 'Sub-category';
$string['cat_academic'] = 'Academic & Formal Education';
$string['cat_corporate'] = 'Corporate Training';
$string['cat_ecommerce'] = 'E-commerce / Course Selling';
$string['cat_kids'] = 'Kids Learning';
$string['cat_coaching'] = 'Coaching & Mentorship';
$string['cat_health'] = 'Health & Fitness';
$string['cat_creative'] = 'Creative Arts';
$string['cat_tech'] = 'Tech & Coding';
$string['cat_language'] = 'Language Learning';
$string['cat_community'] = 'Community & Hobby';
$string['features_hdr'] = 'Platform Features';
$string['languages'] = 'Supported Languages';
$string['languages_help'] = 'Select up to 5 languages that the site design should accommodate (e.g. for language switchers or RTL support).';
$string['reqpages_hdr'] = 'Required Pages & Structure';
$string['reqpages'] = 'Select Required Pages';
$string['design_hdr'] = 'Design & Audience Preferences';
$string['targetaudience'] = 'Primary Target Audience';
$string['coretone'] = 'Desired Vibe / Tone';
$string['primarycta'] = 'Primary Call-to-Action (CTA)';
$string['sitetype'] = 'Site Type';
$string['contentfocus'] = 'Content Focus';
$string['primarylanguage'] = 'Primary Language';
$string['textdirection'] = 'Text Direction';
$string['platformmodel'] = 'Platform Model';
$string['hdr_branding'] = 'Branding & Contact';
$string['slogan'] = 'Slogan / Tagline';
$string['contactemail'] = 'Contact Email';
$string['contactphone'] = 'Contact Phone';
$string['contactaddress'] = 'Physical Address';
$string['socialmedia'] = 'Social Media Links';
$string['socialmedia_help'] = 'Enter your social media links here (e.g. Facebook URL, Twitter URL), separated by commas or on new lines.';
$string['hdr_team'] = 'Our Team';
$string['teaminfo'] = 'Team Members (Name - Position - Bio)';
$string['teaminfo_help'] = 'Enter team members one per line or paragraph. E.g., "John Doe - CEO - Over 10 years of experience in ed-tech."';
$string['hdr_videos'] = 'Media & About';
$string['extravideos'] = 'Additional Video Links';
$string['keynumbers'] = 'Generate Key Platform Statistics (Auto-fetches Moodle Data)';
$string['designreference'] = 'Design Reference URL (Elite Inspiration)';
$string['designreference_help'] = 'Paste the URL of an elite website (e.g., avenues.org, top Webflow template) to instruct the AI to heavily emulate its premium layout, micro-interactions, and visual pacing.';
$string['targetai'] = 'Target AI Tool';
$string['targetai_help'] = 'Select the AI you plan to paste this prompt into. The prompt will automatically adapt its technical requirements for that specific AI\'s architecture (e.g., v0 prefers React, Bolt prefers Vite, IDE agents prefer file system commands).';
