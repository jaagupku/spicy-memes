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
        if ($this->session->logged_in === true) {
            redirect('/', 'refresh');
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() === false) {
            $this->load->view('pages/header.php');
            $this->load->view('pages/login.php');
            $this->load->view('pages/footer.php');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if ($this->user_model->verify($username, $password)) {
                $this->session->logged_in = true;
                $this->session->username = $username;

                redirect('/', 'refresh');
            } else {
                $this->load->view('pages/header.php');
                $this->load->view('pages/login.php');
                $this->output->append_output('Invalid username or password');
                $this->load->view('pages/footer.php');
            }
        }
    }

    public function logout() {
        if ($this->session->logged_in === true) {
            session_destroy();
        }

        redirect('/', 'refresh');
    }

    public function register() {
        if ($this->session->logged_in === true) {
            redirect('/', 'refresh');
        }

        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric|is_unique[users.User_Name]');
        $this->form_validation->set_rules('password', 'Password', 'required');
        $this->form_validation->set_rules('email', 'E-mail', 'required|valid_email|is_unique[users.Email]');

        if ($this->form_validation->run() === false) {
            $this->load->view('pages/header.php');
            $this->load->view('pages/register.php');
            $this->load->view('pages/footer.php');
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $email = $this->input->post('email');

            if ($this->user_model->create($username, $password, $email)) {
                $this->output->append_output('Username: ' . $username . '; password: ' . $password . '; e-mail: ' . $email);
            } else {
                $this->load->view('pages/header.php');
                $this->load->view('pages/register.php');
                $this->output->append_output('Couldn\'t create the user');
                $this->load->view('pages/footer.php');
            }
        }
    }

    public function profile($username) {
        $userdata = $this->user_model->retrieve($username);

        if ($userdata) {
            $this->load->view('pages/header.php', array('username' => $this->session->username));
            $this->load->view('pages/profile.php', array('username' => $userdata->User_Name, 'email' => $userdata->Email));
            $this->load->view('pages/footer.php');
        } else {
            show_404();
        }
    }
}
