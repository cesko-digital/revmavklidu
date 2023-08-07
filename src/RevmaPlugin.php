<?php
namespace Revma;

use Revma\Survey;

class RevmaPlugin
{
    private $_survey;

    public function __construct()
    {
        add_action('init', [$this, 'init']);
        add_action('wp_enqueue_scripts', [$this, 'add_custom_assets']);
    }

    public function init()
    {
        $current_user = wp_get_current_user();
        $this->_survey = new Survey($current_user);
        $this->_survey->init();
    }

    public function add_custom_assets()
    {
        wp_enqueue_style(
            'revma-custom-css',
            plugins_url('/css/revma.css', __FILE__),
            array(),
            filemtime(plugin_dir_path(__FILE__) . 'css/revma.css')
        );
        wp_enqueue_script(
            'revma-custom-js',
            plugins_url('/js/revma.js', __FILE__),
            array('jquery'),
            filemtime(plugin_dir_path(__FILE__) . 'js/revma.js'),
            true
        );
        if (is_singular('dotaznik')) {
            wp_enqueue_script(
                'survey-custom-js',
                plugins_url('/js/survey.js', __FILE__),
                array('jquery'),
                filemtime(plugin_dir_path(__FILE__) . 'js/survey.js'),
                true
            );
        }

    }
}
