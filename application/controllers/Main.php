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

    public function hot($from = 0, $amount = 20) {
        $this->_display_memes($this->meme_model->get_hot_memes($from, $amount), "Hot", 'hot');
    }

    public function top($from = 0, $amount = 20) {
        $this->_display_memes($this->meme_model->get_top_memes($from, $amount), "Top", 'top');
    }

    public function new_memes($from = 0, $amount = 20) {
        $this->_display_memes($this->meme_model->get_new_memes($from, $amount), "New", 'new');
    }

    private function _display_memes($memes, $title, $selection) {
        $meme_dictionary = array();

        foreach ($memes as &$meme) {
            $meme['User_Vote'] = 0;
            $meme_dictionary[$meme['Id']] = &$meme;
        }

        foreach ($this->meme_model->get_meme_votes(array_keys($meme_dictionary)) as $vote) {
            if ($this->session->user_id == $vote->User_Id) {
                $meme_dictionary[$vote->Meme_Id]['User_Vote'] = $vote->Up_Vote;
            }
        }

        $data = array();
        $data['username'] = $this->session->username;
        $data['title'] = $title;
        $data['selection'] = $selection;
        $data['memes'] = $memes;

        $this->load->view('pages/header', $data);
        $this->load->view('pages/memebody.php', $data);
        $this->load->view('pages/footer.php');
    }
}
