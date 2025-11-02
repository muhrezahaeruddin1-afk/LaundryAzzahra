<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->helper(['url','number']);
    // require_login(); // dimatikan sesuai instruksi
  }

  public function index(){
    $data = [];
    $data['title']      = 'Dashboard';
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

    $kpi_masuk   = (int)($q->masuk   ?? 0);
    $kpi_proses  = (int)($q->proses  ?? 0);
    $kpi_selesai = (int)($q->selesai ?? 0);

    // Pendapatan hari ini (ambil transaksi terbaru per pesanan, hanya PAID)
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

    $kpi_pendapatan = (int)($sum->pendapatan ?? 0);

    // ====== Samakan nama variabel dengan yang dipakai di view ======
    $data['total_pelanggan']  = (int)$this->db->count_all('pelanggan');
    $data['pesanan_hari_ini'] = $kpi_masuk;
    $data['sedang_proses']    = $kpi_proses;
    $data['selesai_hari_ini'] = $kpi_selesai;
    $data['omzet_hari_ini']   = $kpi_pendapatan;

    // Daftar harga ringkas (8 layanan aktif)
    $harga = $this->db->query("
      SELECT nama, tipe_satuan, harga_per_satuan
      FROM layanan
      WHERE aktif=1
      ORDER BY id ASC
      LIMIT 8
    ")->result();

    $data['daftar_harga'] = array_map(function($r){
      return [
        'nama'   => $r->nama,
        'satuan' => '/'.$r->tipe_satuan,
        'harga'  => 'Rp '.number_format((int)$r->harga_per_satuan,0,',','.')
      ];
    }, $harga);

    // Pesanan terbaru (untuk tabel)
    $data['pesanan_terbaru'] = $this->db->order_by('tanggal_masuk','DESC')
                                        ->limit(5)->get('pesanan')->result();

    // ==== Render dengan layout ====
    $this->load->view('layouts/header',  $data);
    $this->load->view('layouts/sidebar', $data);
    $this->load->view('dashboard/index', $data);
    $this->load->view('layouts/footer');
  }
}
