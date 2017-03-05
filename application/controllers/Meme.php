<?php

class Meme extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('cloudinarylib');
        $this->load->library('form_validation');
        $this->load->model('meme_model');
    }

    public function add() {

      if (!isset($this->session->logged_in)) {
        redirect('/login', 'refresh');
      }

      $this->load->view('pages/header', array('username' => $this->session->username, 'title' => 'Add spice', 'selection' => 'addspice'));
      $this->load->view('pages/addmeme');
      $this->load->view('pages/footer');
    }

    public function view($meme_id) {
      $data['meme'] = $this->meme_model->get_meme($meme_id);
      if (empty($data['meme'])) {
        show_404();
      }

      $data['comment_added'] = FALSE;

      $this->form_validation->set_rules('message', 'Message', 'required');
      if ($this->form_validation->run()) {
        if($this->meme_model->add_comment($meme_id, $this->session->user_id, html_escape($this->input->post('message')))) {
          $data['comment_added'] = TRUE;
        }
      }

      $data['comments'] = $this->meme_model->get_meme_comments($meme_id, 'Points');

      foreach ($data['comments'] as $key => $comment) {
        $data['comments'][$key]['ProfileImg_Id']=$this->cloudinarylib->get_html_data("P", $comment['ProfileImg_Id'], 48);
      }
      $data['meme']['Data']=$this->cloudinarylib->get_html_data($data['meme']['Data_Type'], $data['meme']['Data']);

      $this->load->view('pages/header', array('username' => $this->session->username, 'title' => $data['meme']['Title'], 'selection' => null));
      $this->load->view('pages/commentsbody', $data);
      $this->load->view('pages/footer');
    }
}
