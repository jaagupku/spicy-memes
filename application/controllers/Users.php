<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper(array('form', 'url'));
        $this->load->model('user_model');
    }

    public function login() {
        if ($this->session->logged_in) {
            redirect('/', 'refresh');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'required');

        $error = null;

        if ($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if ($this->user_model->verify($username, $password)) {
                $this->_login_and_redirect($username, '/');
            } else {
                $error = 'Invalid username or password';
            }
        } else {
            $error = validation_errors();
        }

        $this->load->view('pages/header.php', array('title' => 'Log in'));
        $this->load->view('pages/login.php', array('error' => $error));
        $this->load->view('pages/footer.php');
    }

    public function logout() {
        if ($this->session->logged_in) {
            session_destroy();
        }

        redirect('/', 'refresh');
    }

    public function register() {
        if ($this->session->logged_in) {
            redirect('/', 'refresh');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|is_unique[users.User_Name]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|is_unique[users.Email]');

        $error = null;

        if ($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $email = $this->input->post('email');

            if ($this->user_model->create($username, $password, $email)) {
                $this->_login_and_redirect($username, '/');
            } else {
                $error = 'Couldn\'t create the user';
            }
        } else {
            $error = validation_errors();
        }

        $this->load->view('pages/header.php', array('title' => 'Register'));
        $this->load->view('pages/register.php', array('error' => $error));
        $this->load->view('pages/footer.php');
    }

    public function profile($username) {
        $userdata = $this->user_model->retrieve($username);

        if ($userdata) {
            $this->load->view('pages/header.php', array('username' => $this->session->username, 'title' => $userdata->User_Name));
            $this->load->view('pages/profile.php', array('username' => $userdata->User_Name, 'email' => $userdata->Email));
            $this->load->view('pages/footer.php');
        } else {
            show_404();
        }
    }

    private function _login_and_redirect($username, $uri) {
        $user = $this->user_model->retrieve($username);
        $this->session->logged_in = true;
        $this->session->username = $user->User_Name;
        $this->session->user_id = $user->Id;
        redirect($uri, 'refresh');
    }
}
