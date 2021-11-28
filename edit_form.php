<?php
/**
 * Form to configure block_course_count instances.
 *
 * @package    block_course_count
 * @author     John Illsley
 */

defined('MOODLE_INTERNAL') || die();

class block_course_count_edit_form extends block_edit_form {
    /**
     * The definition of the fields to use.
     *
     * @param MoodleQuickForm $mform
     */
    protected function specific_definition($mform) {

        $blockconfig = get_config('block_course_count');

        $configviewdefault = (isset($blockconfig->config_view)) ?  $blockconfig->config_view : BLOCK_COURSE_COUNT_DEFAULT_VIEW;

        // Section header title according to language file.
        $mform->addElement('header', 'config_header', get_string('blocksettings', 'block'));

        $options = array(
            'date'          => get_string('show_current_date', 'block_course_count'),
            'course_count'  => get_string('show_active_courses', 'block_course_count')
        );

        $mform->addElement('select', 'config_view', get_string('numberoftags', 'blog'), $options);
        $mform->setDefault('config_view', $configviewdefault);

    }
}