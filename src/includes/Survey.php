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
        add_action('elementor_pro/forms/new_record', [$this, 'process_survey_submit'], 10, 2);

    }

    public function assign_survey_to_user($user_id)
    {
        // your survey assignment logic here
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

    public function process_survey_submit($record, $handler)
    {
        // get the submitted form data
        $raw_fields = $record->get('fields');

        $form_name = $record->get_form_settings('form_name');

        // check if it is the right form
        if ('HAQ' !== $form_name) {
            return;
        }

        // get current user ID
        $user_id = get_current_user_id();

        // update ACF field
        $field_key = "survey_to_complete";
        $value = 0;
        update_field($field_key, $value, 'user_' . $user_id);
    }
}
