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

        // Design Template
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

    // Build the prompt string.
    $prompt = "You are an expert web designer. I want you to create a high-converting, beautiful, responsive landing page using HTML and Tailwind CSS for my e-learning platform named '{$sitename}'.\n\n";
    $prompt .= "1. Design Style: Choose a theme that fits the '{$data->template}' aesthetic.\n";
    
    if (!empty($data->herovideo)) {
        $prompt .= "2. Hero Section: Include an embedded video player or a placeholder for this video link: {$data->herovideo}\n";
    }
    if (!empty($data->aboutus)) {
        $prompt .= "3. About Us / Our Vision: Include a section with the following text exactly:\n\"{$data->aboutus}\"\n";
    }
    
    $prompt .= "\n4. Navigation Menu: Include a clean, sticky navbar with the following links: Home, Courses/Catalog, About Us, Login/Dashboard.\n";
    $prompt .= "\n5. Categories Section: The platform has the following active course categories. Please display them as attractive cards or a grid:\n";
    $prompt .= $categories_text . "\n";
    
    $prompt .= "\nRequirements:\n";
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
