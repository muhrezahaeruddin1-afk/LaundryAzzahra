<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

  /**
   * Buat transaksi UNPAID.
   */
  public function create_unpaid($pesanan_id, $total, $diskon = 0, $biaya = 0, $metode = 'CASH')
  {
    $grand = max(0, (int)$total - (int)$diskon + (int)$biaya);

    $this->db->insert('transaksi', [
      'pesanan_id'     => $pesanan_id,
      'total'          => $total,
      'diskon'         => $diskon,
      'biaya_tambahan' => $biaya,
      'grand_total'    => $grand,
      'metode'         => $metode,
      'status_bayar'   => 'UNPAID',
      'created_at'     => date('Y-m-d H:i:s')
    ]);

    return $this->db->insert_id();
  }

  /**
   * Tandai transaksi lunas (PAID)
   */
  public function set_paid($trx_id, $ref = null)
  {
    $this->db->where('id', $trx_id)->update('transaksi', [
      'status_bayar' => 'PAID',
      'qris_ref'     => $ref,
      'paid_at'      => date('Y-m-d H:i:s')
    ]);
  }

  /**
   * Ambil 1 transaksi by id
   */
  public function by_id($id)
  {
    return $this->db->get_where('transaksi', ['id' => $id])->row();
  }

  /**
   * Data lengkap untuk STRUK - SESUAIKAN DENGAN STRUKTUR TABEL
   */
  public function detail_for_receipt($trx_id)
  {
    // HEADER + PESANAN + PELANGGAN - SESUAI STRUKTUR TABEL
    $sql = "SELECT 
              t.*,
              p.kode,
              p.tanggal_masuk,
              p.tanggal_selesai_est,
              p.estimasi_selesai_jam,
              p.metode_terima,
              p.jarak_km,
              p.biaya_antar,
              p.status as status_pesanan,
              p.berat_kg,
              p.catatan,
              pel.nama AS nama_pelanggan,
              pel.telp,
              pel.alamat
            FROM transaksi t
            JOIN pesanan p ON p.id = t.pesanan_id
            LEFT JOIN pelanggan pel ON pel.id = p.pelanggan_id
            WHERE t.id = ?";

    $trx = $this->db->query($sql, [$trx_id])->row();

    if (!$trx) {
      return [null, []];
    }

    // DETAIL ITEM
    $items = $this->db->query(
      "SELECT 
          pd.qty, 
          pd.subtotal, 
          l.nama, 
          l.tipe_satuan,
          l.harga_per_satuan
       FROM pesanan_detail pd
       JOIN layanan l ON l.id = pd.layanan_id
       WHERE pd.pesanan_id = ?",
      [$trx->pesanan_id]
    )->result();

    return [$trx, $items];
  }

  /**
   * Ambil data untuk struk berdasarkan pesanan_id
   */
  public function detail_by_pesanan_id($pesanan_id)
  {
    // HEADER + PESANAN + PELANGGAN - SESUAI STRUKTUR TABEL
    $sql = "SELECT 
              t.*,
              p.kode,
              p.tanggal_masuk,
              p.tanggal_selesai_est,
              p.estimasi_selesai_jam,
              p.metode_terima,
              p.jarak_km,
              p.biaya_antar,
              p.status as status_pesanan,
              p.berat_kg,
              p.catatan,
              pel.nama AS nama_pelanggan,
              pel.telp,
              pel.alamat
            FROM pesanan p
            LEFT JOIN transaksi t ON p.id = t.pesanan_id
            LEFT JOIN pelanggan pel ON pel.id = p.pelanggan_id
            WHERE p.id = ?";

    $trx = $this->db->query($sql, [$pesanan_id])->row();

    if (!$trx) {
      return [null, []];
    }

    // DETAIL ITEM
    $items = $this->db->query(
      "SELECT 
          pd.qty, 
          pd.subtotal, 
          l.nama, 
          l.tipe_satuan,
          l.harga_per_satuan
       FROM pesanan_detail pd
       JOIN layanan l ON l.id = pd.layanan_id
       WHERE pd.pesanan_id = ?",
      [$pesanan_id]
    )->result();

    return [$trx, $items];
  }

  /**
   * Cek apakah transaksi ada
   */
  public function exists($trx_id)
  {
    return $this->db->get_where('transaksi', ['id' => $trx_id])->num_rows() > 0;
  }

  /**
   * Cek apakah pesanan ada
   */
  public function pesanan_exists($pesanan_id)
  {
    return $this->db->get_where('pesanan', ['id' => $pesanan_id])->num_rows() > 0;
  }

  /**
   * Ambil transaksi berdasarkan pesanan_id
   */
  public function get_by_pesanan_id($pesanan_id)
  {
    return $this->db->get_where('transaksi', ['pesanan_id' => $pesanan_id])->row();
  }
}