<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'user';
        $this->load->database();
    }

    public function create($username, $password, $email) {
        $data = array(
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'email' => $email
        );

        return $this->db->insert($this->table, $data);
    }

    public function verify($username, $password) {
        $this->db->from($this->table);
        $this->db->select('password');
        $this->db->where('username', $username);

        $hash = $this->db->get()->row('password');

        return password_verify($password, $hash);
    }

    public function retrieve($username) {
        $this->db->from($this->table);
        $this->db->where('username', $username);

        return $this->db->get()->row();
    }
}