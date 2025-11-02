<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model('Layanan_model');
    $this->load->helper(['url','form','auth']);
    $this->load->database();
    require_login(); // wajib login
  }

  public function index(){
    $data['layanan'] = $this->Layanan_model->all();
    $this->load->view('layanan_index', $data);
  }

  public function create(){
    $data = (object)[
      'id'=>null,'nama'=>'','tipe_satuan'=>'KG','harga_per_satuan'=>'','aktif'=>1
    ];
    $this->load->view('layanan_form', ['data'=>$data,'mode'=>'create']);
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
    $this->load->view('layanan_form', ['data'=>$row,'mode'=>'edit']);
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
