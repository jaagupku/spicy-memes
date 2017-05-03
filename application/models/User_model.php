<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Base_Model.php');

class User_model extends Base_Model {
    public function __construct() {
        parent::__construct();
        $this->table = 'users';
    }

    public function update_last_login_date($user_id) {
      return $this->_call_procedure( 'sp_update_user_last_login', array( $user_id, date("Y-m-d H:i:s") ) );
    }

    public function get_user_meme_data($user_id) {
      return $this->_call_procedure('sp_user_total_memes', array($user_id))->result();
    }

    public function update($user_id, $columns) {
        foreach ($columns as $column => $value) {
            $this->db->set($column, $value);
        }

        $this->db->where('Id', $user_id);
        $this->db->update($this->table);
    }

    public function get_top_memes($user_id) {
        $this->db->from('v_top_memes');
        $this->db->where('User_Id', $user_id);

        return $this->db->get()->result_array();
    }

    public function get_new_memes($user_id) {
        $this->db->from('v_new_memes');
        $this->db->where('User_Id', $user_id);

        return $this->db->get()->result_array();
    }

    public function get_memes($user_id, $order_by = 'Date', $order = 'DESC') {
        $this->db->from('memes');
        $this->db->where('User_Id', $user_id);
        $this->db->order_by($order_by, $order);

        return $this->db->get()->result_array();
    }

    public function create($username, $password, $email) {
        $arguments = array(
            0, // type
            $username,
            password_hash($password, PASSWORD_BCRYPT),
            $email,
            "1234567" // mobile
        );

        return $this->_call_procedure('sp_add_user', $arguments);
    }

    public function link_fb($userid, $fbid) {
      $arguments = array(
        $userid,
        $fbid
      );

      return $this->_call_procedure('sb_link_fb_user', $arguments);
    }

    public function unlink_fb($userid) {
      return $this->_call_procedure('sp_unlink_fb', array($userid));
    }

    public function unlink_fb_by_fbid($fbid) {
      return $this->_call_procedure('sp_unlink_fb_by_fbid', array($fbid));
    }

    public function verify($username, $password) {
        $this->db->from($this->table);
        $this->db->select('Password_Hash');
        $this->db->where('User_Name', $username);

        $hash = $this->db->get()->row('Password_Hash');

        return password_verify($password, $hash);
    }

    public function retrieve($username) {
        $this->db->from($this->table);
        $this->db->where('User_Name', $username);

        return $this->db->get()->row();
    }

    public function retrieve_fb($fb_id) {
      $this->db->from($this->table);
      $this->db->where('FB_Id', $fb_id);

      return $this->db->get()->row();
    }

    public function retrieve_email($email) {
      $this->db->from($this->table);
      $this->db->where('Email', $email);

      return $this->db->get()->row();
    }

    public function delete($id) {
      $this->db->where('Id', $id);
      $this->db->delete('users');
    }

    public function get_users($from, $amount) {
      $query = $this->db->limit($amount, $from)->get('users');
      return $query->result_array();
    }
}
