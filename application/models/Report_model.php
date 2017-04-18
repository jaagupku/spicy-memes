<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Base_Model.php');

class Report_model extends Base_Model {
  public function __construct() {
      parent::__construct();
      $this->table = 'report';
  }

  public function get_reports($from, $amount) {
    $query = $this->db->limit($amount, $from)->get('v_reports');
    return $query->result_array();
  }

  public function save_report($memeid, $type, $data="") {
    return $this->_call_procedure('sp_add_report', array($memeid, $type, $data));
  }
}
