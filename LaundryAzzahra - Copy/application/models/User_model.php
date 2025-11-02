<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

  public function find_by_username($username){
    return $this->db->get_where('users', ['username' => $username])->row();
  }

  public function create($nama, $username, $password, $role = 'admin'){
    $hash = password_hash($password, PASSWORD_BCRYPT);
    $this->db->insert('users', [
      'nama' => $nama,
      'username' => $username,
      'password_hash' => $hash,
      'role' => $role
    ]);
    return $this->db->insert_id();
  }
}
