<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
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
                $this->_login_and_redirect($username);
            } else {
                $error = 'Invalid username or password';
            }
        } else {
            $error = validation_errors();
        }

        $this->load->view('pages/login', array('error' => $error));
    }

    public function logout() {
        $uri = $this->session->referenced_form;
        if ($this->session->logged_in) {
            session_destroy();
        }

        redirect($uri, 'refresh');
    }

    public function register() {
        if ($this->session->logged_in) {
            redirect('/', 'refresh');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Username', 'required|max_length[32]|alpha_numeric|is_unique[users.User_Name]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[7]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.Email]');

        $error = null;

        if ($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $email = $this->input->post('email');

            if ($this->user_model->create($username, $password, $email)) {
                $this->_login_and_redirect($username);
            } else {
                $error = 'Couldn\'t create the user';
            }
        } else {
            $error = validation_errors();
        }

        $this->load->view('pages/register', array('error' => $error));
    }

    public function profile($username) {
        $userdata = $this->user_model->retrieve($username);
        $data = $this->user_model->get_user_meme_data($userdata->Id);
        $processed_data = array('picture' => 0, 'video' => 0, 'total' => 0);
        foreach ($data as $value) {
          if ($value->Data_Type == "P") {
            $processed_data['picture'] = $value->count;
          } else {
            $processed_data['video'] = $value->count;
          }
        }

        $processed_data['total'] = $processed_data['picture'] + $processed_data['video'];

        if ($userdata) {
            $username = $userdata->User_Name;
            $email = $userdata->Email;
            $profile_image = $userdata->ProfileImg_Id;

            $this->session->referenced_form = site_url("/profile/$username");
            $this->load->view('pages/profile', array('username' => $this->session->username, 'target' => $username, 'email' => $email, 'meme_count' => $processed_data, 'profile_image' => $profile_image));
        } else {
            show_404();
        }
    }

    private function _login_and_redirect($username) {
        $user = $this->user_model->retrieve($username);
        $this->user_model->update_last_login_date($user->Id);
        $this->session->logged_in = true;
        $this->session->username = $user->User_Name;
        $this->session->user_id = $user->Id;
        redirect($this->session->referenced_form, 'refresh');
    }
}
