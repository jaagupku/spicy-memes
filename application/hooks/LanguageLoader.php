<?php
class LanguageLoader {
	function initialize() {

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
    $instance->config->set_item('language', 'estonian');
    $instance->lang->load('main', $instance->session->language ? $instance->session->language : 'english');
  }
}
