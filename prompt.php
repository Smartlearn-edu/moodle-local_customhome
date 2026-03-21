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
 * AI Prompt Generator Tool
 *
 * @package    local_customhome
 * @copyright  2025 Mohammad Nabil <mohammad@smartlearn.education>
 * @license    https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir . '/formslib.php');

// Require admin access.
admin_externalpage_setup('local_customhome_prompt');

// Define the form.
/**
 * Prompt generator form class.
 *
 * @package    local_customhome
 * @copyright  2024 Smart Learn
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class local_customhome_prompt_form extends moodleform {
    /**
     * Form definition.
     */
    public function definition()
    {
        $mform = $this->_form;

        // Site identity & type.
        $mform->addElement('header', 'hdr_sitetype', get_string('sitetype_hdr', 'local_customhome'));

        // 1. Site Type
        $sitetypes = [
            '' => get_string('choose'),
            'school' => 'School (K-12)',
            'university' => 'University',
            'corporate' => 'Corporate',
            'marketplace' => 'Marketplace',
            'coaching' => 'Coaching',
            'ngo' => 'NGO',
            'gov' => 'Government',
            'religious' => 'Religious Institution',
            'health' => 'Health & Medical',
        ];
        $mform->addElement('select', 'sitetype', get_string('sitetype', 'local_customhome'), $sitetypes);

        // 2. Content Focus
        $focuses = [
            '' => get_string('choose'),
            'tech' => 'Tech & Coding',
            'language' => 'Language Learning',
            'islamic' => 'Islamic Education',
            'creative' => 'Creative Arts',
            'wellness' => 'Health & Wellness',
            'academic' => 'Academic',
            'kids' => 'Kids Learning',
            'business' => 'Business & Professional',
            'hobby' => 'Hobby & Lifestyle',
        ];
        $mform->addElement('select', 'contentfocus', get_string('contentfocus', 'local_customhome'), $focuses);

        // 3. Sub-category (dynamic based on Content Focus)
        $subtech = ['bootcamp' => 'Coding Bootcamp', 'data' => 'Data Science & AI', 'cert' => 'IT Certification'];
        $mform->addElement('select', 'subtech', get_string('sitesubcategory', 'local_customhome'), $subtech);
        $mform->hideIf('subtech', 'contentfocus', 'neq', 'tech');

        $sublanguage = ['esl' => 'English as a Second Language', 'immersion' => 'Language Immersion', 'exam' => 'Language Exam Prep (IELTS/TOEFL)'];
        $mform->addElement('select', 'sublanguage', get_string('sitesubcategory', 'local_customhome'), $sublanguage);
        $mform->hideIf('sublanguage', 'contentfocus', 'neq', 'language');

        $subislamic = ['quran' => 'Quran Studies', 'fiqh' => 'Fiqh & Jurisprudence', 'seerah' => 'Seerah & History', 'kidsislam' => 'Islamic Studies for Kids'];
        $mform->addElement('select', 'subislamic', get_string('sitesubcategory', 'local_customhome'), $subislamic);
        $mform->hideIf('subislamic', 'contentfocus', 'neq', 'islamic');

        $subcreative = ['design' => 'Design & Illustration', 'music' => 'Music Production', 'photo' => 'Photography & Video'];
        $mform->addElement('select', 'subcreative', get_string('sitesubcategory', 'local_customhome'), $subcreative);
        $mform->hideIf('subcreative', 'contentfocus', 'neq', 'creative');

        $subwellness = ['yoga' => 'Yoga & Mindfulness', 'fitness' => 'Personal Training', 'nutrition' => 'Nutrition & Diet'];
        $mform->addElement('select', 'subwellness', get_string('sitesubcategory', 'local_customhome'), $subwellness);
        $mform->hideIf('subwellness', 'contentfocus', 'neq', 'wellness');

        $subacademic = ['exam' => 'Exam Preparation', 'stem' => 'STEM Subjects', 'humanities' => 'Arts & Humanities'];
        $mform->addElement('select', 'subacademic', get_string('sitesubcategory', 'local_customhome'), $subacademic);
        $mform->hideIf('subacademic', 'contentfocus', 'neq', 'academic');

        $subkids = ['early' => 'Early Childhood', 'gamified' => 'Gamified Learning', 'stemkids' => 'STEM for Kids', 'artskids' => 'Kids Arts & Crafts'];
        $mform->addElement('select', 'subkids', get_string('sitesubcategory', 'local_customhome'), $subkids);
        $mform->hideIf('subkids', 'contentfocus', 'neq', 'kids');

        $subbusiness = ['leadership' => 'Leadership & Management', 'finance' => 'Finance & Accounting', 'marketing' => 'Digital Marketing'];
        $mform->addElement('select', 'subbusiness', get_string('sitesubcategory', 'local_customhome'), $subbusiness);
        $mform->hideIf('subbusiness', 'contentfocus', 'neq', 'business');

        $subhobby = ['diy' => 'Home & DIY', 'pet' => 'Pet Care & Training', 'gardening' => 'Gardening', 'cooking' => 'Cooking & Baking'];
        $mform->addElement('select', 'subhobby', get_string('sitesubcategory', 'local_customhome'), $subhobby);
        $mform->hideIf('subhobby', 'contentfocus', 'neq', 'hobby');

        // Platform features.
        $mform->addElement('header', 'hdr_features', get_string('features_hdr', 'local_customhome'));

        $languages = ['English' => 'English', 'Spanish' => 'Spanish', 'French' => 'French', 'German' => 'German', 'Arabic' => 'Arabic', 'Chinese' => 'Chinese', 'Japanese' => 'Japanese', 'Portuguese' => 'Portuguese', 'Russian' => 'Russian', 'Italian' => 'Italian', 'Hindi' => 'Hindi'];
        $mform->addElement('select', 'languages', get_string('languages', 'local_customhome'), $languages);
        $mform->getElement('languages')->setMultiple(true);
        $mform->addHelpButton('languages', 'languages', 'local_customhome');

        // Required pages & structure.
        $mform->addElement('header', 'hdr_pages', get_string('reqpages_hdr', 'local_customhome'));
        $pages = [
            'home' => 'Home / Landing Page (Default)',
            'about' => 'About Us',
            'contact' => 'Contact Us',
            'courses' => 'Our Courses / Catalog',
            'faq' => 'FAQ',
            'testimonials' => 'Testimonials',
            'pricing' => 'Pricing / Memberships',
            'blog' => 'Blog / News',
            'login' => 'Custom Login / Register Page'
        ];

        $pagegroup = [];
        foreach ($pages as $key => $label) {
            $pagegroup[] = $mform->createElement('advcheckbox', $key, '', $label, null, [0, 1]);
        }
        $mform->addGroup($pagegroup, 'reqpages', get_string('reqpages', 'local_customhome'), ['<br>'], false);

        // Design & audience preferences.
        $mform->addElement('header', 'hdr_design', get_string('design_hdr', 'local_customhome'));

        $ailist = [
            'claude' => 'Claude 3.5/3.7 (Artifacts) - Single HTML',
            'chatgpt' => 'ChatGPT (GPT-4o/o1) - Strict No-Truncate HTML',
            'v0' => 'v0 by Vercel - React Component',
            'bolt' => 'Bolt.new / Lovable - Vite/React Web App',
            'replit' => 'Replit Agent - Cloud Workspace',
            'antigravity' => 'Antigravity (Me!) - Autonomous IDE Execution',
            'cursor' => 'Cursor / Cline - IDE File Generation'
        ];
        $mform->addElement('select', 'targetai', get_string('targetai', 'local_customhome'), $ailist);
        $mform->setDefault('targetai', 'claude');
        $mform->addHelpButton('targetai', 'targetai', 'local_customhome');

        $mform->addElement('text', 'designreference', get_string('designreference', 'local_customhome'), ['size' => '60']);
        $mform->setType('designreference', PARAM_URL);
        $mform->addHelpButton('designreference', 'designreference', 'local_customhome');

        $audiences = ['beginners' => 'Beginners/Novices', 'professionals' => 'Working Professionals', 'children' => 'Children & Parents', 'hobbyists' => 'Hobbyists', 'corporates' => 'Corporate Entities'];
        $mform->addElement('select', 'audience', get_string('targetaudience', 'local_customhome'), $audiences);

        $tones = ['professional' => 'Professional & Trustworthy', 'fun' => 'Fun & Energetic', 'calm' => 'Calm & Minimalist', 'bold' => 'Bold & Innovative'];
        $mform->addElement('select', 'tone', get_string('coretone', 'local_customhome'), $tones);

        $ctas = ['freetrial' => 'Start Free Trial', 'joincommunity' => 'Join the Community', 'explore' => 'Explore Courses', 'register' => 'Register Now', 'booksession' => 'Book a Session', 'enroll' => 'Enroll Now', 'subscribe' => 'Subscribe', 'demo' => 'Book a Demo', 'learnmore' => 'Learn More'];
        $mform->addElement('select', 'primarycta', get_string('primarycta', 'local_customhome'), $ctas);

        $templates = [
            'modern' => get_string('template_modern', 'local_customhome'),
            'corporate' => get_string('template_corporate', 'local_customhome'),
            'playful' => get_string('template_playful', 'local_customhome'),
        ];
        $mform->addElement('select', 'template', get_string('template', 'local_customhome'), $templates);
        $mform->setDefault('template', 'modern');

        // Branding & contact.
        $mform->addElement('header', 'hdr_branding', get_string('hdr_branding', 'local_customhome'));

        $mform->addElement('text', 'slogan', get_string('slogan', 'local_customhome'), ['size' => '50']);
        $mform->setType('slogan', PARAM_TEXT);

        $mform->addElement('text', 'contactemail', get_string('contactemail', 'local_customhome'), ['size' => '50']);
        $mform->setType('contactemail', PARAM_TEXT);

        $mform->addElement('text', 'contactphone', get_string('contactphone', 'local_customhome'), ['size' => '30']);
        $mform->setType('contactphone', PARAM_TEXT);

        $mform->addElement('textarea', 'contactaddress', get_string('contactaddress', 'local_customhome'), ['wrap' => 'virtual', 'rows' => 3, 'cols' => 50]);
        $mform->setType('contactaddress', PARAM_TEXT);

        $mform->addElement('textarea', 'socialmedia', get_string('socialmedia', 'local_customhome'), ['wrap' => 'virtual', 'rows' => 3, 'cols' => 50]);
        $mform->setType('socialmedia', PARAM_TEXT);
        $mform->addHelpButton('socialmedia', 'socialmedia', 'local_customhome');

        // Our team.
        $mform->addElement('header', 'hdr_team', get_string('hdr_team', 'local_customhome'));

        $mform->addElement('textarea', 'teaminfo', get_string('teaminfo', 'local_customhome'), ['wrap' => 'virtual', 'rows' => 5, 'cols' => 50]);
        $mform->setType('teaminfo', PARAM_TEXT);
        $mform->addHelpButton('teaminfo', 'teaminfo', 'local_customhome');

        // Media & about.
        $mform->addElement('header', 'hdr_videos', get_string('hdr_videos', 'local_customhome'));

        $mform->addElement('text', 'herovideo', get_string('herovideo', 'local_customhome'), ['size' => '50']);
        $mform->setType('herovideo', PARAM_URL);

        $mform->addElement('textarea', 'extravideos', get_string('extravideos', 'local_customhome'), ['wrap' => 'virtual', 'rows' => 3, 'cols' => 50]);
        $mform->setType('extravideos', PARAM_TEXT);

        $mform->addElement('textarea', 'aboutus', get_string('aboutus', 'local_customhome'), ['wrap' => 'virtual', 'rows' => 5, 'cols' => 50]);
        $mform->setType('aboutus', PARAM_TEXT);

        $mform->addElement('advcheckbox', 'includestats', get_string('keynumbers', 'local_customhome'), '', null, [0, 1]);
        $mform->setDefault('includestats', 1);

        // Submit Button
        $this->add_action_buttons(false, get_string('generateprompt', 'local_customhome'));
    }
}

// Setup page variables.
$PAGE->set_url(new moodle_url('/local/customhome/prompt.php'));
$PAGE->set_title(get_string('promptgenerator', 'local_customhome'));
$PAGE->set_heading(get_string('promptgenerator', 'local_customhome'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('promptgenerator', 'local_customhome'));

// Initialize the form.
$mform = new local_customhome_prompt_form();

// If the form was submitted.
if ($data = $mform->get_data()) {
    global $DB, $CFG;

    // Fetch visible categories and courses from the database.
    $categories = $DB->get_records('course_categories', ['visible' => 1], 'sortorder ASC', 'id, parent, name, description');
    $courses = $DB->get_records_select('course', 'visible = 1 AND category > 0', null, 'sortorder ASC', 'id, category, fullname, summary');

    $tree = [];
    $catrefs = [];

    // Initialize all categories in reference array.
    foreach ($categories as $cat) {
        $catrefs[$cat->id] = [
            'name' => format_string($cat->name),
            'description' => trim(strip_tags(format_string($cat->description))),
            'subcategories' => [],
            'courses' => []
        ];
    }

    // Assign courses to their categories.
    foreach ($courses as $c) {
        if (isset($catrefs[$c->category])) {
            $catrefs[$c->category]['courses'][] = [
                'name' => format_string($c->fullname),
                'description' => trim(strip_tags(format_string($c->summary)))
            ];
        }
    }

    // Build the tree using the 'parent' field.
    foreach ($categories as $cat) {
        if (empty($cat->parent) || !isset($catrefs[$cat->parent])) {
            // Root category or parent is somehow missing/hidden.
            $tree[] = &$catrefs[$cat->id];
        } else {
            // Child category.
            $catrefs[$cat->parent]['subcategories'][] = &$catrefs[$cat->id];
        }
    }

    // Recursively remove empty arrays to keep JSON clean.
    $cleantree = function (&$node) use (&$cleantree) {
        if (empty($node['description'])) {
            unset($node['description']);
        }
        if (empty($node['subcategories'])) {
            unset($node['subcategories']);
        } else {
            foreach (array_keys($node['subcategories']) as $k) {
                $cleantree($node['subcategories'][$k]);
            }
        }
        if (empty($node['courses'])) {
            unset($node['courses']);
        } else {
            foreach (array_keys($node['courses']) as $k) {
                if (empty($node['courses'][$k]['description'])) {
                    unset($node['courses'][$k]['description']);
                }
            }
        }
    };

    foreach (array_keys($tree) as $k) {
        $cleantree($tree[$k]);
    }

    $categoriestext = json_encode($tree, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    $sitename = format_string(get_site()->fullname);

    // Extract Site Type
    $datasitetype = $data->sitetype ?? '';
    $sitetypesmap = ['school' => 'School (K-12)', 'university' => 'University', 'corporate' => 'Corporate', 'marketplace' => 'Marketplace', 'coaching' => 'Coaching', 'ngo' => 'NGO', 'gov' => 'Government', 'religious' => 'Religious Institution', 'health' => 'Health & Medical'];
    $sitetypestr = isset($sitetypesmap[$datasitetype]) ? $sitetypesmap[$datasitetype] : 'Educational Institution';

    $datacontentfocus = $data->contentfocus ?? '';
    $focusesmap = ['tech' => 'Tech & Coding', 'language' => 'Language Learning', 'islamic' => 'Islamic Education', 'creative' => 'Creative Arts', 'wellness' => 'Health & Wellness', 'academic' => 'Academic', 'kids' => 'Kids Learning', 'business' => 'Business & Professional', 'hobby' => 'Hobby & Lifestyle'];
    $focusstr = isset($focusesmap[$datacontentfocus]) ? $focusesmap[$datacontentfocus] : 'General E-Learning';

    $subcategoryfield = 'sub_' . $datacontentfocus;
    $subcategorystr = !empty($data->$subcategoryfield) ? $data->$subcategoryfield : '';

    $siteidentity = "Site Type: {$sitetypestr} | Content Focus: {$focusstr}";
    if ($subcategorystr) {
        $siteidentity .= " | Sub-category: {$subcategorystr}";
    }

    // Extract Languages
    $selectedlanguages = !empty($data->languages) ? implode(', ', $data->languages) : 'None provided';

    // Extract Pages
    $selectedpages = [];
    $pagesmap = [
        'home' => 'Home', 'about' => 'About Us', 'contact' => 'Contact Us',
        'courses' => 'Our Courses', 'faq' => 'FAQ', 'testimonials' => 'Testimonials',
        'pricing' => 'Pricing', 'blog' => 'Blog', 'login' => 'Login/Register'
    ];
    if (!empty($data->reqpages)) {
        foreach ($data->reqpages as $key => $val) {
            if ($val && isset($pagesmap[$key])) {
                $selectedpages[] = $pagesmap[$key];
            }
        }
    }
    $pagesstring = !empty($selectedpages) ? implode(', ', $selectedpages) : 'Home, About Us, Courses';

    // Competitor features
    $dataaudience = $data->audience ?? '';
    $audiencemap = [
        'beginners' => 'Beginners/Novices',
        'professionals' => 'Working Professionals',
        'children' => 'Children & Parents',
        'hobbyists' => 'Hobbyists',
        'corporates' => 'Corporate Entities'
    ];
    $audience = isset($audiencemap[$dataaudience]) ? $audiencemap[$dataaudience] : 'General learners';

    $datatone = $data->tone ?? '';
    $tonemap = [
        'professional' => 'Professional & Trustworthy',
        'fun' => 'Fun & Energetic',
        'calm' => 'Calm & Minimalist',
        'bold' => 'Bold & Innovative'
    ];
    $tone = isset($tonemap[$datatone]) ? $tonemap[$datatone] : 'Professional';

    $dataprimarycta = $data->primarycta ?? '';
    $ctamap = [
        'freetrial' => 'Start Free Trial',
        'joincommunity' => 'Join the Community',
        'explore' => 'Explore Courses',
        'register' => 'Register Now',
        'booksession' => 'Book a Session',
        'enroll' => 'Enroll Now',
        'subscribe' => 'Subscribe',
        'demo' => 'Book a Demo',
        'learnmore' => 'Learn More'
    ];
    $primarycta = isset($ctamap[$dataprimarycta]) ? $ctamap[$dataprimarycta] : 'Learn More';

    $dataprimarylanguage = $data->primarylanguage ?? '';
    $primarylanguagemap = [
        'english' => 'English',
        'arabic' => 'Arabic',
        'french' => 'French',
        'spanish' => 'Spanish',
        'other' => 'Other'
    ];
    $primarylangstr = isset($primarylanguagemap[$dataprimarylanguage]) ? $primarylanguagemap[$dataprimarylanguage] : 'English';

    $datatextdirection = $data->textdirection ?? '';
    $directionsmap = ['auto' => 'Auto-detect', 'ltr' => 'Left-to-Right (LTR)', 'rtl' => 'Right-to-Left (RTL)'];
    $directionstr = isset($directionsmap[$datatextdirection]) ? $directionsmap[$datatextdirection] : 'Auto-detect';

    $dataplatformmodel = $data->platformmodel ?? '';
    $modelsmap = [
        'free' => 'Free / Open Access',
        'paid' => 'Paid Courses',
        'subscription' => 'Subscription',
        'freemium' => 'Freemium'
    ];
    $modelstr = isset($modelsmap[$dataplatformmodel]) ? $modelsmap[$dataplatformmodel] : 'Paid Courses';

    $designreference = !empty($data->designreference) ? $data->designreference : '';
    $targetai = !empty($data->targetai) ? $data->targetai : 'claude';

    $slogan = !empty($data->slogan) ? $data->slogan : '';
    $extravideos = !empty($data->extravideos) ? $data->extravideos : '';
    $teaminfo = !empty($data->teaminfo) ? $data->teaminfo : '';

    // Contact Info string formatting
    $contactparts = [];
    if (!empty($data->contactemail)) {
        $contactparts[] = '- Email: ' . $data->contactemail;
    }
    if (!empty($data->contactphone)) {
        $contactparts[] = '- Phone: ' . $data->contactphone;
    }
    if (!empty($data->contactaddress)) {
        $contactparts[] = '- Address: ' . $data->contactaddress;
    }
    if (!empty($data->socialmedia)) {
        $contactparts[] = "- Social Media Links: \n   " . str_replace("\n", "\n   ", $data->socialmedia);
    }
    $contactstr = implode("\n   ", $contactparts);

    $statsstr = "";
    if (!empty($data->includestats)) {
        // Fetch real Moodle stats.
        $coursescount = max(0, $DB->count_records('course') - 1);
        $userscount = $DB->count_records_select('user', 'deleted = 0 AND suspended = 0 AND id > 2');

        $oldest = $DB->get_field_sql("SELECT MIN(timecreated) FROM {course} WHERE id > 1");
        $yearsactive = $oldest ? max(1, round((time() - $oldest) / YEARSECS)) : 1;

        $questioncount = $DB->get_manager()->table_exists('question') ? $DB->count_records('question') : 0;
        $modulescount = $DB->count_records('course_modules');

        $statsstr = "Please include a 'Platform Statistics' section featuring these real numbers:\n   - {$coursescount} Active Courses\n   - {$userscount} Registered Learners\n   - Over {$yearsactive} Years Active\n   - {$questioncount} Questions in Bank\n   - {$modulescount} Learning Activities\n";
    }

    // Build the prompt string.
    $prompt = "You are an expert web designer. I want you to create a high-converting, beautiful, responsive landing page using HTML and Tailwind CSS for my e-learning platform named '{$sitename}'.\n\n";

    if ($slogan) {
        $prompt .= "### SLOGAN / TAGLINE\n\"{$slogan}\"\n\n";
    }

    $prompt .= "### PROJECT OVERVIEW\n";
    $prompt .= "- **Identity:** {$siteidentity}\n";
    $prompt .= "- **Business Model:** {$modelstr}\n";
    $prompt .= "- **Target Audience:** {$audience}\n";
    $prompt .= "- **Vibe & Tone:** {$tone}\n";
    $prompt .= "- **Primary Language & Direction:** {$primarylangstr} ({$directionstr})\n";
    $prompt .= "- **Other Supported Languages:** {$selectedlanguages}\n\n";

    $prompt .= "### DESIGN & CONTENT REQUIREMENTS\n";
    $prompt .= "1. **Design Style:** Choose a theme that fits the '{$data->template}' aesthetic.\n";

    $prompt .= "2. **Hero Section:** Include a strong headline and a primary CTA button that says '{$primarycta}'. ";
    if (!empty($data->herovideo)) {
        $prompt .= "Include an embedded video player or a placeholder for this video link: {$data->herovideo}.\n";
    } else {
        $prompt .= "\n";
    }

    $sectionnum = 3;

    if (!empty($data->aboutus)) {
        $prompt .= "{$sectionnum}. **About Us / Our Vision:** Include a section with the following exact text:\n   \"{$data->aboutus}\"\n";
        $sectionnum++;
    }

    if ($statsstr) {
        $prompt .= "{$sectionnum}. **Platform Statistics:** {$statsstr}\n";
        $sectionnum++;
    }

    $prompt .= "{$sectionnum}. **Navigation Menu & Pages:** Include a clean, sticky navbar. Ensure navigation links for the following required pages: {$pagesstring}.\n";
    $prompt .= "   *(Note: You only need to code the Home page, but show these links in the header/footer)*\n";
    $sectionnum++;

    $prompt .= "{$sectionnum}. **Categories & Courses Data (JSON):** The platform has the following hierarchy of categories and courses. Please display them as attractive interactive cards, accordions, or a grid structure based on this JSON payload:\n";
    $prompt .= "```json\n" . $categoriestext . "\n```\n";
    $sectionnum++;

    if ($teaminfo) {
        $prompt .= "{$sectionnum}. **Our Team Section:** Create a team grid with avatars using these details:\n   " . str_replace("\n", "\n   ", $teaminfo) . "\n";
        $sectionnum++;
    }

    if ($extravideos) {
        $prompt .= "{$sectionnum}. **Additional Media:** Embed or link the following extra videos in a relevant section:\n   " . str_replace("\n", "\n   ", $extravideos) . "\n";
        $sectionnum++;
    }

    if ($contactstr) {
        $prompt .= "{$sectionnum}. **Contact & Footer:** Include a footer with the following contact information & social links:\n   {$contactstr}\n";
        $sectionnum++;
    }

    $prompt .= "\n### DESIGN AESTHETICS & ELITE PATTERNS (CRITICAL)\n";

    if ($designreference) {
        $prompt .= "1. **Primary Design Reference (Crucial!):** Meticulously study and emulate the aesthetic layout, component sizing, spacing pacing, and high-end visual luxury of this exact URL/template: {$designreference}.\n";
    }

    $prompt .= "2. **Design Quality (WOW Factor):** Do NOT build a basic, generic Minimum Viable Product. Create a breathtaking, creative, eye-catching, ultra-premium experience. Apply the visual storytelling logic of elite educational websites.\n";
    $prompt .= "3. **Layout & Grids (Bento Box):** Reject standard, boring 3-column Bootstrap-style identical height cards. Instead, use beautiful asymmetrical, interlocking 'Bento Box' style CSS grid layouts, combining large feature blocks with smaller descriptive squares for sections like News, Courses, or Community.\n";
    $prompt .= "4. **Expansive Hero & Storytelling:** The Hero section must be full-bleed (edge-to-edge), immersive, and visually explosive, accompanied by minimalist but massively impactful typography overlaid. Build a narrative flow as the user scrolls, pushing connection and value rather than just dumping course lists.\n";
    $prompt .= "5. **Micro-Interactions & Parallax:** Implement smooth scroll-triggered fade-ins (reveal animations). Enhance user engagement with slow scale-zooms on images upon hover. Use Tailwind 'group', 'peer', and 'transition' classes heavily to make the interface feel alive.\n";
    $prompt .= "6. **Editorial Typography & Hierarchy:** Avoid generic font pairing and never use browser-default fonts. Embed premium Google Fonts with extreme contrast: massive, elegant headings (using modern serif or geometric sans-serif) juxtaposed with ultra-legible body paragraphs.\n";
    $prompt .= "7. **Visual Enrichment:** Emphasize smooth subtle gradients, premium soft high-spread box-shadows (e.g., shadow-2xl with low opacity), oversized border radiuses (e.g., rounded-3xl), subtle floating navigation bars, and extensive, luxurious whitespace.\n";

    $prompt .= "\n### TECHNICAL SPECIFICATIONS FOR TARGET AI\n";

    switch ($targetai) {
        case 'claude':
            $prompt .= "- **Output Format:** Supply exactly ONE complete, standalone `index.html` file (using Tailwind CSS via CDN and Google Fonts). Do not split CSS/JS into separate files. Utilize Artifacts to show me the result immediately.\n";
            $prompt .= "- **Icons:** Include FontAwesome CDN for highly premium aesthetic iconography.\n";
            break;
        case 'chatgpt':
            $prompt .= "- **Output Format:** Supply exactly ONE complete `index.html` file (with Tailwind CSS via CDN and FontAwesome setup).\n";
            $prompt .= "- **CRITICAL RULE (DO NOT IGNORE):** Do NOT truncate code. Do NOT get lazy. It is strictly prohibited to use placeholders like `// ... rest of code`. You MUST output every single line from start to finish.\n";
            break;
        case 'v0':
            $prompt .= "- **React & Components:** Generate a fully functional React functional component using Tailwind CSS and standard shadcn/ui library primitives.\n";
            $prompt .= "- **Architecture:** Do not write raw old-school HTML. Use `lucide-react` for slick iconography and adhere strictly to v0 component structure compilation best practices. Make it look insanely gorgeous.\n";
            break;
        case 'bolt':
            $prompt .= "- **Project Blueprint:** Initialize an entire Vite + React + Tailwind + TypeScript environment. Do not output a single HTML file.\n";
            $prompt .= "- **Structure Check:** Generate necessary routing, mock APIs for the data provided above, and scaffold a beautiful folder structure (`/pages`, `/components`, `/assets`). Ensure the entire web application compiles successfully and flawlessly in your WebContainer.\n";
            break;
        case 'replit':
            $prompt .= "- **Agentic Setup:** You are a Replit Agent. I need you to initialize an ultra-fast web application workspace (e.g., Vite/React or Next.js with Tailwind). Do the scaffolding autonomously.\n";
            $prompt .= "- **Execution:** Automatically install required modules via terminal, spin up the webview, and build the UI. Mock the data accurately from the JSON provided.\n";
            break;
        case 'antigravity':
            $prompt .= "- **Task Execution:** You are Antigravity, an elite autonomous DeepMind IDE agent! Create a new directory named `theme_export_preview` right here in the current workspace.\n";
            $prompt .= "- **Implementation:** Write the HTML, CSS, and JS into neatly structured separate files within that directory. Once compiled, optionally use `run_command` to start a local development server (e.g. `python3 -m http.server` or `npm run dev`) so the user can instantly see your breathtaking work. Surprise me!\n";
            break;
        case 'cursor':
            $prompt .= "- **IDE Composer Flow:** Use your file-writing intelligence to generate a structured local project folder system (`src/`, `components/`, etc). Do not just output heavy code blocks in chat.\n";
            $prompt .= "- **Application:** Use Composer and your direct file system access to methodically generate, apply, and save the files directly into the editor workspace, ensuring everything resolves without build errors.\n";
            break;
    }

    $prompt .= "- **General Polish:** The design must be exceptionally modern, completely responsive (mobile-first), and ready to run immediately in a browser/container.\n";
    $prompt .= "- **Asset Policy:** Do not use ugly empty gray placeholders. If aesthetic imagery is required, embed visually striking Unsplash standard URLs (e.g., source.unsplash.com or specific beautiful stock URLs) to ensure the design feels real and expensive.\n";

    // Display the generated prompt.
    echo html_writer::tag('h3', get_string('generatedprompt', 'local_customhome'));
    echo html_writer::tag('textarea', htmlspecialchars($prompt), [
        'rows' => 15,
        'cols' => 80,
        'class' => 'form-control w-100 mb-3',
        'readonly' => 'readonly',
        'id' => 'generated_prompt_textarea'
    ]);

    // Quick JS button to copy to clipboard.
    echo html_writer::tag('button', get_string('copyclipboard', 'local_customhome'), [
        'class' => 'btn btn-primary mb-4',
        'type' => 'button',
        'onclick' => '
            var copyText = document.getElementById("generated_prompt_textarea");
            copyText.select();
            document.execCommand("copy");
            alert("Prompt copied to clipboard!");
        '
    ]);

    echo html_writer::empty_tag('hr');
}

// Display the form to the user.
$mform->display();

echo $OUTPUT->footer();
