<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function login($username, $password) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        
        if($query->num_rows() == 1) {
            $user = $query->row();
            // Verifikasi password menggunakan $hash
            $hash = $user->password;
            if(password_verify($password, $hash)) {
                return $user;
            }
        }
        return false;
    }

    public function register($data) {
        // Hash password menggunakan $hash
        $password = $data['password'];
        $hash = password_hash($password, PASSWORD_DEFAULT);
        
        $user_data = array(
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $hash, // Simpan $hash ke database
            'nama' => $data['nama_lengkap'],
            'level' => 'user'
        );
        
        return $this->db->insert('users', $user_data);
    }

    public function username_exists($username) {
        $this->db->where('username', $username);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }

    public function email_exists($email) {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->num_rows() > 0;
    }
}