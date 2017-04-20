<?php

class Report extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('report_model');
        $this->load->model('meme_model');
        $this->load->library('form_validation');
    }

    public function view() {
      if (!(isset($this->session->logged_in) && $this->session->user_type > 0)) {
          show_404();
          exit;
      }
      $data['from'] = isset($_REQUEST["from"]) ? $_REQUEST["from"] : 0;
      $data['amount'] = isset($_REQUEST["amount"]) ? $_REQUEST["amount"] : 20;
      $data['reports'] = $this->report_model->get_reports($data['from'], $data['amount'] + 1);
      if (count($data['reports']) == $data['amount']+1) {
        $data['is_more'] = TRUE;
        array_pop($data['reports']);
      } else {
        $data['is_more'] = FALSE;
      }

      $data['username'] = $this->session->username;

      $this->load->view('pages/reports', $data);
    }

    public function viewJSON() {
      if (!(isset($this->session->logged_in) && $this->session->user_type > 0)) {
          show_404();
          exit;
      }
      $from = isset($_REQUEST["from"]) ? $_REQUEST["from"] : 0;
      $amount = isset($_REQUEST["amount"]) ? $_REQUEST["amount"] : 20;
      $reports = $this->report_model->get_reports($from, $amount);

      echo json_encode($reports);
    }

    public function show_mercy() {
      $id = $_REQUEST['reportid'];
      if (!isset($id)) {
        show_404();
        exit;
      }
      $this->report_model->delete($id);
      redirect(site_url('report/view'));
    }

    public function delete_meme() {
      $id = $_REQUEST['reportid'];
      if (!isset($id)) {
        show_404();
        exit;
      }
      $report = $this->report_model->retrieve($id);
      $this->meme_model->delete_meme($report[0]['Meme_Id']);
      $this->report_model->delete($id);
      redirect(site_url('report/view'));
    }

    public function post_report() {
      if (!(isset($this->session->logged_in) && $this->session->logged_in)) {
          show_404();
          exit;
      }

      $this->form_validation->set_rules('memeid', 'memeid', 'required|numeric');
      $this->form_validation->set_rules('type', lang('type_validation'), 'required|numeric|greater_than_equal_to[0]|less_than[6]');
      $this->form_validation->set_rules('data', lang('other_field_validation'), 'max_length[255]');

      if ($this->form_validation->run()) {
        $data = $this->input->post('data');
        $type = $this->input->post('type');
        $this->report_model->save_report($this->input->post('memeid'), $type, isset($data) && $type===0 ? $data : "");
        redirect($this->session->referenced_form, 'refresh');
      } else {
        show_404();
      }
    }
}
