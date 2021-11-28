<?php
/**
 * Admin settings block_course_count.
 *
 * @package    block_course_count
 * @author     John Illsley
 */

defined('MOODLE_INTERNAL') || die;

if ($ADMIN->fulltree) {

    $options = array(
        'date'          => get_string('show_current_date', 'block_course_count'),
        'course_count'  => get_string('show_active_courses', 'block_course_count')
    );

    $settings->add(
        new admin_setting_configselect(
            'block_course_count/config_view',
            get_string('config_view', 'block_course_count'),
            get_string('config_view_desc', 'block_course_count'),
            BLOCK_COURSE_COUNT_DEFAULT_VIEW,
            $options
        )
    );
}
