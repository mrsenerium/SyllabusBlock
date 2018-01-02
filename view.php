<?php
require_once('../../config.php');
require_once('lib.php');
require_once('syllabus_form.php');

global $CFG, $USER, $DB, $OUTPUT, $PAGE;


$courseid = required_param('courseid', PARAM_INT);
$blockid = required_param('blockid', PARAM_INT);
$thispage = new moodle_url('/blocks/syllabus/view.php', array('blockid' => $blockid, 'courseid' => $courseid));
$mainpage = new moodle_url('/course/view.php', array('id' => $courseid));

$PAGE->set_url($mainpage);
require_login();

$PAGE->set_pagelayout('standard');

$context = CONTEXT_BLOCK::instance($blockid);
$PAGE->set_context($context);

$PAGE->set_title('Syllabus Block Upload');
$PAGE->set_heading('Syllabus Block Upload');

if(!has_capability('block/syllabus:manageblock', $context)) //I can haz purrmissun 2c
  redirect($mainpage);                                      //no? kthxbai

$settingsnode = $PAGE->settingsnav->add(get_string('syllabus', 'block_syllabus')); //Bread Crumbs
$editurl = $thispage;
$editnode = $settingsnode->add(get_string('editpage', 'block_syllabus'), $editurl); //Side Editing Options
$editnode->make_active();

//Page Logic

$itemid = 0;
$draftitemid = file_get_submitted_draft_itemid('attachment');
$entry = new stdClass();
$entry->courseid = $courseid;
$entry->blockid = $blockid;
$filemanageropts = array('subdirs' => 0, 'maxbytes' => 0, 'maxfiles' => 50, 'context' => $context);
$customdata = array('filemanageropts' => $filemanageropts);

$mform = new syllabus_form(null, $customdata);
file_prepare_draft_area($draftitemid, $context->id, 'block_syllabus', 'attachment', $itemid, $filemanageropts);
$entry->attachments = $draftitemid;

$mform->set_data($entry);
if($mform->is_cancelled())
{
  redirect($mainpage); //Go to Mainpage and Save Nothing
}
else if($data = $mform->get_data())
{
  file_save_draft_area_files($data->attachments, $context->id, 'block_syllabus', 'attachment', $itemid, $filemanageropts);
  $files = $data->attachments;
  print_object($files);
  $event = \block_syllabus\event\syllabus_uploaded::create(array(
      'context' => $context
  ));//Log Event Created
  $event->trigger();//Log Event added to Event DB
  redirect($mainpage); //Save the file(s) then go to Main Page
}
else //First Run of Form nothing exists in POST
{
  echo $OUTPUT->header();
  $mform->display();
  echo $OUTPUT->footer();
}
