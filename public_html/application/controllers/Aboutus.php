<?php

class Aboutus extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
      $this->load->view("about-us", array('username' => $this->session->username));
    }
    public function received() {
      $this->load->view('receive', array('username' => $this->session->username));
    }
    public function notreceived() {
      $this->load->view('notreceived', array('username' => $this->session->username));
    }
}
