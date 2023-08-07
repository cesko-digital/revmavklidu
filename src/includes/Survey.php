<?php

namespace Revma;

class Survey
{
    private $_user;

    const SURVEY_POST_ID = 182;
    const SURVEY_TO_COMPLETE_META_KEY = 'survey_to_complete';

    public function __construct($user)
    {
        $this->_user = $user;
    }

    public function init()
    {
        add_action('template_redirect', [$this, 'redirect_user_if_survey_not_completed']);
        add_action('user_register', [$this, 'assign_survey_to_user']);
        add_filter('lifterlms_user_can_access', [$this, 'check_user_survey_completion'], 10, 3);
        add_action('your_survey_tool_form_submission_hook', [$this, 'mark_survey_as_completed'], 10, 2);
    }

    public function assign_survey_to_user($user_id)
    {
        // your survey assignment logic here
    }

    public function mark_survey_as_completed($entry, $form)
    {
        // Check that it's the correct form
        if ($form['id'] == 'your_form_id') {
            // Mark the survey as completed
            update_user_meta($this->_user->ID, self::SURVEY_TO_COMPLETE_META_KEY, self::SURVEY_POST_ID);
        }
    }

    public function redirect_user_if_survey_not_completed()
    {
        if (!is_user_logged_in()) {
            return;
        }

        if (in_array('administrator', (array) $this->_user->roles)) {
            return;
        }

        $survey_to_complete = get_user_meta($this->_user->ID, self::SURVEY_TO_COMPLETE_META_KEY, true);

        if (!$survey_to_complete || $survey_to_complete === '' || $survey_to_complete === '0') {
            return;
        }

        if (is_page($survey_to_complete)) {
            return;
        }

        $survey_url = get_permalink($survey_to_complete);
        wp_safe_redirect($survey_url);
        exit;
    }

}
