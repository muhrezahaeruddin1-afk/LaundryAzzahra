<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model(['Pelanggan_model','Pesanan_model','Transaksi_model','Layanan_model']);
    $this->load->helper(['url','form','auth']);
    $this->load->database();
    require_login(); // Wajib login
  }

  // Form pemesanan
  public function baru(){
    $data['layanan']   = $this->Layanan_model->all_active(); 
    $data['pelanggan'] = $this->Pelanggan_model->all();       
    $this->load->view('order_form', $data);
  }

  // Simpan pesanan baru
  public function create(){
    $pelanggan_id = $this->input->post('pelanggan_id');
    if (!$pelanggan_id) {
      $pelanggan_id = $this->Pelanggan_model->upsert(
        $this->input->post('nama'),
        $this->input->post('telp'),
        $this->input->post('alamat')
      );
    }

    $items = [];
    $ids = (array)$this->input->post('layanan_id');
    $qty = (array)$this->input->post('qty');
    for($i=0; $i<count($ids); $i++){
      if(!empty($ids[$i]) && floatval($qty[$i]) > 0){
        $items[] = ['layanan_id' => $ids[$i], 'qty' => $qty[$i]];
      }
    }

    list($pesanan_id,$kode,$total) = $this->Pesanan_model->create(
      $pelanggan_id,
      $items,
      $this->input->post('berat_kg'),
      $this->input->post('catatan')
    );

    $biaya  = $this->input->post('express') ? 5000 : 0;
    $metode = $this->input->post('metode');
    $trx_id = $this->Transaksi_model->create_unpaid($pesanan_id, $total, 0, $biaya, $metode);

    if ($metode === 'CASH') {
      $this->Transaksi_model->set_paid($trx_id, 'CASH');
    }

    redirect('order/receipt/'.$trx_id);
  }

  public function mark_paid($trx_id){
    $ref = $this->input->post('qris_ref') ?: 'QRIS';
    $this->Transaksi_model->set_paid($trx_id,$ref);
    redirect('order/receipt/'.$trx_id);
  }

  public function receipt($trx_id){
    list($trx,$items) = $this->Transaksi_model->detail_for_receipt($trx_id);
    $data = compact('trx','items');
    $this->load->view('receipt', $data);
  }

  public function done($trx_id){
    $trx = $this->db->get_where('transaksi',['id'=>$trx_id])->row();
    if($trx){
      $this->db->where('id',$trx->pesanan_id)->update('pesanan',['status'=>'SELESAI']);
    }
    redirect('order/receipt/'.$trx_id);
  }
}
