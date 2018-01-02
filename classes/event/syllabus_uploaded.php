<?php

namespace block_syllabus\event;
defined('MOODLE_INTERNAL') || die();

class syllabus_uploaded extends \core\event\base
{
  protected function init()
  {
    $this->data['crud'] = 'c';
    $this->data['edulevel'] = self::LEVEL_TEACHING;
  }

  public static function get_name()
  {
    return get_string('eventsyllabusuploaded', 'block_syllabus');
  }


   public function get_description() {
       return "The user with id '". $this->userid ."' uploaded a syllabus for the " .
           "Syllabus Block with course id '$this->courseid'.";
   }

   public function get_url() {
       return new \moodle_url("/block/syllabus/block_syllabus.php",
               array('id' => $this->contextinstanceid));
   }
}
