<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
        $this->load->database();
    }

    public function create($username, $password, $email) {
        $procedure = 'call sp_add_user(?, ?, ?, ?, ?)';

        $parameters = array(
            'PARAM_1' => 0, // type
            'PARAM_2' => $username,
            'PARAM_3' => password_hash($password, PASSWORD_BCRYPT),
            'PARAM_4' => $email,
            'PARAM_5' => "1234567" // mobile
        );

        return $this->db->query($procedure, $parameters);
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
