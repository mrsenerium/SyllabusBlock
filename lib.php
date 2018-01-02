<?php
function block_syllabus_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options=array())
{
  global $DB; //DB is required

  if($context->contextlevel != CONTEXT_BLOCK)
    return false;

  require_login(); //Must be logged in to see the file

  $itemid = 0;

  $fs = get_file_storage();
  $filename = array_pop($args);
  if (empty($args))
  {
    $filepath = '/';
  }
  else
  {
    $filepath = '/'.implode('/', $args).'/';
  }
  $file = $fs->get_file($context->id, 'block_syllabus', $filearea, $itemid, $filepath, $filename);
  $event = \block_syllabus\event\syllabus_viewed::create(array(
      'context' => $context,
      'other' => array(
          'filename' => $filename,
      )
  ));//Logging Event created
  $event->trigger(); //Event Added to database
  send_stored_file($file, 0, 0, false, $options);
}
