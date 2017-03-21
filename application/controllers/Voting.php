<?php

class Voting extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('meme_model');
        $this->load->model('comment_model');
    }

    public function meme() {
        $this->_vote('meme_model');
    }

    public function comment() {
        $this->_vote('comment_model');
    }

    private function _vote($model) {
        if ($this->input->method(false) != 'post' || !isset($this->session->logged_in)) {
            show_404();
        }

        $id = $this->input->post('id');
        $vote = $this->input->post('vote');

        if (!isset($id) || !isset($vote)) {
            show_404();
        }

        $this->$model->delete_vote($id, $this->session->user_id);

        if ($vote == 1 || $vote == -1) {
            $this->$model->vote($id, $this->session->user_id, intval($vote));
        }

        echo('voted');
    }
}
