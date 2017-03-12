<?php

class Main extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('meme_model');
    }

    public function index() {
        $this->hot();
    }

    public function hot($from = 0, $amount = 3) {
      $this->_display_memes($this->meme_model->get_hot_memes($from, $amount+1), "Hot", 'hot', $from, $amount);
    }

    public function top($from = 0, $amount = 3) {
      $this->_display_memes($this->meme_model->get_top_memes($from, $amount+1), "Top", 'top', $from, $amount);
    }

    public function new_memes($from = 0, $amount = 3) {
      $this->_display_memes($this->meme_model->get_new_memes($from, $amount+1), "New", 'new', $from, $amount);
    }

    public function ajax() {
      $type = $_REQUEST["type"];
		  $from = $_REQUEST["from"];
      $amount = $_REQUEST["amount"];

      if ($type === "new") {
        $this->_display_ajax_memes( $this->meme_model->get_new_memes($from, $amount), 'new', $from, $amount);
      } else if ($type === "top") {
        $this->_display_ajax_memes( $this->meme_model->get_top_memes($from, $amount), 'top', $from, $amount);
      } else if ($type === "hot") {
        $this->_display_ajax_memes( $this->meme_model->get_hot_memes($from, $amount), 'hot', $from, $amount);
      }
    }

    private function _display_ajax_memes($memes, $selection, $from, $amount) {
      $data = array();

      $data['memes'] = $this->_add_votes_to_memes($memes);

      $this->load->view("pages/meme_xml", $data);
      $this->session->referenced_form = site_url("$selection/$from/$amount");
    }

    private function _display_memes($memes, $title, $selection, $from, $amount) {
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
        $this->session->referenced_form = site_url("$selection/$from/$amount");
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
