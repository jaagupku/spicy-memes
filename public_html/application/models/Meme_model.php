<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Base_Model.php');

class Meme_model extends Base_Model {
    public function __construct() {
        parent::__construct();
        $this->table = 'meme';
    }

    public function add($title, $user_id, $data_type, $data) {
        return $this->_call_procedure('sp_add_meme', array($title, $user_id, $data_type, $data));
    }

    public function vote($meme_id, $user_id, $vote) {
        return $this->_call_procedure('sp_vote_meme', array($meme_id, $user_id, $vote));
    }

    public function delete_vote($meme_id, $user_id) {
        $this->db->where('Meme_Id', $meme_id);
        $this->db->where('User_Id', $user_id);
        $this->db->delete('memepoints');
    }

    public function get_votes($meme_ids, $user_id) {
        $this->db->from('memepoints');
        $this->db->select('*');
        $this->db->where('User_Id', $user_id);
        $this->db->where_in('Meme_Id', $meme_ids);

        return $this->db->get()->result();
    }

    public function retrieve($id) {
        $this->db->from('meme');
        $this->db->where('Id', $id);

        return $this->db->get()->row();
    }

    public function get($id) { // Almost same as retrieve, but v_top_memes has some extra columns
        $this->db->from('v_top_memes');
        $this->db->where('Id', $id);

        return $this->db->get()->row_array();
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

    public function get_comments($id, $order) {
        $this->db->from('v_comments');
        $this->db->where('Meme_Id', $id);
        $this->db->order_by($order, 'DESC');

        return  $this->db->get()->result_array();
    }

    public function get_newer_than($date) {
        $this->db->from('v_new_memes');
        $this->db->where('Date >', $date);

        return $this->db->get()->result_array();
    }

    public function find_like($value, $order) {
        $this->db->from('v_top_memes');
        $this->db->like('Title', $value);
        $this->db->order_by($order, 'DESC');

        return $this->db->get()->result_array();
    }

    public function delete_meme($memeid) {
      $this->db->where('Id', $memeid);
      $this->db->delete('meme');
    }
}
