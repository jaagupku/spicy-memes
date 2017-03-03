<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Model
{
    public function __construct()
    {
        $this->table = 'users';
    }

    public function retrieve($username) {

    }

    public function insert($data = array()) {

    }
}