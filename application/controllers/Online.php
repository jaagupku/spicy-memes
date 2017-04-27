<?php

class Online extends CI_Controller {
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        if ($this->input->method(false) !== 'head') {
            show_404();
        }

        echo 'yes';
    }
}