<?php
/*
*   This Block is an Honest to God Syllabus Block
*   The goal of this block is to provide an easy place for Instructors to upload Syllabi
*   and allow students an easy place to find it and provide consistancy for end users.
*   It was developed by Butler University Starting in September 2016 and Requires Moodle 2.9.1+
*/
class block_syllabus extends block_base
{
  public function init()
  {
    $this->title = get_string('syllabus', 'block_syllabus');
  }

  public function get_content()
  {
    $this->content = new stdClass;
    global $CFG, $USER, $DB, $OUTPUT, $PAGE, $COURSE;
    $context = CONTEXT_BLOCK::instance($this->instance->id);
    $fs = get_file_storage();
    $files = $fs->get_area_files($context->id, 'block_syllabus' ,'attachment', 0, 'sortorder', false);
    $url = new moodle_url('/blocks/syllabus/view.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));
    if(!empty($files)) //Is there Syllabus Information to show
    {
      foreach($files as $file)
      {
        $fileurl = moodle_url::make_pluginfile_url($file->get_contextid(), $file->get_component(), $file->get_filearea(),
            null, $file->get_filepath(), $file->get_filename()); //Retrieve the files
        $iconimage = $OUTPUT->pix_icon(file_file_icon($file, '32'), get_mimetype_description($file), 'moodle');
        if(empty($this->content->text))
        {
          $this->content->text = format_text("<a href=\"$fileurl\">".$iconimage.($file->get_filename())."</a>", FORMAT_HTML, array('context'=>$context));
        }
        else
        {
          $this->content->text = $this->content->text . "<br />" .
            format_text("<a href=\"$fileurl\">".$iconimage.($file->get_filename())."</a>", FORMAT_HTML, array('context'=>$context));
        }
      }
    }
    else if(has_capability('block/syllabus:manageblock', $context))
    {
        $this->content->footer = "<br />" . html_writer::link($url, 'Upload Syllabus');
    }


    if(has_capability('block/syllabus:manageblock', $context) && $PAGE->user_is_editing())//cannot edit without permission
      $this->content->footer = "<br />" . html_writer::link($url, 'Upload Syllabus');
  }
}
