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
      $data['memes'] = $memes;
      $this->load->view('pages/header', array('username' => $this->session->username, 'title' => $title, 'selection' => $selection));
      $this->load->view('pages/memebody.php', $data);
      $this->load->view('pages/footer.php');
    }
}
