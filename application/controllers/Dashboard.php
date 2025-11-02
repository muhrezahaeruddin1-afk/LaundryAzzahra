<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

 public function __construct(){
  parent::__construct();
  $this->load->database();
  $this->load->helper(['url']); // hapus 'auth'
  // require_login();  // MATIKAN
}


  public function index(){
    // Identitas toko (bisa dipindah ke tabel setting jika mau)
    $data['nama_mitra'] = 'Laundry Azzahra';
    $data['alamat']     = 'Jln. Manuruki 2 No. 79, Makassar';

    // KPI status (hari ini)
    $today = date('Y-m-d');
    $q = $this->db->query("
      SELECT
        COALESCE(SUM(CASE WHEN status='MASUK'   THEN 1 ELSE 0 END),0) AS masuk,
        COALESCE(SUM(CASE WHEN status='PROSES'  THEN 1 ELSE 0 END),0) AS proses,
        COALESCE(SUM(CASE WHEN status='SELESAI' THEN 1 ELSE 0 END),0) AS selesai
      FROM pesanan
      WHERE DATE(tanggal_masuk)=?
    ", [$today])->row();

    $data['kpi_masuk']   = (int)$q->masuk;
    $data['kpi_proses']  = (int)$q->proses;
    $data['kpi_selesai'] = (int)$q->selesai;

    // Pendapatan hari ini (PAID, transaksi terbaru per pesanan)
    $sub = "
      SELECT t1.*
      FROM transaksi t1
      JOIN (
        SELECT pesanan_id, MAX(id) AS max_id
        FROM transaksi
        GROUP BY pesanan_id
      ) s ON s.pesanan_id=t1.pesanan_id AND s.max_id=t1.id
    ";
    $sum = $this->db->query("
      SELECT COALESCE(SUM(CASE WHEN t.status_bayar='PAID' THEN t.grand_total ELSE 0 END),0) AS pendapatan
      FROM pesanan p
      LEFT JOIN ($sub) t ON t.pesanan_id=p.id
      WHERE DATE(p.tanggal_masuk)=?
    ", [$today])->row();

    $data['kpi_pendapatan'] = (int)$sum->pendapatan;

    // Daftar harga ringkas (ambil 8 layanan aktif teratas)
    $harga = $this->db->query("
      SELECT nama, tipe_satuan, harga_per_satuan
      FROM layanan
      WHERE aktif=1
      ORDER BY id ASC
      LIMIT 8
    ")->result();

    // Ubah ke format yang dipakai view ($daftar_harga)
    $data['daftar_harga'] = array_map(function($r){
      return [
        'nama'   => $r->nama,
        'satuan' => '/'.$r->tipe_satuan,
        'harga'  => 'Rp '.number_format((int)$r->harga_per_satuan,0,',','.')
      ];
    }, $harga);

    $this->load->view('dashboard', $data);
  }
}
