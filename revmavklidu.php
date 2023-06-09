<?php
/*
 * Plugin Name: Revma v klidu
 * Description: Plugin pre revmu v klidu
 * Version: 1.0
 * Author: Martin Starosta
 */
require_once plugin_dir_path(__FILE__) . 'src/RevmaPlugin.php';
require_once plugin_dir_path(__FILE__) . 'src/includes/Survey.php';

use Revma\RevmaPlugin;

if (!defined('ABSPATH')) {
    exit;
}

function custom_survey_plugin()
{
    return new RevmaPlugin();
}

// Initialize the plugin
if (function_exists('add_action')) {
    add_action('plugins_loaded', 'custom_survey_plugin');
}
