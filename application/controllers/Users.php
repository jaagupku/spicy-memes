<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . '/../third_party/Facebook/autoload.php';
require_once __DIR__ . '/../config/facebook.php';

class Users extends CI_Controller {
    public function __construct() {
        parent::__construct();
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

        $fberror = $this->session->flashdata('login_error');
        if (isset($fberror)) {
          $error = $fberror;
        }

        $this->load->view('pages/login', array('error' => $error));
    }

    public function login_fb_callback() {
      # /js-login.php
      $fb = new Facebook\Facebook([
        'app_id' => FB_API_KEY,
        'app_secret' => FB_API_SECRET,
        'default_graph_version' => API_VERSION,
      ]);

      $helper = $fb->getJavaScriptHelper();

      try {
        $accessToken = $helper->getAccessToken();

        if (! isset($accessToken)) {
          echo 'No cookie set or no OAuth data could be obtained from cookie.';
          exit;
        }
        // OAuth 2.0 client handler
        $oAuth2Client = $fb->getOAuth2Client();

        $tokenMetadata = $oAuth2Client->debugToken($accessToken);
        $tokenMetadata->validateAppId(FB_API_KEY);
        $tokenMetadata->validateExpiration();

        // Exchanges a short-lived access token for a long-lived one
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
        $fb->setDefaultAccessToken($accessToken);

        $response = $fb->get('/me?fields=id,email,name');
        $userNode = $response->getGraphUser();
      } catch(Facebook\Exceptions\FacebookResponseException $e) {
        // When Graph returns an error
        echo 'Graph returned an error: ' . $e->getMessage();
        exit;
      } catch(Facebook\Exceptions\FacebookSDKException $e) {
        // When validation fails or other local issues
        echo 'Facebook SDK returned an error: ' . $e->getMessage();
        exit;
      }

      if (! isset($accessToken)) {
        if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . "\n";
        echo "Error Code: " . $helper->getErrorCode() . "\n";
        echo "Error Reason: " . $helper->getErrorReason() . "\n";
        echo "Error Description: " . $helper->getErrorDescription() . "\n";
        } else {
          header('HTTP/1.0 400 Bad Request');
          echo 'Bad request';
        }
        exit;
      }

      $this->session->fb_access_token = (string) $accessToken;

      $userData = $this->user_model->retrieve_fb($userNode->getId());

      if (isset($this->session->logged_in) && $this->session->logged_in) {
        if (is_null($userData)) {
          $this->user_model->link_fb($this->session->user_id, $userNode->getId()); // Link account with facebook
          $this->session->fb_linked = true;
          redirect($this->session->referenced_form, "refresh");
        } else {
          redirect($this->session->referenced_form, "refresh"); // User is logged in, and has linked fb account with other account
        }
      } else {
        if (is_null($userData)) {
          $this->session->set_flashdata('login_error', "Facebook accont is not linked to any Spicy Memes account.");
          redirect(site_url("login")); // user is not logged in, facebook acc is unlinked
        } else {
          $this->_login_and_redirect_data($userData); // Log in with facebook
        }
      }
    }

    public function facebook_deauthorize() {
      $this->load->library('form_validation');
      $this->form_validation->set_rules('signed_request', 'signed_request', 'required');

      if ($this->form_validation->run()) {
        $data = _parse_signed_request($this->input->post('signed_request'));
        $this->user_model->unlink_fb_by_fbid($data->user_id);
      } else {
        show_404();
      }
    }

    private function _parse_signed_request($signed_request) {
      list($encoded_sig, $payload) = explode('.', $signed_request, 2);

      $secret = FB_API_SECRET; // Use your app secret here

      // decode the data
      $sig = _base64_url_decode($encoded_sig);
      $data = json_decode(_base64_url_decode($payload), true);

      // confirm the signature
      $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
      if ($sig !== $expected_sig) {
        error_log('Bad Signed JSON signature!');
        return null;
      }

      return $data;
    }

    private function _base64_url_decode($input) {
      return base64_decode(strtr($input, '-_', '+/'));
    }

    public function unlink_fb() {
      if (!isset($this->session->logged_in)) {
          redirect('/login', 'refresh');
      }

      $this->user_model->unlink_fb($this->session->user_id);
      $this->session->fb_linked = false;
      redirect($this->session->referenced_form, 'refresh');
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
      $this->_login_and_redirect_data($this->user_model->retrieve($username));
    }

    private function _login_and_redirect_data($user) {
        $this->user_model->update_last_login_date($user->Id);
        $this->session->logged_in = true;
        $this->session->username = $user->User_Name;
        $this->session->user_id = $user->Id;
        $this->session->fb_linked = isset($user->FB_Id);
        redirect($this->session->referenced_form, 'refresh');
    }
}
