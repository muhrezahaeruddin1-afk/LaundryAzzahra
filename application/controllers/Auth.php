<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->helper(['url','form']);
    $this->load->library('session');
  }

  public function login(){
    if ($this->session->userdata('user_id')) return redirect('dashboard');

    if ($this->input->method() === 'post') {
      $username = trim($this->input->post('username', true));
      $password = (string)$this->input->post('password', true);

      $user = $this->db->get_where('users', ['username' => $username])->row();

      if ($user) {
        $hash = $user->password_hash;

        $ok = false;

        // 1) Cek bcrypt (standar)
        if (strlen($hash) >= 55 && strpos($hash, '$2y$') === 0) {
          $ok = password_verify($password, $hash);
        }

        // 2) Fallback: kalau ternyata kolom berisi plaintext (mis-insert),
        //    izinkan sekali lalu migrasikan ke bcrypt.
        if (!$ok && $password === $hash) {
          $ok = true;
          $newHash = password_hash($password, PASSWORD_BCRYPT);
          $this->db->where('id', $user->id)->update('users', ['password_hash' => $newHash]);
        }

        if ($ok) {
          $this->session->set_userdata([
            'user_id'  => $user->id,
            'nama'     => $user->nama,
            'username' => $user->username,
            'role'     => $user->role
          ]);
          return redirect('dashboard');
        }
      }

      $this->session->set_flashdata('error', 'Username atau password salah!');
      return redirect('login');
    }

    $this->load->view('login');
  }

  public function logout(){
    $this->session->sess_destroy();
    redirect('login');
  }
}
