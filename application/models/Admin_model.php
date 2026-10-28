<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    // Ambil semua akun level admin
    public function get_all_admins() {
        $this->db->where('level', 'admin');
        return $this->db->get('users')->result();
    }

    // Ambil 1 admin berdasarkan id
    public function get_admin($id) {
        return $this->db->get_where('users', ['id' => $id, 'level' => 'admin'])->row();
    }

    // Save data admin baru
    public function insert_admin($data) {
        return $this->db->insert('users', $data);
    }

    // Update admin
    public function update_admin($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    // Hapus admin
    public function delete_admin($id) {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
}
