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
        $this->session->referenced_form = site_url("hot/$from/$amount");
        $this->_display_memes($this->meme_model->get_hot_memes($from, $amount+1), "Hot", 'hot', $from, $amount);
    }

    public function top($from = 0, $amount = 20) {
        $this->session->referenced_form = site_url("top/$from/$amount");
        $this->_display_memes($this->meme_model->get_top_memes($from, $amount+1), "Top", 'top', $from, $amount);
    }

    public function new_memes($from = 0, $amount = 20) {
        $this->session->referenced_form = site_url("new/$from/$amount");
        $this->_display_memes($this->meme_model->get_new_memes($from, $amount+1), "New", 'new', $from, $amount);
    }

    private function _display_memes($memes, $title, $selection, $from, $amount) {
        $meme_dictionary = array();
        $data = array();

        if (count($memes) > $amount) {
          $data['nextpage'] = $selection."/".($from + $amount)."/".$amount;
        } else {
          $data['nextpage'] = FALSE;
        }

        array_pop($memes);

        foreach ($memes as &$meme) {
            $meme['User_Vote'] = 0;
            $meme_dictionary[$meme['Id']] = &$meme;
        }

        foreach ($this->meme_model->get_meme_votes(array_keys($meme_dictionary), $this->session->user_id) as $vote) {
            $meme_dictionary[$vote->Meme_Id]['User_Vote'] = $vote->Up_Vote;
        }


        $data['username'] = $this->session->username;
        $data['title'] = $title;
        $data['selection'] = $selection;
        $data['memes'] = $memes;

        $this->load->view('pages/memebody.php', $data);
    }
}
