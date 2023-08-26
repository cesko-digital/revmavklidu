<?php

namespace Revma;

class Registration
{
    public function init()
    {
        add_action('wp_login', array($this, 'check_user_personal_data'), 10, 2);
    }

    public function check_user_personal_data()
    {
        $current_user = wp_get_current_user();
        $roles = (array) $current_user->roles;

        // Check if the user has the 'student' role
        if (in_array('student', $roles)) {
            $personal = get_field('osobne_informacie', 'user_' . $current_user->ID, true);

            // We are missing user data, so ask him to finish registration
            if (empty($personal['rok_narodenia'])) {
                wp_redirect(get_permalink(788));
                exit;
            }
        }
    }
}
