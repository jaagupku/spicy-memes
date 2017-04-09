<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/user_guide/general/hooks.html
|
*/

$hook['post_controller_constructor'] = function () {
    $instance = &get_instance();

    // Switch language if needed
    $language = $instance->input->get('language');

    if (in_array($language, array('english', 'estonian'))) {
        if ($instance->session->logged_in) {
            $instance->user_model->update($instance->session->user_id, array('Language' => $language));
        }

        $instance->session->language = $language;
    }

    // Load language files
    $instance->lang->load('main', $instance->session->language ? $instance->session->language : 'english');
};