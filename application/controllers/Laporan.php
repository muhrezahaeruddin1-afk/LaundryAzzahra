<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends CI_Controller {

  public function __construct(){
    parent::__construct();
    $this->load->database();
    $this->load->helper(['url','form']);
  }

  public function index(){
    redirect('laporan/harian');
  }

  public function harian(){
    $tgl = $this->input->get('tanggal') ?: date('Y-m-d');

    $sub = "
      SELECT t1.*
      FROM transaksi t1
      JOIN (
        SELECT pesanan_id, MAX(id) AS max_id
        FROM transaksi
        GROUP BY pesanan_id
      ) latest ON latest.pesanan_id = t1.pesanan_id AND latest.max_id = t1.id
    ";

    $sum = $this->db->query("
      SELECT COUNT(p.id) AS jml_pesanan,
             SUM(CASE WHEN p.status='SELESAI' THEN 1 ELSE 0 END) AS jml_selesai,
             COALESCE(SUM(tt.grand_total),0) AS pendapatan
      FROM pesanan p
      LEFT JOIN ($sub) tt ON tt.pesanan_id = p.id AND tt.status_bayar='PAID'
      WHERE DATE(p.tanggal_masuk)=?
    ", [$tgl])->row();

    $rows = $this->db->query("
      SELECT p.kode, p.tanggal_masuk, p.status,
             pel.nama AS pelanggan, tt.metode, tt.status_bayar,
             COALESCE(tt.grand_total,0) AS total, p.id AS pesanan_id
      FROM pesanan p
      LEFT JOIN pelanggan pel ON pel.id = p.pelanggan_id
      LEFT JOIN ($sub) tt ON tt.pesanan_id = p.id
      WHERE DATE(p.tanggal_masuk)=?
      ORDER BY p.tanggal_masuk DESC
    ", [$tgl])->result();

    $data = [
      'title'   => 'Laporan Harian',
      'active'  => 'laporan',
      'tanggal' => $tgl,
      'sum'     => $sum,
      'rows'    => $rows,
    ];

    $this->load->view('partials/header', $data);
    $this->load->view('laporan_harian', $data);
    $this->load->view('partials/footer');
  }

  public function bulanan(){
    $bln = $this->input->get('bulan') ?: date('Y-m');

    $sub = "
      SELECT t1.*
      FROM transaksi t1
      JOIN (
        SELECT pesanan_id, MAX(id) AS max_id
        FROM transaksi
        GROUP BY pesanan_id
      ) latest ON latest.pesanan_id = t1.pesanan_id AND latest.max_id = t1.id
    ";

    $per_hari = $this->db->query("
      SELECT DATE(p.tanggal_masuk) AS tgl,
             COUNT(p.id) AS jml_pesanan,
             SUM(CASE WHEN p.status='SELESAI' THEN 1 ELSE 0 END) AS jml_selesai,
             COALESCE(SUM(CASE WHEN tt.status_bayar='PAID' THEN tt.grand_total ELSE 0 END),0) AS pendapatan
      FROM pesanan p
      LEFT JOIN ($sub) tt ON tt.pesanan_id = p.id
      WHERE DATE_FORMAT(p.tanggal_masuk,'%Y-%m')=?
      GROUP BY DATE(p.tanggal_masuk)
      ORDER BY tgl ASC
    ", [$bln])->result();

    $sum = $this->db->query("
      SELECT COUNT(p.id) AS jml_pesanan,
             SUM(CASE WHEN p.status='SELESAI' THEN 1 ELSE 0 END) AS jml_selesai,
             COALESCE(SUM(CASE WHEN tt.status_bayar='PAID' THEN tt.grand_total ELSE 0 END),0) AS pendapatan
      FROM pesanan p
      LEFT JOIN ($sub) tt ON tt.pesanan_id = p.id
      WHERE DATE_FORMAT(p.tanggal_masuk,'%Y-%m')=?
    ", [$bln])->row();

    $data = [
      'title'    => 'Laporan Bulanan',
      'active'   => 'laporan',
      'bulan'    => $bln,
      'per_hari' => $per_hari,
      'sum'      => $sum,
    ];

    $this->load->view('partials/header', $data);
    $this->load->view('laporan_bulanan', $data);
    $this->load->view('partials/footer');
  }
}
