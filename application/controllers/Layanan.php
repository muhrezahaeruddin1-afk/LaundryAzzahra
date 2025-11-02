<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Layanan_model');
    $this->load->helper(['url','form']);
    $this->load->database();
  }

  public function index(){
    $data['title']   = 'Layanan & Harga';
    $data['active']  = 'layanan';
    $data['layanan'] = $this->Layanan_model->all();

    $this->load->view('partials/header', $data);
    $this->load->view('layanan_index', $data);
    $this->load->view('partials/footer');
  }

  public function create(){
    $data['title']  = 'Tambah Layanan';
    $data['active'] = 'layanan';
    $data['data']   = (object)[
      'id'=>null,'nama'=>'','tipe_satuan'=>'KG','harga_per_satuan'=>'','aktif'=>1
    ];
    $data['mode']   = 'create';

    $this->load->view('partials/header', $data);
    $this->load->view('layanan_form', $data);
    $this->load->view('partials/footer');
  }

  public function store(){
    $insert = [
      'nama' => $this->input->post('nama', true),
      'tipe_satuan' => $this->input->post('tipe_satuan', true),
      'harga_per_satuan' => (int)$this->input->post('harga_per_satuan'),
      'aktif' => $this->input->post('aktif') ? 1 : 0
    ];
    $this->Layanan_model->create($insert);
    redirect('layanan');
  }

  public function edit($id){
    $row = $this->Layanan_model->by_id($id);
    if(!$row) return redirect('layanan');

    $data['title']  = 'Edit Layanan';
    $data['active'] = 'layanan';
    $data['data']   = $row;
    $data['mode']   = 'edit';

    $this->load->view('partials/header', $data);
    $this->load->view('layanan_form', $data);
    $this->load->view('partials/footer');
  }

  public function update($id){
    $update = [
      'nama' => $this->input->post('nama', true),
      'tipe_satuan' => $this->input->post('tipe_satuan', true),
      'harga_per_satuan' => (int)$this->input->post('harga_per_satuan'),
      'aktif' => $this->input->post('aktif') ? 1 : 0
    ];
    $this->Layanan_model->update($id, $update);
    redirect('layanan');
  }

  public function toggle($id){
    $this->Layanan_model->toggle($id);
    redirect('layanan');
  }

  public function delete($id){
    $this->Layanan_model->delete($id);
    redirect('layanan');
  }
}
