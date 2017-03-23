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
}
