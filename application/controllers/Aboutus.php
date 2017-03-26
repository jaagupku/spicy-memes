<?php

class Aboutus extends CI_Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view("pages/about-us");
    }
    public function received() {
      $this->load->view('pages/receive');
    }
    public function notreceived() {
      $this->load->view('pages/notreceived');
    }
}
