<?php

class Main extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
    }

    public function index() {
        $this->load->view('pages/header', array('username' => $this->session->username));
        $this->load->view('pages/footer.php');
    }

    public function view($page = 'header') {
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            // Whoops, we don't have a page for that!
            show_404();
        }

        $this->load->view('pages/' . $page);
    }
}

?>
