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
        
        $categories = [
            '' => get_string('choose'),
            'academic' => get_string('cat_academic', 'local_customhome'),
            'corporate' => get_string('cat_corporate', 'local_customhome'),
            'ecommerce' => get_string('cat_ecommerce', 'local_customhome'),
            'kids' => get_string('cat_kids', 'local_customhome'),
            'coaching' => get_string('cat_coaching', 'local_customhome'),
            'health' => get_string('cat_health', 'local_customhome'),
            'creative' => get_string('cat_creative', 'local_customhome'),
            'tech' => get_string('cat_tech', 'local_customhome'),
            'language' => get_string('cat_language', 'local_customhome'),
            'community' => get_string('cat_community', 'local_customhome'),
        ];
        $mform->addElement('select', 'sitecategory', get_string('sitecategory', 'local_customhome'), $categories);

        $sub_academic = ['school' => 'School', 'university' => 'University/College', 'k12' => 'K-12 Platform', 'academy' => 'Specialized Academy'];
        $mform->addElement('select', 'sub_academic', get_string('sitesubcategory', 'local_customhome'), $sub_academic);
        $mform->hideIf('sub_academic', 'sitecategory', 'neq', 'academic');

        $sub_corporate = ['internal' => 'Internal Employee Training', 'compliance' => 'Compliance & Safety', 'b2b' => 'B2B Client Training'];
        $mform->addElement('select', 'sub_corporate', get_string('sitesubcategory', 'local_customhome'), $sub_corporate);
        $mform->hideIf('sub_corporate', 'sitecategory', 'neq', 'corporate');

        $sub_ecommerce = ['b2c' => 'B2C Course Sales', 'subscription' => 'Subscription/Membership', 'masterclass' => 'Masterclasses'];
        $mform->addElement('select', 'sub_ecommerce', get_string('sitesubcategory', 'local_customhome'), $sub_ecommerce);
        $mform->hideIf('sub_ecommerce', 'sitecategory', 'neq', 'ecommerce');

        $sub_kids = ['early' => 'Early Childhood', 'gamified' => 'Gamified Learning', 'stem' => 'STEM for Kids', 'arts' => 'Kids Arts & Crafts'];
        $mform->addElement('select', 'sub_kids', get_string('sitesubcategory', 'local_customhome'), $sub_kids);
        $mform->hideIf('sub_kids', 'sitecategory', 'neq', 'kids');

        $sub_coaching = ['1on1' => '1-on-1 Mentorship', 'group' => 'Group Coaching', 'testprep' => 'Test Preparation'];
        $mform->addElement('select', 'sub_coaching', get_string('sitesubcategory', 'local_customhome'), $sub_coaching);
        $mform->hideIf('sub_coaching', 'sitecategory', 'neq', 'coaching');

        $sub_health = ['yoga' => 'Yoga & Mindfulness', 'fitness' => 'Personal Training', 'nutrition' => 'Nutrition & Diet'];
        $mform->addElement('select', 'sub_health', get_string('sitesubcategory', 'local_customhome'), $sub_health);
        $mform->hideIf('sub_health', 'sitecategory', 'neq', 'health');

        $sub_creative = ['design' => 'Design & Illustration', 'music' => 'Music Production', 'photo' => 'Photography & Video'];
        $mform->addElement('select', 'sub_creative', get_string('sitesubcategory', 'local_customhome'), $sub_creative);
        $mform->hideIf('sub_creative', 'sitecategory', 'neq', 'creative');

        $sub_tech = ['bootcamp' => 'Coding Bootcamp', 'data' => 'Data Science & AI', 'cert' => 'IT Certification'];
        $mform->addElement('select', 'sub_tech', get_string('sitesubcategory', 'local_customhome'), $sub_tech);
        $mform->hideIf('sub_tech', 'sitecategory', 'neq', 'tech');

        $sub_language = ['esl' => 'English as a Second Language', 'immersion' => 'Language Immersion', 'exam' => 'Language Exam Prep (IELTS/TOEFL)'];
        $mform->addElement('select', 'sub_language', get_string('sitesubcategory', 'local_customhome'), $sub_language);
        $mform->hideIf('sub_language', 'sitecategory', 'neq', 'language');

        $sub_community = ['hobby' => 'Hobby & Crafts', 'diy' => 'Home & DIY', 'pet' => 'Pet Care & Training'];
        $mform->addElement('select', 'sub_community', get_string('sitesubcategory', 'local_customhome'), $sub_community);
        $mform->hideIf('sub_community', 'sitecategory', 'neq', 'community');

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

        $audiences = ['beginners'=>'Beginners/Novices', 'professionals'=>'Working Professionals', 'children'=>'Children & Parents', 'hobbyists'=>'Hobbyists', 'corporates'=>'Corporate Entities'];
        $mform->addElement('select', 'audience', get_string('targetaudience', 'local_customhome'), $audiences);
        
        $tones = ['professional'=>'Professional & Trustworthy', 'fun'=>'Fun & Energetic', 'calm'=>'Calm & Minimalist', 'bold'=>'Bold & Innovative'];
        $mform->addElement('select', 'tone', get_string('coretone', 'local_customhome'), $tones);

        $ctas = ['freetrial'=>'Start Free Trial', 'enroll'=>'Enroll Now', 'subscribe'=>'Subscribe', 'demo'=>'Book a Demo', 'learnmore'=>'Learn More'];
        $mform->addElement('select', 'primarycta', get_string('primarycta', 'local_customhome'), $ctas);

        $templates = [
            'modern' => get_string('template_modern', 'local_customhome'),
            'corporate' => get_string('template_corporate', 'local_customhome'),
            'playful' => get_string('template_playful', 'local_customhome'),
        ];
        $mform->addElement('select', 'template', get_string('template', 'local_customhome'), $templates);
        $mform->setDefault('template', 'modern');

        // Hero Video Link
        $mform->addElement('text', 'herovideo', get_string('herovideo', 'local_customhome'), ['size' => '50']);
        $mform->setType('herovideo', PARAM_URL);

        // About Us / Vision
        $mform->addElement('textarea', 'aboutus', get_string('aboutus', 'local_customhome'), ['wrap' => 'virtual', 'rows' => 5, 'cols' => 50]);
        $mform->setType('aboutus', PARAM_TEXT);

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

    // Fetch visible categories from the database.
    $categories = $DB->get_records_select('course_categories', 'visible = 1', null, 'sortorder ASC', 'id, name, description');
    
    $cat_list = [];
    foreach ($categories as $cat) {
        $cat_list[] = "- " . format_string($cat->name);
    }
    $categories_text = implode("\n", $cat_list);

    $sitename = format_string($CFG->sitename);

    // Extract Site Type
    $sitecat_key = $data->sitecategory;
    $subcategory_field = 'sub_' . $sitecat_key;
    $subcategory = !empty($data->$subcategory_field) ? $data->$subcategory_field : '';
    $site_type_str = $sitecat_key ? ucfirst($sitecat_key) . ($subcategory ? " ({$subcategory})" : '') : 'General E-Learning';

    // Extract Languages
    $selected_languages = !empty($data->languages) ? implode(', ', $data->languages) : 'English';
    
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
    $audience_map = ['beginners'=>'Beginners/Novices', 'professionals'=>'Working Professionals', 'children'=>'Children & Parents', 'hobbyists'=>'Hobbyists', 'corporates'=>'Corporate Entities'];
    $audience = isset($audience_map[$data->audience]) ? $audience_map[$data->audience] : 'General learners';
    
    $tone_map = ['professional'=>'Professional & Trustworthy', 'fun'=>'Fun & Energetic', 'calm'=>'Calm & Minimalist', 'bold'=>'Bold & Innovative'];
    $tone = isset($tone_map[$data->tone]) ? $tone_map[$data->tone] : 'Professional';
    
    $cta_map = ['freetrial'=>'Start Free Trial', 'enroll'=>'Enroll Now', 'subscribe'=>'Subscribe', 'demo'=>'Book a Demo', 'learnmore'=>'Learn More'];
    $primarycta = isset($cta_map[$data->primarycta]) ? $cta_map[$data->primarycta] : 'Learn More';

    // Build the prompt string.
    $prompt = "You are an expert web designer. I want you to create a high-converting, beautiful, responsive landing page using HTML and Tailwind CSS for my e-learning platform named '{$sitename}'.\n\n";
    
    $prompt .= "### PROJECT OVERVIEW\n";
    $prompt .= "- **Site Type:** {$site_type_str}\n";
    $prompt .= "- **Target Audience:** {$audience}\n";
    $prompt .= "- **Vibe & Tone:** {$tone}\n";
    $prompt .= "- **Supported Languages:** {$selected_languages}\n\n";

    $prompt .= "### DESIGN & CONTENT REQUIREMENTS\n";
    $prompt .= "1. **Design Style:** Choose a theme that fits the '{$data->template}' aesthetic.\n";
    
    if (!empty($data->herovideo)) {
        $prompt .= "2. **Hero Section:** Include an embedded video player or a placeholder for this video link: {$data->herovideo}. Make the CTA button say '{$primarycta}'.\n";
    } else {
        $prompt .= "2. **Hero Section:** Include a strong headline and a primary CTA button that says '{$primarycta}'.\n";
    }

    if (!empty($data->aboutus)) {
        $prompt .= "3. **About Us / Our Vision:** Include a section with the following exact text:\n   \"{$data->aboutus}\"\n";
    }
    
    $prompt .= "\n4. **Navigation Menu & Pages:** Include a clean, sticky navbar. Ensure navigation links for the following required pages: {$pages_string}.\n";
    $prompt .= "   *(Note: You only need to code the Home page, but show these links in the header/footer)*\n";

    $prompt .= "\n5. **Categories Section:** The platform has the following active course categories. Please display them as attractive cards or a grid:\n";
    $prompt .= $categories_text . "\n";
    
    $prompt .= "\n### TECHNICAL REQUIREMENTS\n";
    $prompt .= "- Return ONLY the complete HTML code containing the Tailwind CDN script in the <head>.\n";
    $prompt .= "- Include FontAwesome CDN for relevant icons.\n";
    $prompt .= "- The design must be modern, responsive, and ready to be used as an index.html file.\n";
    $prompt .= "- Add subtle hover animations and transitions using Tailwind's utility classes.\n";

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
