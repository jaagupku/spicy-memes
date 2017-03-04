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

    public function add_meme($title, $user_id, $data_type, $data) {
      $procedure = 'call sp_add_meme(?, ?, ?, ?)';

      $parameters = array(
          'PARAM_1' => $title,
          'PARAM_2' => $user_id,
          'PARAM_3' => $data_type,
          'PARAM_4' => $data
      );

      return $this->db->query($procedure, $parameters);
    }

    public function add_comment($meme_id, $user_id, $message) {
      $procedure = 'call sp_add_comment(?, ?, ?)';

      $parameters = array(
          'PARAM_1' => $meme_id,
          'PARAM_2' => $user_id,
          'PARAM_3' => $message
      );

      return $this->db->query($procedure, $parameters);
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

    public function get_meme_comments($id) {
      $query = $this->db->query("SELECT * FROM v_comments WHERE Meme_Id=$id");
      return $query->result_array();
    }
}
