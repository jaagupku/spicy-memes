<?php

class Admin extends CI_Controller {
  public function __construct() {
      parent::__construct();
      $this->load->model('user_model');
      $this->load->helper('upload_helper');
  }

  public function view_users() {
    if (!(isset($this->session->logged_in) && $this->session->user_type > 0)) {
        show_404();
        exit;
    }
    $data['from'] = isset($_REQUEST["from"]) ? $_REQUEST["from"] : 0;
    $data['amount'] = isset($_REQUEST["amount"]) ? $_REQUEST["amount"] : 20;
    $data['users'] = $this->user_model->get_users($data['from'], $data['amount'] + 1);
    if (count($data['users']) == $data['amount']+1) {
      $data['is_more'] = TRUE;
      array_pop($data['users']);
    } else {
      $data['is_more'] = FALSE;
    }

    $data['username'] = $this->session->username;

    $this->load->view('pages/users', $data);
  }

  public function view_usersJSON() {
    if (!(isset($this->session->logged_in) && $this->session->user_type > 0)) {
        show_404();
        exit;
    }
    $from = isset($_REQUEST["from"]) ? $_REQUEST["from"] : 0;
    $amount = isset($_REQUEST["amount"]) ? $_REQUEST["amount"] : 20;
    $users = $this->user_model->get_users($from, $amount);

    echo json_encode($users);
  }

  public function delete_user() {
    $id = $_REQUEST['userid'];
    if (!isset($id) && !(isset($this->session->logged_in) && $this->session->user_type > 0)) {
      show_404();
      exit;
    }
    $user = $this->user_model->retrieve($id);
    if ($user->ProfileImg_Id !== 'noprofileimg.jpg') {
      delete_image(substr($user->ProfileImg_Id, 0, -4));
    }
    $memes = $this->get_memes($id);
    foreach ($memes as $meme) {
      if ($meme->Data_Type === 'P') {
        delete_image(substr($meme->Data, 0, -4));
      }
    }
    //if (isset($user->FB_Id)) {
    // //TODO
    //}
    $this->user_model->delete($id);
    redirect(site_url('admin/view_users'));
  }
}
