<?php

class Base_Model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    protected function _call_procedure($procedure, $arguments) {
        $argument_count = count($arguments);

        $query = 'call ' . $procedure . '(';
        $query .= str_repeat('?, ', $argument_count - 1);
        $query .= ($argument_count > 0 ? '?' : '') . ')';

        return $this->db->query($query, $arguments);
    }
}
