<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('User_model');
    }

    // LOGIN
    public function login() {
        // Jika sudah login, redirect ke dashboard
        if($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if($this->form_validation->run() == TRUE) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->User_model->login($username, $password);

            if($user) {
                $user_data = array(
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'email' => $user->email,
                    'nama_lengkap' => $user->nama,
                    'level' => $user->level,
                    'logged_in' => TRUE

                );

                $this->session->set_userdata($user_data);
                redirect('dashboard');
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah!');
                redirect('auth/login');
            }
        }

        $this->load->view('auth/login');
    }

    // REGISTER
    public function register() {
        if($this->session->userdata('logged_in')) {
            redirect('dashboard');
        }

        $this->form_validation->set_rules('nama_lengkap', 'Nama Lengkap', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|callback_username_check');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_check');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');

        if($this->form_validation->run() == TRUE) {
            $data = array(
                'nama_lengkap' => $this->input->post('nama_lengkap'),
                'username' => $this->input->post('username'),
                'email' => $this->input->post('email'),
                'password' => $this->input->post('password'),
            );

            if($this->User_model->register($data)) {
                $this->session->set_flashdata('success', 'Registrasi berhasil! Silakan login.');
                redirect('auth/login');
            } else {
                $this->session->set_flashdata('error', 'Registrasi gagal!');
                redirect('auth/register');
            }
        }

        $this->load->view('auth/register');
    }

    // LOGOUT
    public function logout() {
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('nama_lengkap');
        $this->session->unset_userdata('role');
        $this->session->unset_userdata('logged_in');
        
        $this->session->sess_destroy();
        $this->session->set_flashdata('success', 'Logout berhasil!');
        redirect('auth/login');
    }

    // Custom validation callbacks
    public function username_check($username) {
        if($this->User_model->username_exists($username)) {
            $this->form_validation->set_message('username_check', 'Username sudah digunakan!');
            return FALSE;
        }
        return TRUE;
    }

    public function email_check($email) {
        if($this->User_model->email_exists($email)) {
            $this->form_validation->set_message('email_check', 'Email sudah digunakan!');
            return FALSE;
        }
        return TRUE;
    }
}