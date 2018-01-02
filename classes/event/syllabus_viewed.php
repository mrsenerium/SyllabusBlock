<?php

namespace block_syllabus\event;
defined('MOODLE_INTERNAL') || die();

class syllabus_viewed extends \core\event\base
{
  protected function init()
  {
    $this->data['crud'] = 'c';
    $this->data['edulevel'] = self::LEVEL_PARTICIPATING;
  }

  public static function get_name()
  {
    return get_string('eventsyllabusviewed', 'block_syllabus');
  }


   public function get_description() {
       $filename = $this->other;
       $filename = $filename['filename'];
       return "The user with id '$this->userid' downloaded '" . $this->other['filename'] . "' for the " .
           "Syllabus Block with course id '$this->courseid'.";
   }

   public function get_url() {
       return new \moodle_url("/block/syllabus/block_syllabus.php",
               array('id' => $this->contextinstanceid));
   }
}
