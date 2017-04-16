<?php

class Report extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('report_model');
        $this->load->library('form_validation');
    }

    public function view() {
      if (!(isset($this->session->logged_in) && $his->session->user_type > 0)) {
          show_404();
          exit;
      }
      $data['from'] = isset($_REQUEST["from"]) ? $_REQUEST["from"] : 0;
      $data['amount'] = isset($_REQUEST["amount"]) ? $_REQUEST["amount"] : 20;
      $data['reports'] = $this->report_model->get_reports($data['from'], $data['amount'] + 1);
      if (count($data['reports']) == 21) {
        $data['is_more'] = TRUE;
        array_pop($data['reports']);
      } else {
        $data['is_more'] = FALSE;
      }

      $this->load->view('pages/reports');
    }

    public function post_report() {
      if (!(isset($this->session->logged_in) && $this->session->logged_in)) {
          show_404();
          exit;
      }

      $this->form_validation->set_rules('type', '', 'required|numeric');
      $this->form_validation->set_rules('data', '', 'max_length[255]'); // TODO lang

      if ($this->form_validation->run()) {
        // TODO save report
        redirect($this->session->referenced_form, 'refresh');
      } else {
        show_404();
      }
    }
}
