<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Base_Model.php');

class Meme_model extends Base_Model {
    public function __construct() {
        parent::__construct();
        $this->table = 'meme';
    }

    public function add_meme($title, $user_id, $data_type, $data) {
        return $this->_call_procedure('sp_add_meme', array($title, $user_id, $data_type, $data));
    }

    public function add_comment($meme_id, $user_id, $message) {
        return $this->_call_procedure('sp_add_comment', array($meme_id, $user_id, $message));
    }

    public function vote_meme($meme_id, $user_id, $vote) {
      return $this->_call_procedure('sp_vote_meme', array($meme_id, $user_id, $vote));
    }

    public function delete_vote_meme($meme_id, $user_id) {
        $this->db->where('Meme_Id', $meme_id);
        $this->db->where('User_Id', $user_id);
        $this->db->delete('memepoints');
    }

    public function get_meme_votes($meme_ids) {
        $this->db->from('memepoints');
        $this->db->select('*');
        $this->db->where_in('Meme_Id', $meme_ids);

        return $this->db->get()->result();
    }

    public function vote_comment($comment_id, $user_id, $vote) {
      return $this->_call_procedure('sp_vote_comment', array($comment_id, $user_id, $vote));
    }

    public function get_meme($id) {
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

    public function get_meme_comments($id, $order) {
        $query = $this->db->query("SELECT * FROM v_comments WHERE Meme_Id=$id ORDER BY $order DESC");
        return $query->result_array();
    }
}
