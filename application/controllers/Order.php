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


    // ============================================================
    // FORM PEMESANAN BARU
    // ============================================================
    public function baru(){
        $data = [
            'title'     => 'Pemesanan Baru',
            'active'    => 'pesanan',
            'layanan'   => $this->Layanan_model->all_active(),
            'pelanggan' => $this->Pelanggan_model->all()
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('order_form', $data);
        $this->load->view('layouts/footer');
    }


    // ============================================================
    // SIMPAN PESANAN BARU
    // ============================================================
    public function create(){

        // 1) VALIDASI
        if (empty($this->input->post('pelanggan_id'))) {
            $this->form_validation->set_rules('nama',   'Nama Pelanggan', 'trim|required');
            $this->form_validation->set_rules('telp',   'No. Telp',       'trim|required');
            $this->form_validation->set_rules('alamat', 'Alamat',         'trim|required');
        }

        $this->form_validation->set_rules('estimasi_selesai_jam', 'Estimasi Selesai (Jam)', 'required|integer|greater_than[0]');
        $this->form_validation->set_rules('metode_terima', 'Cara Terima', 'required');
        $this->form_validation->set_rules('metode', 'Metode Pembayaran', 'required');

        if ($this->input->post('metode_terima') === 'antar') {
            $this->form_validation->set_rules('jarak_km', 'Jarak (KM)', 'required|numeric|greater_than[0]');
        }

        if ($this->form_validation->run() === FALSE) {
            return $this->baru();
        }

        // 2) PELANGGAN
        $pelanggan_id = $this->input->post('pelanggan_id');
        if (!$pelanggan_id) {
            $pelanggan_id = $this->Pelanggan_model->upsert(
                $this->input->post('nama'),
                $this->input->post('telp'),
                $this->input->post('alamat')
            );
        }

        // 3) LAYANAN
        $items = [];
        $ids = (array)$this->input->post('layanan_id');
        $qty = (array)$this->input->post('qty');

        for ($i = 0; $i < count($ids); $i++) {
            if (!empty($ids[$i]) && floatval($qty[$i]) > 0) {
                $items[] = ['layanan_id' => $ids[$i], 'qty' => $qty[$i]];
            }
        }

        if (empty($items)) {
            $data = [
                'title'           => 'Pemesanan Baru',
                'active'          => 'pesanan',
                'layanan'         => $this->Layanan_model->all_active(),
                'pelanggan'       => $this->Pelanggan_model->all(),
                'error_manual'    => 'Minimal 1 layanan dan QTY > 0'
            ];
            $this->load->view('layouts/header', $data);
            $this->load->view('layouts/sidebar', $data);
            $this->load->view('order_form', $data);
            $this->load->view('layouts/footer');
            return;
        }

        // 4) BUAT PESANAN
        list($pesanan_id, $kode, $total_layanan) = $this->Pesanan_model->create(
            $pelanggan_id,
            $items,
            $this->input->post('berat_kg'),
            $this->input->post('catatan')
        );

        // 5) BIAYA TAMBAHAN
        $is_express    = $this->input->post('express') ? true : false;
        $biaya_express = $is_express ? 5000 : 0;

        $metode_terima = $this->input->post('metode_terima');
        $jarak_km      = (float)$this->input->post('jarak_km');
        $biaya_antar   = ($metode_terima === 'antar')
                        ? (int)(ceil($jarak_km) * 5000)
                        : 0;

        $grand_total = $total_layanan + $biaya_express + $biaya_antar;

        // Update data tambahan di pesanan
        $this->db->where('id', $pesanan_id)->update('pesanan', [
            'estimasi_selesai_jam' => (int)$this->input->post('estimasi_selesai_jam'),
            'metode_terima'        => $metode_terima,
            'jarak_km'             => $jarak_km,
            'biaya_antar'          => $biaya_antar
        ]);

        // Buat transaksi
        $metode_bayar = $this->input->post('metode');
        $trx_id = $this->Transaksi_model->create_unpaid($pesanan_id, $grand_total, 0, $biaya_express, $metode_bayar);

        if ($metode_bayar === 'CASH') {
            $this->Transaksi_model->set_paid($trx_id, 'CASH');
        }

        // 🔥 PERBAIKAN: Redirect dengan pesanan_id untuk konsistensi
        redirect('order/receipt/'.$pesanan_id);
    }


    // ============================================================
    // STRUK PEMBAYARAN - VERSI YANG DIPERBAIKI
    // ============================================================
    public function receipt($id){
        // $id bisa berupa pesanan_id atau trx_id (backward compatibility)
        $pesanan_id = null;
        $trx = null;
        $items = [];
        
        // Cek apakah ini pesanan_id
        $pesanan = $this->db->get_where('pesanan', ['id' => $id])->row();
        if($pesanan) {
            $pesanan_id = $id;
            // Gunakan method yang menerima pesanan_id
            list($trx, $items) = $this->Transaksi_model->detail_by_pesanan_id($pesanan_id);
        } else {
            // Cek apakah ini trx_id
            $transaksi = $this->db->get_where('transaksi', ['id' => $id])->row();
            if($transaksi) {
                $pesanan_id = $transaksi->pesanan_id;
                // Gunakan method yang menerima trx_id
                list($trx, $items) = $this->Transaksi_model->detail_for_receipt($id);
            } else {
                show_error('Data tidak ditemukan dengan ID: ' . $id, 404, 'Not Found');
                return;
            }
        }

        // Jika masih tidak ada data, coba ambil manual
        if(!$trx) {
            // Ambil data pesanan dengan join manual
            $this->db->select('p.*, pel.nama as nama_pelanggan, pel.telp, pel.alamat, t.metode, t.status_bayar, t.biaya_tambahan, t.diskon, t.grand_total');
            $this->db->from('pesanan p');
            $this->db->join('pelanggan pel', 'p.pelanggan_id = pel.id', 'left');
            $this->db->join('transaksi t', 'p.id = t.pesanan_id', 'left');
            $this->db->where('p.id', $pesanan_id);
            $trx = $this->db->get()->row();

            if(!$trx) {
                show_error('Data pesanan tidak ditemukan', 404, 'Not Found');
                return;
            }

            // Ambil items
            $this->db->select('pd.*, l.nama, l.tipe_satuan, l.harga_per_satuan');
            $this->db->from('pesanan_detail pd');
            $this->db->join('layanan l', 'pd.layanan_id = l.id', 'left');
            $this->db->where('pd.pesanan_id', $pesanan_id);
            $items = $this->db->get()->result();
        }

        $data = [
            'title'  => 'Struk Pembayaran',
            'active' => 'pesanan',
            'trx'    => $trx,
            'items'  => $items
        ];

        // 🔥 PERBAIKAN: Tambahkan header, sidebar, dan footer
        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('receipt', $data);
        $this->load->view('layouts/footer');
    }


    // ============================================================
    // TANDAI LUNAS (UNTUK QRIS)
    // ============================================================
    public function mark_paid($pesanan_id){
        $this->db->where('pesanan_id', $pesanan_id)
                 ->update('transaksi', [
                     'status_bayar' => 'PAID',
                     'paid_at' => date('Y-m-d H:i:s')
                 ]);
        redirect('order/receipt/'.$pesanan_id);
    }


    // ============================================================
    // TANDAI SELESAI - VERSI DIPERBAIKI
    // ============================================================
    public function done($pesanan_id){
        $this->db->where('id', $pesanan_id)
                 ->update('pesanan', ['status' => 'SELESAI']);
        redirect('order/receipt/'.$pesanan_id);
    }

    
    // ============================================================
    // INDEX → arahkan ke FORM PEMESANAN
    // ============================================================
    public function index(){
        redirect('order/baru');
    }


    // ============================================================
    // LIST PESANAN
    // ============================================================
    public function list(){
        $data = [
            'title'   => 'Daftar Pesanan',
            'active'  => 'pesanan',
            'pesanan' => $this->Pesanan_model->all_with_customer()
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        $this->load->view('order_list', $data);
        $this->load->view('layouts/footer');
    }


    // ============================================================
    // DEBUG METHOD
    // ============================================================
    public function debug($id = null){
        $data = [
            'title'  => 'Debug Data',
            'active' => 'pesanan'
        ];

        $this->load->view('layouts/header', $data);
        $this->load->view('layouts/sidebar', $data);
        
        echo "<div class='main-content'><div class='container'>";
        echo "<h2>DEBUG DATA</h2>";
        
        if($id) {
            echo "Testing ID: " . $id . "<br><br>";
            
            // Test sebagai pesanan_id
            echo "<h3>1. Sebagai Pesanan ID:</h3>";
            $pesanan = $this->db->get_where('pesanan', ['id' => $id])->row();
            echo $pesanan ? "✓ Ditemukan: " . $pesanan->kode : "✗ Tidak ditemukan";
            echo "<br>";
            
            // Test sebagai trx_id
            echo "<h3>2. Sebagai Transaksi ID:</h3>";
            $transaksi = $this->db->get_where('transaksi', ['id' => $id])->row();
            echo $transaksi ? "✓ Ditemukan: Pesanan ID " . $transaksi->pesanan_id : "✗ Tidak ditemukan";
        }
        
        echo "<hr><h3>Semua Pesanan:</h3>";
        $all = $this->db->get('pesanan')->result();
        foreach($all as $p) {
            echo "ID: " . $p->id . " | Kode: " . $p->kode . "<br>";
        }
        
        echo "<hr><h3>Semua Transaksi:</h3>";
        $all_trx = $this->db->get('transaksi')->result();
        foreach($all_trx as $t) {
            echo "ID: " . $t->id . " | Pesanan ID: " . $t->pesanan_id . " | Status: " . $t->status_bayar . "<br>";
        }
        
        echo "</div></div>";
        
        $this->load->view('layouts/footer');
        die();
    }
}