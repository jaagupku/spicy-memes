<?php

class Meme extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->model('meme_model');
    }

    public function add() {
        $this->session->referenced_form = site_url("/meme/add");

        if (!isset($this->session->logged_in)) {
            redirect('/login', 'refresh');
        }

        $this->load->view('pages/addmeme', array('username' => $this->session->username));
    }

    public function view($meme_id) {
        $data['meme'] = $this->meme_model->get_meme($meme_id);
        if (empty($data['meme'])) {
            show_404();
        }

        $data['comment_added'] = FALSE;

        $this->form_validation->set_rules('message', 'Message', 'required');
        if ($this->form_validation->run() && $this->session->logged_in) {
            if ($this->meme_model->add_comment($meme_id, $this->session->user_id, html_escape($this->input->post('message')))) {
                $data['comment_added'] = TRUE;
            }
        }

        $data['username'] = $this->session->username;
        $data['comments'] = $this->meme_model->get_meme_comments($meme_id, 'Points');

        $this->session->referenced_form = site_url("/meme/$meme_id");
        $this->load->view('pages/commentsbody', $data);
    }
}
