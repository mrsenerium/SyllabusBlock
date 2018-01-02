<?php
require_once($CFG->libdir."/formslib.php");

class syllabus_form extends moodleform
{
  function definition()
  {
    $mform = $this->_form;
    $filemanageropts = $this->_customdata['filemanageropts'];
    $mform->addElement('static', 'fileTypes', 'Preferred Document Formats',
            'Adobe PDF(.pdf), Word Document(.doc .docx), Power Point(.ppt .pptx), Image(.jpg .jpeg .png)');
    //Set Variables for POST
    $mform->setType('blockid', PARAM_INT);
    $mform->setType('courseid', PARAM_INT);
    $mform->addElement('hidden', 'blockid');
    $mform->addElement('hidden', 'courseid');
    $mform->addElement('filemanager', 'attachments', 'Upload Syllabus', null,  $filemanageropts);
    $this->add_action_buttons(); //Buttons at the bottom
  }
}
