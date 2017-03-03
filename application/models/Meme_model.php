<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Meme_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'meme';
        $this->load->database();
    }

    public function create($title, $user_id, $data_type, $data) {
    }

    public function get_hot_memes($from, $amount) {
        $query = $this->db->limit($amount, $from)->get('v_hot_memes');
        return $query->result_array();
    }

    public function get_top_memes($from, $amount) {
        $query = $this->db->limit($amount, $from)->get('v_top_memes');
        return $query->result_array();
    }

    public function get_new_memes($from, $amount) {
        $query = $this->db->limit($amount, $from)->get('v_new_memes');
        return $query->result_array();
    }
}
