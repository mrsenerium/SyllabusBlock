<?php

defined('MOODLE_INTERNAL') || die();

$obsrevers = array(
    array (
        'eventname' => '*',
        'callback'  => 'syllabus_block_observer::observe_all',
    ),

    array (
      'eventname' => 'block_syllabus_syllabus_uploaded',
      'callback' => 'syllabus_block_observer::observe_upload',
      )
);
