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
        if ($user_id == NULL)
          return array();
        $this->db->from('memepoints');
        $this->db->select('*');
        $this->db->where('User_Id', $user_id);
        $this->db->where_in('Meme_Id', $meme_ids);

        return $this->db->get()->result();
    }

    public function get($id) {
        $query = $this->db->query("SELECT * FROM v_top_memes WHERE Id=$id");
        return $query->row_array();
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
        $query = $this->db->query("SELECT * FROM v_comments WHERE Meme_Id=$id ORDER BY $order DESC");
        return $query->result_array();
    }
}
