<?php

class Search extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('meme_model');
    }

    public function index()
    {
        if ($this->input->method(false) !== 'get') {
            show_404();
        }

        $search = $this->input->get('value');
        $sort_by = $this->input->get('sort');

        $order = array(
            'top' => 'Points',
            'comments' => 'comments',
            'date' => 'Date'
        );

        $data = array(
            'username' => $this->session->username
        );

        if (!isset($sort_by) || !in_array($sort_by, array_keys($order))) {
            $sort_by = 'top';
        }

        if (isset($search) && ($search = trim($search)) !== '') {
            $data['memes'] = $this->meme_model->find_like($search, $order[$sort_by]);
        } else {
            $data['error'] = 'Invalid search text';
        }

        $this->load->view('search', $data);
    }
}
