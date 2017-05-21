<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once __DIR__ . '/../third_party/Facebook/autoload.php';
require_once __DIR__ . '/../config/facebook.php';

class Users extends CI_Controller {
    public function login() {
        if ($this->session->logged_in) {
            redirect('/', 'refresh');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', lang('validation_username'), 'required|alpha_numeric|max_length[32]');
        $this->form_validation->set_rules('password', lang('validation_password'), 'required|max_length[1024]');

        $error = null;

        if ($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            if ($this->user_model->verify($username, $password)) {
                $this->_login_and_redirect($username);
            } else {
                $error = lang('login_error');
            }
        } else {
            $error = validation_errors();
        }

        $this->load->view('login', array('error' => $error));
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
          $this->_link_user_facebook($this->session->user_id, $userNode->getId()); // User is logged in, Link account with facebook
          redirect($this->session->referenced_form, "refresh");
        } else {
          redirect($this->session->referenced_form, "refresh"); // User is logged in, and has linked fb account with other account, do nothing
        }
      } else {
        if (is_null($userData)) {
          $userData = $this->user_model->retrieve_email($userNode->getField('email'));
          if (is_null($userData)) {
            $this->session->set_flashdata('login_error', lang('unlinked_facebook'));
            $this->session->set_flashdata('facebook_id', $userNode->getId());
            $this->session->set_flashdata('facebook_email', $userNode->getField('email'));
            redirect(site_url("register")); // user is not logged in, facebook acc is unlinked, facebook email is not used in this site.
          } else {
            $this->_link_user_facebook($userData->Id, $userNode->getId()); // user is not logged in, facebook acc is unlinked,
            $this->_login_and_redirect_data($userData, true); //facebook email is used in this site. link that acc with facebook and login
          }
        } else {
          $this->_login_and_redirect_data($userData); // user is not logged in, facebook is linked, Log in with facebook
        }
      }
    }

    public function facebook_deauthorize() {
      $signed_request = $this->input->post('signed_request');

      if (isset($signed_request)) {
        $data = $this->_parse_signed_request($signed_request);
        $this->user_model->unlink_fb_by_fbid($data['user_id']);
      } else {
        show_404();
      }
    }

    private function _link_user_facebook($userid, $fbid) {
      $this->user_model->link_fb($userid, $fbid);
      $this->session->fb_linked = true;
    }

    private function _parse_signed_request($signed_request) {
      list($encoded_sig, $payload) = explode('.', $signed_request, 2);

      $secret = FB_API_SECRET; // Use your app secret here

      // decode the data
      $sig = $this->_base64_url_decode($encoded_sig);
      $data = json_decode($this->_base64_url_decode($payload), true);

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
        $this->form_validation->set_rules('username', lang('validation_username'), 'required|max_length[32]|alpha_numeric|is_unique[users.User_Name]');
        $this->form_validation->set_rules('password', lang('validation_password'), 'required|min_length[7]');
        $this->form_validation->set_rules('password_rpt', lang('validation_repeatedpassword'), 'matches[password]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.Email]');
        $this->form_validation->set_rules('facebookid', '', 'numeric');

        $error = null;
        $data = array();

        if ($this->form_validation->run()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $email = $this->input->post('email');
            $fbid = $this->input->post('facebookid');

            if ($this->user_model->create($username, $password, $email)) {
                if (isset($fbid)) {
                  $this->_login_and_redirect($username, true, $fbid, true);
                } else {
                  $this->_login_and_redirect($username, false, null, true);
                }
            } else {
                $error = lang('signup_create_user_failed');
            }
        } else {
            $email = $this->input->post('email');
            $fbid = $this->input->post('facebookid');
            $username = $this->input->post('username');
            if (isset($email)) {
              $data['email'] = $email;
            }
            if (isset($fbid)) {
              $data['fbid'] = $fbid;
            }
            if (isset($username)) {
              $data['usernameform'] = $username;
            }
            $error = validation_errors();
        }

        $fberror = $this->session->flashdata('login_error');
        if (isset($fberror)) {
          $error = $fberror;
        }
        $data['error'] = $error;

        $fbid = $this->session->flashdata('facebook_id');
        if (isset($fbid)) {
          $data['fbid'] = $fbid;
        }

        $fbemail = $this->session->flashdata('facebook_email');
        if (isset($fbid)) {
          $data['email'] = $fbemail;
        }

        $this->load->view('register', $data);
    }

    public function profile($username, $order_by='top') {
        $userdata = $this->user_model->retrieve($username);

        $orders = array(
            'top' => 'Points',
            'comments' => 'comments',
            'date' => 'Date'
        );

        if ($userdata && in_array($order_by, array_keys($orders))) {
            $memes = $this->user_model->get_memes($userdata->Id, $orders[$order_by]);
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

            $data = array(
                'username' => $this->session->username,
                'target' => $userdata->User_Name,
                'email' => $userdata->Email,
                'profile_image' => $userdata->ProfileImg_Id,
                'memes' => $memes,
                'meme_count' => $processed_data
            );

            $this->session->referenced_form = site_url("/profile/$username");
            $this->load->view('profile', $data);
        } else {
            show_404();
        }
    }

    public function userMemesJSON() {
      $orders = array(
          'top' => 'Points',
          'comments' => 'comments',
          'date' => 'Date'
      );

      $username = $_REQUEST["username"];
      $order_by = $_REQUEST["order"];
      $userdata = $this->user_model->retrieve($username);

      echo json_encode($this->user_model->get_memes($userdata->Id, $orders[$order_by]));
    }

    public function delete() {
        $username = $this->input->post('username');

        if (strcasecmp($username, $this->session->username) === 0) {
            $this->_detete_user();
        } else {
            $this->_load_edit_profile(lang('editprofile_wrongusername'));
        }
    }

    public function confirm() {
        $this->load->view('confirm', array('username' => $this->session->username));
    }

    public function edit_profile() {
        if (!isset($this->session->logged_in)) {
            show_404();
        }

        $error = null;

        $username_changed = !$this->_exists_and_equals($this->input->post('username'), $this->session->username);
        $email_changed = !$this->_exists_and_equals($this->input->post('email'), $this->session->email);
        $language_changed = !$this->_exists_and_equals($this->input->post('language'), $this->session->language);
        $uploading_image = !empty($_FILES['userfile']) && file_exists($_FILES['userfile']['tmp_name']);
        $password_changed = $this->input->post('new_password') !== '' || $this->input->post('repeat_new_password') !== '';

        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', lang('editprofile_username'), 'required|max_length[32]|alpha_numeric' . ($username_changed ? '|is_unique[users.User_Name]' : ''));
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email' . ($email_changed ? '|is_unique[users.Email]' : ''));
        $this->form_validation->set_rules('language', lang('editprofile_language'), array(function($value) {
            return in_array($value, array('english', 'estonian'));
        }));

        if ($password_changed) {
            $this->form_validation->set_rules('new_password', lang('editprofile_newpassword'), 'required|min_length[7]');
            $this->form_validation->set_rules('repeat_new_password', lang('validation_repeatedpassword'), 'matches[new_password]', array('matches' => lang('editprofile_passwordsdiffer')));
            $this->form_validation->set_rules('current_password', lang('validation_password'), 'required');
        }

        if (!is_null($this->input->post('btn_delete'))) {
            $this->_detete_user();
            return;
        }

        if ($this->form_validation->run()) {
            $updated_columns = array();

            if ($username_changed) {
                $updated_columns['User_Name'] = $this->input->post('username');
            }

            if ($language_changed) {
                $updated_columns['Language'] = $this->input->post('language');
            }

            if ($email_changed) {
                $updated_columns['Email'] = $this->input->post('email');

                if (!$this->_confirm_email($this->session->user_id, $this->input->post('email'))) {
                    $this->_load_edit_profile(lang('editprofile_couldntsendemail'));
                    return;
                }
            }

            if ($password_changed) {
                if ($this->user_model->verify($this->session->username, $this->input->post('current_password'))) {
                    if (!$this->user_model->verify($this->session->username, $this->input->post('new_password'))) {
                        $updated_columns['Password_Hash'] = password_hash($this->input->post('new_password'), PASSWORD_BCRYPT);
                    } else {
                        $this->_load_edit_profile(lang('editprofile_samepassword'));
                        return;
                    }
                } else {
                    $this->_load_edit_profile(lang('editprofile_wrongpassword'));
                    return;
                }
            }

            if ($uploading_image) {
                $this->load->helper('upload_helper');

                $result = false;

                try {
                    $result = upload_image($this, 'userfile');
                } catch (Exception $exception) {
                    $this->_load_edit_profile( lang('addmeme_upload_to_cloud_fail') );
                    return;
                }

                if ($result === false) {
                    $this->_load_edit_profile( lang('addmeme_upload_fail'));
                    return;
                }
                $prev_image = $this->user_model->retrieve_id($this->session->user_id)->ProfileImg_Id;
                if ($prev_image !== 'noprofileimg.jpg') {
                  delete_image(substr($prev_image, 0, -4));
                }
                $updated_columns['ProfileImg_Id'] = $result['public_id'] . '.' . $result['format'];
            }

            if (count($updated_columns) > 0) {
                $this->user_model->update($this->session->user_id, $updated_columns);
            }

            $this->_update_session_data();
            redirect('/profile/' . $this->session->username, 'refresh');
        } else {
            $error = validation_errors();
        }

        $this->_load_edit_profile($error);
    }

    public function email_confirmation($string) {
        $result = $this->user_model->find_id_by_confirmation($string);

        if (count($result) === 0) {
            show_404();
        }

        $this->user_model->set_confirmation($result[0]['Id'], null);

        if ($this->session->logged_in) {
            $this->_update_session_data();
        }

        redirect('/', 'refresh');
    }

    public function resend_confirmation() {
        var_dump($this->session->email_not_confirmed);

        /*if ($this->session->logged_in && $this->session->email_not_confirmed) {
            $this->_confirm_email($this->session->user_id, $this->session->email);
            redirect(site_url('/edit_profile'), 'refresh');
        } else {
            show_404();
        }*/
    }

    private function _load_edit_profile($error = null) {
        $user_data = $this->user_model->retrieve($this->session->username);

        $data = array(
            'username' => $user_data->User_Name,
            'email' => $user_data->Email,
            'mobile_number' => $user_data->mobile_number,
            'profile_image' => $user_data->ProfileImg_Id,
            'language' => $user_data->Language,
            'email_not_confirmed' => $this->session->email_not_confirmed,
            'error' => $error
        );

        $this->load->view('edit_profile', $data);
    }

    private function _exists_and_equals($what, $from) {
        if (!isset($what) || $what === null) {
            return false;
        }

        return $what === $from;
    }

    private function _login_and_redirect($username, $link_with_fb=false, $fbid=null, $confirm=false) {
      $user = $this->user_model->retrieve($username);
      if ($link_with_fb) {
        $this->_link_user_facebook($user->Id, $fbid);
      }
      $this->_login_and_redirect_data($user, $link_with_fb, $confirm);
    }

    private function _login_and_redirect_data($user, $link_with_fb=false, $confirm=false) {
        $this->user_model->update_last_login_date($user->Id);

        if ($confirm) {
            $this->_confirm_email($user->Id, $user->Email);
        }

        $this->_update_session_data($user, $link_with_fb);

        redirect($this->session->referenced_form, 'refresh');
    }

    private function _update_session_data($user=null, $link_with_fb=false) {
        if (is_null($user)) {
            $user = $this->user_model->retrieve_id($this->session->user_id);
        }
        if (!isset($this->session->referenced_form)) {
          $this->session->referenced_form = '/';
        }
        $this->session->logged_in = true;
        $this->session->username = $user->User_Name;
        $this->session->email = $user->Email;
        $this->session->user_id = $user->Id;
        $this->session->language = $user->Language;
        $this->session->user_type = $user->User_Type;
        $this->session->fb_linked = isset($user->FB_Id) || $link_with_fb;
        $this->session->email_not_confirmed = is_null($user->confirmation) === true;
    }

    private function _detete_user() {
        $user = $this->user_model->retrieve_id($this->session->user_id);

        $this->load->helper('upload_helper');

        if ($user->ProfileImg_Id !== 'noprofileimg.jpg') {
            delete_image(substr($user->ProfileImg_Id, 0, -4));
        }

        $memes = $this->user_model->get_memes($this->session->user_id);

        foreach ($memes as $meme) {
            if ($meme['Data_Type'] === 'P') {
                delete_image(substr($meme['Data'], 0, -4));
            }
        }

        $this->user_model->delete($this->session->user_id);
        $this->session->referenced_form = '/';
        $this->logout();
    }

    private function _confirm_email($user_id, $email) {
        do {
            $random_string = $this->_generate_random_string(32);
        } while (count($this->user_model->find_id_by_confirmation($random_string)) !== 0);

        $confirmation_url = site_url('/users/email_confirmation/' . $random_string);

        $message = '';
        $message .= 'Click on this link to confirm your email<br>';
        $message .= '<a href="' . $confirmation_url . '">' . $confirmation_url . '</a>';

        $this->user_model->set_confirmation($user_id, $random_string);

        return $this->_send_email($email, 'Email confirmation', $message);
    }

    private function _generate_random_string($length) {
        return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
    }

    private function _send_email($to, $subject, $message) {
        $config = array();
        require(APPPATH . 'config/email.php');

        $this->load->library('email');

        $this->email->initialize($config);
        $this->email->from($config['from']);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($message);
        $this->email->set_newline("\r\n");

        return $this->email->send();
    }
}
