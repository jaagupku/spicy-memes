<?php

class Upload extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
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

      $config['upload_path'] = './temp/';
      $config['allowed_types'] = 'gif|jpg|png';
      $config['max_size'] = '4096';

      $this->load->library('upload', $config);

      $missing_link_or_img = TRUE;
      $youtube = FALSE;

      require APPPATH .'third_party/cloudinary/Cloudinary.php';
      require APPPATH .'third_party/cloudinary/Uploader.php';
      require APPPATH .'third_party/cloudinary/Api.php';
      if (file_exists('application/config/cloudinary.php')) {
        include 'application/config/cloudinary.php';
      }

      $link = $this->input->post('link');

      if ($link != '') { // if we have link
        $youtube = $this->_youtube_id_from_url($link); // check if it is youtube link
        if (!$youtube) { // if not, try to upload it to cloudinary.
          try {
            $data = \Cloudinary\Uploader::upload($this->input->post('link'));
          } catch (Exception $e) {
            $this->_display_error('Check your link. It is not valid.');
            return;
          }
        }
        $missing_link_or_img = FALSE;
      }

      if($missing_link_or_img){
        if (!$this->upload->do_upload('userfile')) {
          $this->_display_error('Something went wrong with upload');
          return;
        }
        else {
          $temp = array('upload_data' => $this->upload->data());
          try {
            $data = \Cloudinary\Uploader::upload($temp['upload_data']['full_path']);
            $missing_link_or_img = FALSE;
          } catch (Exception $e) {
            $this->_display_error('Something went wrong with uploading to cloud.');
            return;
          }
          unlink($temp['upload_data']['full_path']);
        }
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
