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

    public function hot($from = 0, $amount = 3) {
        if ($this->input->method(false) != 'post') {
          $this->_display_memes($this->meme_model->get_hot_memes($from, $amount+1), "Hot", 'hot', $from, $amount);
        } else {
          $ajax_from = $this->input->post('from');
          $ajax_amount = $this->input->post('amount');
          $this->_display_ajax_memes( $this->meme_model->get_hot_memes($ajax_from, $ajax_amount), 'hot', $ajax_from, $ajax_amount);
        }

    }

    public function top($from = 0, $amount = 3) {
      if ($this->input->method(false) != 'post') {
        $this->_display_memes($this->meme_model->get_top_memes($from, $amount+1), "Top", 'top', $from, $amount);
      } else {
        $ajax_from = $this->input->post('from');
        $ajax_amount = $this->input->post('amount');
        $this->_display_ajax_memes( $this->meme_model->get_top_memes($ajax_from, $ajax_amount), 'top', $ajax_from, $ajax_amount);
      }
    }

    public function new_memes($from = 0, $amount = 3) {
      if ($this->input->method(false) != 'post') {
        $this->_display_memes($this->meme_model->get_new_memes($from, $amount+1), "New", 'new', $from, $amount);
      } else {
        $ajax_from = $this->input->post('from');
        $ajax_amount = $this->input->post('amount');
        $this->_display_ajax_memes( $this->meme_model->get_new_memes($ajax_from, $ajax_amount), 'new', $ajax_from, $ajax_amount);
      }
    }

    private function _display_ajax_memes($memes, $selection, $from, $amount) {
      $this->session->referenced_form = site_url("$selection/$from/$amount");

      $data = array();

      $data['memes'] = $this->_add_votes_to_memes($memes);

      $this->load->view("pages/memecontainer", $data);
    }

    private function _display_memes($memes, $title, $selection, $from, $amount) {
        $this->session->referenced_form = site_url("$selection/$from/$amount");
        $data = array();

        if (count($memes) > $amount) {
          $data['nextpage'] = $selection."/".($from + $amount)."/".$amount;
          $data['from'] = $from + $amount;
          $data['amount'] = $amount;
          array_pop($memes);
        } else {
          $data['nextpage'] = FALSE;
        }


        $data['username'] = $this->session->username;
        $data['title'] = $title;
        $data['selection'] = $selection;
        $data['memes'] = $this->_add_votes_to_memes($memes);

        $this->load->view('pages/memebody.php', $data);
    }

    private function _add_votes_to_memes($memes) {
      $meme_dictionary = array();
      foreach ($memes as &$meme) {
          $meme['User_Vote'] = 0;
          $meme_dictionary[$meme['Id']] = &$meme;
      }

      foreach ($this->meme_model->get_meme_votes(array_keys($meme_dictionary), $this->session->user_id) as $vote) {
          $meme_dictionary[$vote->Meme_Id]['User_Vote'] = $vote->Up_Vote;
      }
      return $memes;
    }
}
