<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Cek login
        if (!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }

        // Cek level = admin
        if ($this->session->userdata('level') != 'admin') {
            show_error('Akses ditolak. Hanya admin yang boleh masuk.');
        }

        $this->load->model('Admin_model');
        $this->load->library('form_validation');
    }

    // Halaman daftar admin
    public function index() {
        $data['admins'] = $this->Admin_model->get_all_admins();
        $this->load->view('layouts/header');
        $this->load->view('layouts/sidebar');
        $this->load->view('admin/index', $data);
        $this->load->view('layouts/footer');
    }

    // Tambah admin
    public function add() {
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header');
            $this->load->view('layouts/sidebar');
            $this->load->view('admin/form_add');
            $this->load->view('layouts/footer');
        } else {

            $save = [
                'nama'     => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'email'    => $this->input->post('email'),
                'password' => password_hash($this->input->post('password'), PASSWORD_DEFAULT),
                'level'    => 'admin'
            ];

            $this->Admin_model->insert_admin($save);

            redirect('admin');
        }
    }

    // Edit admin
    public function edit($id) {
        $data['admin'] = $this->Admin_model->get_admin($id);

        if (!$data['admin']) {
            show_404();
        }

        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('layouts/header');
            $this->load->view('layouts/sidebar');
            $this->load->view('admin/form_edit', $data);
            $this->load->view('layouts/footer');
        } else {

            $update = [
                'nama'     => $this->input->post('nama'),
                'email'    => $this->input->post('email'),
            ];

            // Kalau password diisi, update password
            if ($this->input->post('password') != '') {
                $update['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
            }

            $this->Admin_model->update_admin($id, $update);

            redirect('admin');
        }
    }

    // Hapus admin
    public function delete($id) {
        $this->Admin_model->delete_admin($id);
        redirect('admin');
    }
}
