<?php
/**
 * Block for displaying the count of active courses.
 *
 * @package    block_course_count
 * @author     John Illsley
 */

defined('MOODLE_INTERNAL') || die();

define('BLOCK_COURSE_COUNT_DEFAULT_VIEW', 'date');

/**
 * Displays course count.
 */
class block_course_count extends block_base {

    public function init() {
        $this->title = get_string('pluginname', 'block_course_count');
    }

    public function instance_allow_multiple() {
        return true;
    }

    public function has_config() {
        return true;
    }

    public function instance_allow_config() {
        return true;
    }

    public function can_uninstall_plugin() {
        return true;
    }
    
    public function applicable_formats() {
        return array(
            'admin' => false,
            'site-index' => true,
            'course-view' => true,
            'mod' => false,
            'my' => true
        );
    }

    public function get_content() {

        if ($this->content !== null) {
            return $this->content;
        }

        if (empty($this->config)) {
            $this->config = new stdClass();
        }

        if (empty($this->config->view)) {
            // Use admin setting.
            $blockconfig = get_config('block_course_count');

            $this->config->view = (!empty($blockconfig->config_view))
                ? $blockconfig->config_view
                : BLOCK_COURSE_COUNT_DEFAULT_VIEW;
        }

        // Create empty content.
        $this->content = new stdClass();

        switch ($this->config->view) {
            case 'date':
                $date = userdate(time());
                $this->content->text = get_string('todays_date', 'block_course_count', $date);
                break;
            case 'course_count':
                $coursecount = $this->get_course_count();
                $this->content->text = get_string('active_courses', 'block_course_count', $coursecount);
                break;
        }
        return $this->content;
    }

    private function get_course_count(): int {
        global $DB;

        // Just active courses.
        $count = $DB->count_records_sql("
            SELECT COUNT(c.id)
            FROM {course} c 
            WHERE c.visible = 1
            AND (c.startdate = 0 OR c.startdate < :starttime)
            AND (c.enddate = 0 OR c.enddate > :endtime)
            AND c.format != 'site' -- don't count home page.            
            ", array(
                'starttime' => time(),
                'endtime'   => time()
            )
        );
        return $count;
    }
}
