<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Pelanggan_model');
    $this->load->helper(['url','form']);
    $this->load->database();
  }

  // LIST + pencarian (pakai header/footer)
  public function index(){
    $q = $this->input->get('q');
    $data['title'] = 'Pelanggan';
    $data['active'] = 'pelanggan';
    $data['q'] = $q ?: '';
    $data['rows'] = $this->Pelanggan_model->all($q);

    $this->load->view('partials/header', $data);
    $this->load->view('pelanggan_index', $data);
    $this->load->view('partials/footer');
  }

  // FORM TAMBAH
  public function create(){
    $data['title']  = 'Tambah Pelanggan';
    $data['active'] = 'pelanggan';
    $data['data']   = (object)['id'=>null,'nama'=>'','telp'=>'','alamat'=>''];
    $data['mode']   = 'create';

    $this->load->view('partials/header', $data);
    $this->load->view('pelanggan_form', $data);
    $this->load->view('partials/footer');
  }

  // SIMPAN BARU
  public function store(){
    $this->Pelanggan_model->create([
      'nama'   => $this->input->post('nama',true),
      'telp'   => $this->input->post('telp',true),
      'alamat' => $this->input->post('alamat',true),
    ]);
    redirect('pelanggan');
  }

  // FORM EDIT
  public function edit($id){
    $row = $this->Pelanggan_model->by_id($id);
    if(!$row) return redirect('pelanggan');

    $data['title']  = 'Edit Pelanggan';
    $data['active'] = 'pelanggan';
    $data['data']   = $row;
    $data['mode']   = 'edit';

    $this->load->view('partials/header', $data);
    $this->load->view('pelanggan_form', $data);
    $this->load->view('partials/footer');
  }

  // UPDATE
  public function update($id){
    $this->Pelanggan_model->update($id, [
      'nama'   => $this->input->post('nama',true),
      'telp'   => $this->input->post('telp',true),
      'alamat' => $this->input->post('alamat',true),
    ]);
    redirect('pelanggan');
  }

  // HAPUS
  public function delete($id){
    $this->Pelanggan_model->delete($id);
    redirect('pelanggan');
  }

  // DETAIL + RIWAYAT
  public function detail($id){
    list($info,$sum,$list) = $this->Pelanggan_model->summary_with_history($id);
    if(!$info) return redirect('pelanggan');

    $data['title']  = 'Detail Pelanggan';
    $data['active'] = 'pelanggan';
    $data['info']   = $info;
    $data['sum']    = $sum;
    $data['list']   = $list;

    $this->load->view('partials/header', $data);
    $this->load->view('pelanggan_detail', $data);
    $this->load->view('partials/footer');
  }
}
