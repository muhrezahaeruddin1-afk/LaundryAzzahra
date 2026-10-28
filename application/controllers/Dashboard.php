<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->helper(['url','number']);
        
        // TAMBAHKAN CEK LOGIN DI SINI
        if(!$this->session->userdata('logged_in')) {
            redirect('auth/login');
        }
    }

    public function index()
    {
        $data = [];
        $data['title']      = 'Dashboard';
        $data['nama_mitra'] = 'Laundry Azzahra';
        $data['alamat']     = 'Jln. Manuruki 2 No. 79, Makassar';

        // Tambahkan data user untuk ditampilkan di sidebar
        $data['user'] = array(
            'nama_lengkap' => $this->session->userdata('nama_lengkap'),
            'role' => $this->session->userdata('role')
        );

        $today = date('Y-m-d');

        /* -----------------------------
         * KPI status hari ini
         * ---------------------------*/
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

        /* ---------------------------------------------------------
         * Subquery transaksi terakhir per pesanan (dipakai berulang)
         * -------------------------------------------------------*/
        $sub_last_tx = "
            SELECT t1.*
            FROM transaksi t1
            JOIN (
            SELECT pesanan_id, MAX(id) AS max_id
            FROM transaksi
            GROUP BY pesanan_id
            ) s ON s.pesanan_id = t1.pesanan_id AND s.max_id = t1.id
        ";

        /* -----------------------------
         * Omzet hari ini (status_bayar = PAID)
         * ---------------------------*/
        $sum = $this->db->query("
            SELECT COALESCE(SUM(CASE WHEN t.status_bayar='PAID' THEN t.grand_total ELSE 0 END),0) AS pendapatan
            FROM pesanan p
            LEFT JOIN ($sub_last_tx) t ON t.pesanan_id = p.id
            WHERE DATE(p.tanggal_masuk)=?
        ", [$today])->row();

        $kpi_pendapatan = (int)($sum->pendapatan ?? 0);

        /* -----------------------------
         * Angka-angka untuk view
         * ---------------------------*/
        $data['total_pelanggan']  = (int)$this->db->count_all('pelanggan');
        $data['pesanan_hari_ini'] = $kpi_masuk;
        $data['sedang_proses']    = $kpi_proses;
        $data['selesai_hari_ini'] = $kpi_selesai;
        $data['omzet_hari_ini']   = $kpi_pendapatan;

        /* -----------------------------
         * Daftar harga ringkas (8 layanan aktif)
         * ---------------------------*/
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

        /* -----------------------------------------------------
         * Pesanan terbaru: ikut nama pelanggan + total terakhir
         * ---------------------------------------------------*/
        $data['pesanan_terbaru'] = $this->db->query("
            SELECT
            p.id,
            p.kode,
            COALESCE(pe.nama, '-') AS nama_pelanggan,
            p.status,
            COALESCE(t.grand_total, 0) AS total
            FROM pesanan p
            LEFT JOIN pelanggan pe ON pe.id = p.pelanggan_id
            LEFT JOIN ($sub_last_tx) t ON t.pesanan_id = p.id
            ORDER BY p.id DESC
            LIMIT 4
        ")->result();

        /* ---------------------------------------------
         * DATA CHART 7 HARI TERAKHIR
         * - jumlah pesanan per hari
         * - omzet PAID per hari (transaksi terakhir)
         * -------------------------------------------*/
        $rowsCount = $this->db->query("
            SELECT DATE(tanggal_masuk) d, COUNT(*) jml
            FROM pesanan
            WHERE tanggal_masuk >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
            GROUP BY DATE(tanggal_masuk)
        ")->result();

        $rowsOmzet = $this->db->query("
            SELECT DATE(p.tanggal_masuk) d,
                    COALESCE(SUM(CASE WHEN t.status_bayar='PAID' THEN t.grand_total ELSE 0 END),0) AS omzet
            FROM pesanan p
            LEFT JOIN ($sub_last_tx) t ON t.pesanan_id = p.id
            WHERE p.tanggal_masuk >= DATE_SUB(CURDATE(), INTERVAL 6 DAY)
            GROUP BY DATE(p.tanggal_masuk)
        ")->result();

        $mapCount = [];
        foreach ($rowsCount as $r) { $mapCount[$r->d] = (int)$r->jml; }
        $mapOmzet = [];
        foreach ($rowsOmzet as $r) { $mapOmzet[$r->d] = (int)$r->omzet; }

        $labels=[]; $counts=[]; $omzets=[];
        $period = new DatePeriod(new DateTime('-6 day'), new DateInterval('P1D'), 7);
        foreach ($period as $dt){
            $key = $dt->format('Y-m-d');
            $labels[] = $dt->format('d M');
            $counts[] = isset($mapCount[$key]) ? $mapCount[$key] : 0;
            $omzets[] = isset($mapOmzet[$key]) ? $mapOmzet[$key] : 0;
        }

        $data['chart_labels'] = $labels;
        $data['chart_counts'] = $counts;
        $data['chart_omzets'] = $omzets;

        /* -----------------------------
         * Render views
         * ---------------------------*/
        $this->load->view('layouts/header',  $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('dashboard/index', $data);
        $this->load->view('layouts/footer');
    }
}