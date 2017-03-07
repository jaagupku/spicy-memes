<?php

class Main extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('meme_model');
    }

    public function index() {
      redirect('/hot');
    }

    public function hot($from=0, $amount=20) {
      $this->_display_memes($this->meme_model->get_hot_memes($from, $amount), "Hot", 'hot');
    }

    public function top($from=0, $amount=20) {
      $this->_display_memes($this->meme_model->get_top_memes($from, $amount), "Top", 'top');
    }

    public function new_memes($from=0, $amount=20) {
      $this->_display_memes($this->meme_model->get_new_memes($from, $amount), "New", 'new');
    }

    private function _display_memes($memes, $title, $selection) {
      $data = array();

      $data['memes'] = array();
      foreach ($memes as &$meme) {
          $meme_array = (array) $meme;
          $meme_array['User_Vote'] = $this->meme_model->get_vote_meme($meme_array['Id'], $this->session->user_id);

          array_push($data['memes'], $meme_array);
      }

      $this->load->view('pages/header', array('username' => $this->session->username, 'title' => $title, 'selection' => $selection));
      $this->load->view('pages/memebody.php', $data);
      $this->load->view('pages/footer.php');
    }
}
