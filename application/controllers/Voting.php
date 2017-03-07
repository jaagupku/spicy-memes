<?php

class Voting extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('meme_model');
    }

    public function meme() {
        if ($this->input->method(false) != 'post' || !isset($this->session->logged_in)) {
            show_404();
        }

        $meme_id = $this->input->post('meme_id');
        $upvote = $this->input->post('upvote');

        $this->meme_model->vote_meme($meme_id, $this->session->user_id, $upvote == "true" ? 1 : -1);

        echo('voted');
    }
}