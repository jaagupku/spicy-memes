<?php

class Upload extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('meme_model');
    }

    private function _display_error($error) {
      $this->load->view('pages/addmeme', array('username' => $this->session->username, 'error' => $error));
    }

    public function index() {
      if (!$this->session->logged_in) {
        redirect('/login', 'refresh');
      }

      $this->form_validation->set_rules('title', 'title', 'required|max_length[255]');
      $this->form_validation->set_rules('link', 'link', 'valid_url');

      if ($this->form_validation->run() === FALSE) {
        $this->_display_error(validation_errors());
        return;
      }

      $this->load->helper('upload_helper');

      $missing_link_or_img = TRUE;
      $youtube = FALSE;

      $link = $this->input->post('link');

      if ($link != '') { // if we have link
        $youtube = $this->_youtube_id_from_url($link); // check if it is youtube link
        if (!$youtube) { // if not, try to upload it to cloudinary.
          try {
            $data = upload_link($this, $this->input->post('link'));
          } catch (Exception $e) {
            $this->_display_error(lang('addmeme_upload_checklink'));
            return;
          }
        }
        $missing_link_or_img = FALSE;
      }

      if ($missing_link_or_img) {
          $result = false;

          try {
              $result = upload_image($this, 'userfile');
          } catch (Exception $exception) {
              $this->_display_error(lang('addmeme_upload_to_cloud_fail'));
              return;
          }

          if ($result === false) {
              $this->_display_error(lang('addmeme_upload_fail'));
              return;
          }

          $data = $result;
          $missing_link_or_img = false;
      }

      if ($missing_link_or_img) {
        $this->_display_error('Link or image is missing.');
        return;
      }

      if (!$youtube) {
        $database_error = $this->meme_model->add(html_escape($this->input->post('title')), $this->session->user_id, "P" , $data['public_id'].'.'.$data['format'] );
      }
      else {
        $database_error = $this->meme_model->add(html_escape($this->input->post('title')), $this->session->user_id, "V" , $youtube );
      }

      if($database_error) {
        redirect('/new', 'refresh');
      }
    }

    //http://stackoverflow.com/questions/6556559/youtube-api-extract-video-id
    private function _youtube_id_from_url($url) {
      $pattern =
        '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x'
        ;
      $result = preg_match($pattern, $url, $matches);
      if ($result) {
        return $matches[1];
      }
    return false;
  }
}
