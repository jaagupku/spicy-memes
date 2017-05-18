<?php

class Meme extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('meme_model');
        $this->load->model('comment_model');
    }

    public function add() {
        $this->session->referenced_form = site_url("/meme/add");

        if (!isset($this->session->logged_in)) {
            redirect('/login', 'refresh');
        }

        $this->load->view('pages/addmeme', array('username' => $this->session->username));
    }

    public function view($meme_id) {
        $data['meme'] = $this->meme_model->get($meme_id);
        if (empty($data['meme'])) {
            show_404();
        }

        $data['comment_added'] = FALSE;

        $this->form_validation->set_rules('message', lang('comment'), 'required|max_length[2048]');
        if ($this->form_validation->run() && $this->session->logged_in) {
            if ($this->comment_model->add($meme_id, $this->session->user_id, html_escape($this->input->post('message')))) {
                $data['comment_added'] = TRUE;
            }
        }

        $order = array(
            'top' => 'Points',
            'date' => 'Date'
        );

        $sort = $this->input->get('sort');

        if (!isset($sort) || !in_array($sort, array_keys($order))) {
            $sort = 'top';
        }

        $data['username'] = $this->session->username;
        $data['comments'] = $this->_add_votes_to_comments($this->meme_model->get_comments($meme_id, $order[$sort]));

        $this->session->referenced_form = site_url("/meme/$meme_id");
        $this->load->view('pages/commentsbody', $data);
    }

    public function delete_comment() {
      $commentid = $_REQUEST['id'];
      if (!(isset($commentid) && isset($this->session->logged_in) && $this->session->logged_in)) {
        show_404();
        exit;
      }

      $comment = $this->comment_model->retrieve($commentid);
      if ($comment['User_Id'] == $this->session->user_id || $this->session->user_type > 0) {
        $this->comment_model->delete($commentid);
      }

      redirect($this->session->referenced_form);
    }

    private function _add_votes_to_comments($comments) {
        if ($this->session->logged_in && count($comments) > 0) {
            $id_to_comment = array();

            foreach ($comments as &$comment) {
                $id_to_comment[$comment['Id']] = &$comment;
            }

            foreach ($this->comment_model->get_votes(array_keys($id_to_comment), $this->session->user_id) as $vote) {
                $id_to_comment[$vote->Comment_Id]['User_Vote'] = $vote->Up_Vote;
            }
        }

        return $comments;
    }
}
