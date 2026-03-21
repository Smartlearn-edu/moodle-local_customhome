<?php
/**
 * AI Prompt Generator Tool
 *
 * @package    local_customhome
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');
require_once($CFG->libdir . '/adminlib.php');
require_once($CFG->libdir . '/formslib.php');

// Require admin access.
admin_externalpage_setup('local_customhome_prompt');

// Define the form.
class local_customhome_prompt_form extends moodleform {
    public function definition() {
        $mform = $this->_form;

        // --- Site Identity & Type ---
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
        $sub_tech = ['bootcamp' => 'Coding Bootcamp', 'data' => 'Data Science & AI', 'cert' => 'IT Certification'];
        $mform->addElement('select', 'sub_tech', get_string('sitesubcategory', 'local_customhome'), $sub_tech);
        $mform->hideIf('sub_tech', 'contentfocus', 'neq', 'tech');

        $sub_language = ['esl' => 'English as a Second Language', 'immersion' => 'Language Immersion', 'exam' => 'Language Exam Prep (IELTS/TOEFL)'];
        $mform->addElement('select', 'sub_language', get_string('sitesubcategory', 'local_customhome'), $sub_language);
        $mform->hideIf('sub_language', 'contentfocus', 'neq', 'language');
        
        $sub_islamic = ['quran' => 'Quran Studies', 'fiqh' => 'Fiqh & Jurisprudence', 'seerah' => 'Seerah & History', 'kidsislam' => 'Islamic Studies for Kids'];
        $mform->addElement('select', 'sub_islamic', get_string('sitesubcategory', 'local_customhome'), $sub_islamic);
        $mform->hideIf('sub_islamic', 'contentfocus', 'neq', 'islamic');

        $sub_creative = ['design' => 'Design & Illustration', 'music' => 'Music Production', 'photo' => 'Photography & Video'];
        $mform->addElement('select', 'sub_creative', get_string('sitesubcategory', 'local_customhome'), $sub_creative);
        $mform->hideIf('sub_creative', 'contentfocus', 'neq', 'creative');

        $sub_wellness = ['yoga' => 'Yoga & Mindfulness', 'fitness' => 'Personal Training', 'nutrition' => 'Nutrition & Diet'];
        $mform->addElement('select', 'sub_wellness', get_string('sitesubcategory', 'local_customhome'), $sub_wellness);
        $mform->hideIf('sub_wellness', 'contentfocus', 'neq', 'wellness');

        $sub_academic = ['exam' => 'Exam Preparation', 'stem' => 'STEM Subjects', 'humanities' => 'Arts & Humanities'];
        $mform->addElement('select', 'sub_academic', get_string('sitesubcategory', 'local_customhome'), $sub_academic);
        $mform->hideIf('sub_academic', 'contentfocus', 'neq', 'academic');

        $sub_kids = ['early' => 'Early Childhood', 'gamified' => 'Gamified Learning', 'stemkids' => 'STEM for Kids', 'artskids' => 'Kids Arts & Crafts'];
        $mform->addElement('select', 'sub_kids', get_string('sitesubcategory', 'local_customhome'), $sub_kids);
        $mform->hideIf('sub_kids', 'contentfocus', 'neq', 'kids');

        $sub_business = ['leadership' => 'Leadership & Management', 'finance' => 'Finance & Accounting', 'marketing' => 'Digital Marketing'];
        $mform->addElement('select', 'sub_business', get_string('sitesubcategory', 'local_customhome'), $sub_business);
        $mform->hideIf('sub_business', 'contentfocus', 'neq', 'business');

        $sub_hobby = ['diy' => 'Home & DIY', 'pet' => 'Pet Care & Training', 'gardening' => 'Gardening', 'cooking' => 'Cooking & Baking'];
        $mform->addElement('select', 'sub_hobby', get_string('sitesubcategory', 'local_customhome'), $sub_hobby);
        $mform->hideIf('sub_hobby', 'contentfocus', 'neq', 'hobby');

        // --- Platform Features ---
        $mform->addElement('header', 'hdr_features', get_string('features_hdr', 'local_customhome'));
        
        $languages = ['English'=>'English', 'Spanish'=>'Spanish', 'French'=>'French', 'German'=>'German', 'Arabic'=>'Arabic', 'Chinese'=>'Chinese', 'Japanese'=>'Japanese', 'Portuguese'=>'Portuguese', 'Russian'=>'Russian', 'Italian'=>'Italian', 'Hindi'=>'Hindi'];
        $mform->addElement('select', 'languages', get_string('languages', 'local_customhome'), $languages);
        $mform->getElement('languages')->setMultiple(true);
        $mform->addHelpButton('languages', 'languages', 'local_customhome');

        // --- Required Pages & Structure ---
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

        // --- Design & Audience Preferences ---
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

        $audiences = ['beginners'=>'Beginners/Novices', 'professionals'=>'Working Professionals', 'children'=>'Children & Parents', 'hobbyists'=>'Hobbyists', 'corporates'=>'Corporate Entities'];
        $mform->addElement('select', 'audience', get_string('targetaudience', 'local_customhome'), $audiences);
        
        $tones = ['professional'=>'Professional & Trustworthy', 'fun'=>'Fun & Energetic', 'calm'=>'Calm & Minimalist', 'bold'=>'Bold & Innovative'];
        $mform->addElement('select', 'tone', get_string('coretone', 'local_customhome'), $tones);

        $ctas = ['freetrial'=>'Start Free Trial', 'joincommunity'=>'Join the Community', 'explore'=>'Explore Courses', 'register'=>'Register Now', 'booksession'=>'Book a Session', 'enroll'=>'Enroll Now', 'subscribe'=>'Subscribe', 'demo'=>'Book a Demo', 'learnmore'=>'Learn More'];
        $mform->addElement('select', 'primarycta', get_string('primarycta', 'local_customhome'), $ctas);

        $templates = [
            'modern' => get_string('template_modern', 'local_customhome'),
            'corporate' => get_string('template_corporate', 'local_customhome'),
            'playful' => get_string('template_playful', 'local_customhome'),
        ];
        $mform->addElement('select', 'template', get_string('template', 'local_customhome'), $templates);
        $mform->setDefault('template', 'modern');

        // --- Branding & Contact ---
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

        // --- Our Team ---
        $mform->addElement('header', 'hdr_team', get_string('hdr_team', 'local_customhome'));
        
        $mform->addElement('textarea', 'teaminfo', get_string('teaminfo', 'local_customhome'), ['wrap' => 'virtual', 'rows' => 5, 'cols' => 50]);
        $mform->setType('teaminfo', PARAM_TEXT);
        $mform->addHelpButton('teaminfo', 'teaminfo', 'local_customhome');

        // --- Media & About ---
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
    $cat_refs = [];

    // Initialize all categories in reference array.
    foreach ($categories as $cat) {
        $cat_refs[$cat->id] = [
            'name' => format_string($cat->name),
            'description' => trim(strip_tags(format_string($cat->description))),
            'subcategories' => [],
            'courses' => []
        ];
    }

    // Assign courses to their categories.
    foreach ($courses as $c) {
        if (isset($cat_refs[$c->category])) {
            $cat_refs[$c->category]['courses'][] = [
                'name' => format_string($c->fullname),
                'description' => trim(strip_tags(format_string($c->summary)))
            ];
        }
    }

    // Build the tree using the 'parent' field.
    foreach ($categories as $cat) {
        if (empty($cat->parent) || !isset($cat_refs[$cat->parent])) {
            // Root category or parent is somehow missing/hidden.
            $tree[] = &$cat_refs[$cat->id];
        } else {
            // Child category.
            $cat_refs[$cat->parent]['subcategories'][] = &$cat_refs[$cat->id];
        }
    }

    // Recursively remove empty arrays to keep JSON clean.
    $clean_tree = function(&$node) use (&$clean_tree) {
        if (empty($node['description'])) { unset($node['description']); }
        if (empty($node['subcategories'])) {
            unset($node['subcategories']);
        } else {
            foreach (array_keys($node['subcategories']) as $k) {
                $clean_tree($node['subcategories'][$k]);
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
        $clean_tree($tree[$k]);
    }

    $categories_text = json_encode($tree, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

    $sitename = format_string(get_site()->fullname);

    // Extract Site Type
    $data_sitetype = $data->sitetype ?? '';
    $sitetypes_map = ['school'=>'School (K-12)', 'university'=>'University', 'corporate'=>'Corporate', 'marketplace'=>'Marketplace', 'coaching'=>'Coaching', 'ngo'=>'NGO', 'gov'=>'Government', 'religious'=>'Religious Institution', 'health'=>'Health & Medical'];
    $sitetype_str = isset($sitetypes_map[$data_sitetype]) ? $sitetypes_map[$data_sitetype] : 'Educational Institution';

    $data_contentfocus = $data->contentfocus ?? '';
    $focuses_map = ['tech'=>'Tech & Coding', 'language'=>'Language Learning', 'islamic'=>'Islamic Education', 'creative'=>'Creative Arts', 'wellness'=>'Health & Wellness', 'academic'=>'Academic', 'kids'=>'Kids Learning', 'business'=>'Business & Professional', 'hobby'=>'Hobby & Lifestyle'];
    $focus_str = isset($focuses_map[$data_contentfocus]) ? $focuses_map[$data_contentfocus] : 'General E-Learning';

    $subcategory_field = 'sub_' . $data_contentfocus;
    $subcategory_str = !empty($data->$subcategory_field) ? $data->$subcategory_field : '';

    $site_identity = "Site Type: {$sitetype_str} | Content Focus: {$focus_str}";
    if ($subcategory_str) {
        $site_identity .= " | Sub-category: {$subcategory_str}";
    }

    // Extract Languages
    $selected_languages = !empty($data->languages) ? implode(', ', $data->languages) : 'None provided';
    
    // Extract Pages
    $selected_pages = [];
    $pages_map = [
        'home' => 'Home', 'about' => 'About Us', 'contact' => 'Contact Us',
        'courses' => 'Our Courses', 'faq' => 'FAQ', 'testimonials' => 'Testimonials',
        'pricing' => 'Pricing', 'blog' => 'Blog', 'login' => 'Login/Register'
    ];
    if (!empty($data->reqpages)) {
        foreach ($data->reqpages as $key => $val) {
            if ($val && isset($pages_map[$key])) {
                $selected_pages[] = $pages_map[$key];
            }
        }
    }
    $pages_string = !empty($selected_pages) ? implode(', ', $selected_pages) : 'Home, About Us, Courses';

    // Competitor features
    $data_audience = $data->audience ?? '';
    $audience_map = ['beginners'=>'Beginners/Novices', 'professionals'=>'Working Professionals', 'children'=>'Children & Parents', 'hobbyists'=>'Hobbyists', 'corporates'=>'Corporate Entities'];
    $audience = isset($audience_map[$data_audience]) ? $audience_map[$data_audience] : 'General learners';
    
    $data_tone = $data->tone ?? '';
    $tone_map = ['professional'=>'Professional & Trustworthy', 'fun'=>'Fun & Energetic', 'calm'=>'Calm & Minimalist', 'bold'=>'Bold & Innovative'];
    $tone = isset($tone_map[$data_tone]) ? $tone_map[$data_tone] : 'Professional';
    
    $data_primarycta = $data->primarycta ?? '';
    $cta_map = ['freetrial'=>'Start Free Trial', 'joincommunity'=>'Join the Community', 'explore'=>'Explore Courses', 'register'=>'Register Now', 'booksession'=>'Book a Session', 'enroll'=>'Enroll Now', 'subscribe'=>'Subscribe', 'demo'=>'Book a Demo', 'learnmore'=>'Learn More'];
    $primarycta = isset($cta_map[$data_primarycta]) ? $cta_map[$data_primarycta] : 'Learn More';

    $data_primarylanguage = $data->primarylanguage ?? '';
    $primarylanguage_map = ['english'=>'English', 'arabic'=>'Arabic', 'french'=>'French', 'spanish'=>'Spanish', 'other'=>'Other'];
    $primarylang_str = isset($primarylanguage_map[$data_primarylanguage]) ? $primarylanguage_map[$data_primarylanguage] : 'English';

    $data_textdirection = $data->textdirection ?? '';
    $directions_map = ['auto'=>'Auto-detect', 'ltr'=>'Left-to-Right (LTR)', 'rtl'=>'Right-to-Left (RTL)'];
    $direction_str = isset($directions_map[$data_textdirection]) ? $directions_map[$data_textdirection] : 'Auto-detect';

    $data_platformmodel = $data->platformmodel ?? '';
    $models_map = ['free'=>'Free / Open Access', 'paid'=>'Paid Courses', 'subscription'=>'Subscription', 'freemium'=>'Freemium'];
    $model_str = isset($models_map[$data_platformmodel]) ? $models_map[$data_platformmodel] : 'Paid Courses';

    $designreference = !empty($data->designreference) ? $data->designreference : '';
    $target_ai = !empty($data->targetai) ? $data->targetai : 'claude';

    $slogan = !empty($data->slogan) ? $data->slogan : '';
    $extravideos = !empty($data->extravideos) ? $data->extravideos : '';
    $teaminfo = !empty($data->teaminfo) ? $data->teaminfo : '';
    
    // Contact Info string formatting
    $contact_parts = [];
    if (!empty($data->contactemail)) { $contact_parts[] = '- Email: ' . $data->contactemail; }
    if (!empty($data->contactphone)) { $contact_parts[] = '- Phone: ' . $data->contactphone; }
    if (!empty($data->contactaddress)) { $contact_parts[] = '- Address: ' . $data->contactaddress; }
    if (!empty($data->socialmedia)) { $contact_parts[] = "- Social Media Links: \n   " . str_replace("\n", "\n   ", $data->socialmedia); }
    $contact_str = implode("\n   ", $contact_parts);

    $stats_str = "";
    if (!empty($data->includestats)) {
        // Fetch real Moodle stats.
        $courses_count = max(0, $DB->count_records('course') - 1);
        $users_count = $DB->count_records_select('user', 'deleted = 0 AND suspended = 0 AND id > 2');
        
        $oldest = $DB->get_field_sql("SELECT MIN(timecreated) FROM {course} WHERE id > 1");
        $years_active = $oldest ? max(1, round((time() - $oldest) / YEARSECS)) : 1;
        
        $question_count = $DB->get_manager()->table_exists('question') ? $DB->count_records('question') : 0;
        $modules_count = $DB->count_records('course_modules');
        
        $stats_str = "Please include a 'Platform Statistics' section featuring these real numbers:\n   - {$courses_count} Active Courses\n   - {$users_count} Registered Learners\n   - Over {$years_active} Years Active\n   - {$question_count} Questions in Bank\n   - {$modules_count} Learning Activities\n";
    }

    // Build the prompt string.
    $prompt = "You are an expert web designer. I want you to create a high-converting, beautiful, responsive landing page using HTML and Tailwind CSS for my e-learning platform named '{$sitename}'.\n\n";
    
    if ($slogan) {
        $prompt .= "### SLOGAN / TAGLINE\n\"{$slogan}\"\n\n";
    }

    $prompt .= "### PROJECT OVERVIEW\n";
    $prompt .= "- **Identity:** {$site_identity}\n";
    $prompt .= "- **Business Model:** {$model_str}\n";
    $prompt .= "- **Target Audience:** {$audience}\n";
    $prompt .= "- **Vibe & Tone:** {$tone}\n";
    $prompt .= "- **Primary Language & Direction:** {$primarylang_str} ({$direction_str})\n";
    $prompt .= "- **Other Supported Languages:** {$selected_languages}\n\n";

    $prompt .= "### DESIGN & CONTENT REQUIREMENTS\n";
    $prompt .= "1. **Design Style:** Choose a theme that fits the '{$data->template}' aesthetic.\n";
    
    $prompt .= "2. **Hero Section:** Include a strong headline and a primary CTA button that says '{$primarycta}'. ";
    if (!empty($data->herovideo)) {
        $prompt .= "Include an embedded video player or a placeholder for this video link: {$data->herovideo}.\n";
    } else {
        $prompt .= "\n";
    }

    $section_num = 3;

    if (!empty($data->aboutus)) {
        $prompt .= "{$section_num}. **About Us / Our Vision:** Include a section with the following exact text:\n   \"{$data->aboutus}\"\n";
        $section_num++;
    }

    if ($stats_str) {
        $prompt .= "{$section_num}. **Platform Statistics:** {$stats_str}\n";
        $section_num++;
    }

    $prompt .= "{$section_num}. **Navigation Menu & Pages:** Include a clean, sticky navbar. Ensure navigation links for the following required pages: {$pages_string}.\n";
    $prompt .= "   *(Note: You only need to code the Home page, but show these links in the header/footer)*\n";
    $section_num++;

    $prompt .= "{$section_num}. **Categories & Courses Data (JSON):** The platform has the following hierarchy of categories and courses. Please display them as attractive interactive cards, accordions, or a grid structure based on this JSON payload:\n";
    $prompt .= "```json\n" . $categories_text . "\n```\n";
    $section_num++;

    if ($teaminfo) {
        $prompt .= "{$section_num}. **Our Team Section:** Create a team grid with avatars using these details:\n   " . str_replace("\n", "\n   ", $teaminfo) . "\n";
        $section_num++;
    }

    if ($extravideos) {
        $prompt .= "{$section_num}. **Additional Media:** Embed or link the following extra videos in a relevant section:\n   " . str_replace("\n", "\n   ", $extravideos) . "\n";
        $section_num++;
    }

    if ($contact_str) {
        $prompt .= "{$section_num}. **Contact & Footer:** Include a footer with the following contact information & social links:\n   {$contact_str}\n";
        $section_num++;
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
    
    switch ($target_ai) {
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
