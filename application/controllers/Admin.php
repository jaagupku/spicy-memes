<?php

class Admin extends CI_Controller {
  public function __construct() {
      parent::__construct();
      $this->load->model('user_model');
  }

  public function view_users() {
    if (!(isset($this->session->logged_in) && $this->session->user_type > 0)) {
        show_404();
        exit;
    }
    $data['from'] = isset($_REQUEST["from"]) ? $_REQUEST["from"] : 0;
    $data['amount'] = isset($_REQUEST["amount"]) ? $_REQUEST["amount"] : 20;
    $data['reports'] = $this->user_model->get_users($data['from'], $data['amount'] + 1);
    if (count($data['users']) == $data['amount']+1) {
      $data['is_more'] = TRUE;
      array_pop($data['users']);
    } else {
      $data['is_more'] = FALSE;
    }

    $data['username'] = $this->session->username;

    $this->load->view('pages/users', $data);
  }

  public function delete_user() {
    $id = $_REQUEST['id'];
    if (!isset($id) && !(isset($this->session->logged_in) && $this->session->user_type > 0)) {
      show_404();
      exit;
    }
    $this->user_model->delete($id);
    redirect(site_url('admin/view_users'));
  }
}
