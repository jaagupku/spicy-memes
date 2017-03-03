<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->model('user');
    }

    public function login() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('pages/header.php');
            $this->load->view('pages/login.php');
            $this->load->view('pages/footer.php');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $this->output->append_output('Username: ' . $username . '; password: ' . $password);
        }
    }

    public function logout() {
        $this->load->view('pages/header.php');
    }

    public function register() {
        $this->load->view('pages/header.php');
    }

    public function profile($username) {
        $this->output->append_output($username);
    }
}