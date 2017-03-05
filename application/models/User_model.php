<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once('Base_Model.php');

class User_model extends Base_Model {
    public function __construct() {
        parent::__construct();
        $this->table = 'users';
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
}
