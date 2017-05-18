<?php

class Aboutus extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
      $this->load->view("pages/about-us", array('username' => $this->session->username));
    }
    public function received() {
      $this->load->view('pages/receive', array('username' => $this->session->username));
    }
    public function notreceived() {
      $this->load->view('pages/notreceived', array('username' => $this->session->username));
    }
}
