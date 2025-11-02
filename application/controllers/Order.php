<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->model(['Pelanggan_model','Pesanan_model','Transaksi_model','Layanan_model']);
    $this->load->helper(['url','form']);
    $this->load->library('form_validation');
    $this->load->database();
  }

  // Form pemesanan (pakai header/footer)
  public function baru(){
    $data['title']     = 'Pemesanan Baru';
    $data['active']    = 'pesanan';
    $data['layanan']   = $this->Layanan_model->all_active();
    $data['pelanggan'] = $this->Pelanggan_model->all();

    $this->load->view('partials/header', $data);
    $this->load->view('order_form', $data);
    $this->load->view('partials/footer');
  }

  // Simpan pesanan baru
  public function create(){

    // ===== 1) VALIDASI WAJIB ISI =====
    if (empty($this->input->post('pelanggan_id'))) {
      $this->form_validation->set_rules('nama',   'Nama Pelanggan', 'trim|required');
      $this->form_validation->set_rules('telp',   'No. Telp',       'trim|required');
      $this->form_validation->set_rules('alamat', 'Alamat',         'trim|required');
    }
    $this->form_validation->set_rules('estimasi_selesai_jam', 'Estimasi Selesai (Jam)', 'required|integer|greater_than[0]');
    $this->form_validation->set_rules('metode_terima',        'Cara Terima',            'required'); // ambil_sendiri / antar
    $this->form_validation->set_rules('metode',               'Metode Pembayaran',      'required');

    if ($this->input->post('metode_terima') === 'antar') {
      $this->form_validation->set_rules('jarak_km', 'Jarak (KM)', 'required|numeric|greater_than[0]');
    }

    if ($this->form_validation->run() === FALSE) {
      $data['title']     = 'Pemesanan Baru';
      $data['active']    = 'pesanan';
      $data['layanan']   = $this->Layanan_model->all_active();
      $data['pelanggan'] = $this->Pelanggan_model->all();

      $this->load->view('partials/header', $data);
      $this->load->view('order_form', $data);
      $this->load->view('partials/footer');
      return;
    }

    // ===== 2) PELANGGAN =====
    $pelanggan_id = $this->input->post('pelanggan_id');
    if (!$pelanggan_id) {
      $pelanggan_id = $this->Pelanggan_model->upsert(
        $this->input->post('nama'),
        $this->input->post('telp'),
        $this->input->post('alamat')
      );
    }

    // ===== 3) ITEM LAYANAN (wajib minimal 1) =====
    $items = [];
    $ids = (array)$this->input->post('layanan_id');
    $qty = (array)$this->input->post('qty');

    for ($i = 0; $i < count($ids); $i++) {
      if (!empty($ids[$i]) && floatval($qty[$i]) > 0) {
        $items[] = ['layanan_id' => $ids[$i], 'qty' => $qty[$i]];
      }
    }

    if (empty($items)) {
      $data['title']     = 'Pemesanan Baru';
      $data['active']    = 'pesanan';
      $data['layanan']   = $this->Layanan_model->all_active();
      $data['pelanggan'] = $this->Pelanggan_model->all();
      $data['error_manual'] = 'Minimal pilih 1 layanan dan QTY > 0 ya 🙏';

      $this->load->view('partials/header', $data);
      $this->load->view('order_form', $data);
      $this->load->view('partials/footer');
      return;
    }

    // ===== 4) BUAT PESANAN =====
    list($pesanan_id, $kode, $total_layanan) = $this->Pesanan_model->create(
      $pelanggan_id,
      $items,
      $this->input->post('berat_kg'),
      $this->input->post('catatan')
    );

    // ===== 5) HITUNG BIAYA TAMBAHAN =====
    $is_express    = $this->input->post('express') ? true : false;
    $biaya_express = $is_express ? 5000 : 0;

    $metode_terima = $this->input->post('metode_terima'); // 'ambil_sendiri' atau 'antar'
    $jarak_km      = (float)$this->input->post('jarak_km');
    $biaya_antar   = 0;
    if ($metode_terima === 'antar') {
      $biaya_antar = (int)(ceil($jarak_km) * 5000); // 5rb per 1 km, dibulatkan ke atas
    }

    // Grand total = subtotal layanan + express + antar
    $grand_total = $total_layanan + $biaya_express + $biaya_antar;

    // ===== 6) SIMPAN KE TABEL PESANAN =====
    $this->db->where('id', $pesanan_id)->update('pesanan', [
      'estimasi_selesai_jam' => (int)$this->input->post('estimasi_selesai_jam'),
      'metode_terima'        => $metode_terima,
      'jarak_km'             => $jarak_km,
      'biaya_antar'          => $biaya_antar
    ]);

    // ===== 7) TRANSAKSI =====
    $metode_bayar = $this->input->post('metode');
    $trx_id = $this->Transaksi_model->create_unpaid($pesanan_id, $grand_total, 0, $biaya_express, $metode_bayar);

    if ($metode_bayar === 'CASH') {
      $this->Transaksi_model->set_paid($trx_id, 'CASH');
    }

    redirect('order/receipt/'.$trx_id);
  }

  public function mark_paid($trx_id){
    $ref = $this->input->post('qris_ref') ?: 'QRIS';
    $this->Transaksi_model->set_paid($trx_id,$ref);
    redirect('order/receipt/'.$trx_id);
  }

  // Struk: TIDAK pakai header/footer (biar enak di-print)
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

  public function index(){
  // arahkan ke form pemesanan baru
  redirect('order/baru');
}

}
