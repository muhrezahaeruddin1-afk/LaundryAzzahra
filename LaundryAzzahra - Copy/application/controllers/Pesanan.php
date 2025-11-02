<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pesanan extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->helper(['url','form','auth']);
    require_login(); // wajib login
  }

  public function index(){
    $st = $this->input->get('status');
    $args = [];

    $sub = "
      SELECT t1.*
      FROM transaksi t1
      JOIN (
        SELECT pesanan_id, MAX(id) AS max_id
        FROM transaksi
        GROUP BY pesanan_id
      ) latest ON latest.pesanan_id = t1.pesanan_id AND latest.max_id = t1.id
    ";

    $where = '';
    if ($st && $st !== 'ALL') {
      $where = "WHERE p.status = ?";
      $args[] = $st;
    }

    $sql = "
      SELECT p.*, pel.nama AS nama_pelanggan, pel.telp,
             tt.metode, tt.status_bayar, COALESCE(tt.grand_total, 0) AS grand_total
      FROM pesanan p
      LEFT JOIN pelanggan pel ON pel.id = p.pelanggan_id
      LEFT JOIN ($sub) tt ON tt.pesanan_id = p.id
      $where
      ORDER BY p.tanggal_masuk DESC
    ";

    $data['pesanan']    = $this->db->query($sql, $args)->result();
    $data['status_now'] = $st ?: 'ALL';
    $this->load->view('pesanan_view', $data);
  }

  public function ubah_status($id){
    $allowed = ['MASUK','PROSES','SELESAI'];
    $status_baru = $this->input->get('status');

    if (!in_array($status_baru, $allowed, true)) return redirect('pesanan');

    $this->db->where('id', $id)->update('pesanan', ['status' => $status_baru]);
    redirect('pesanan');
  }

  public function hapus($id){
    $this->db->delete('pesanan', ['id' => $id]);
    redirect('pesanan');
  }
}
