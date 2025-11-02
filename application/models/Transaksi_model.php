<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Transaksi_model extends CI_Model {

  /**
   * Buat transaksi UNPAID.
   * $total di sini adalah subtotal layanan + (tambahan lain kalau kamu sudah jumlahkan di controller)
   * $diskon = potongan harga
   * $biaya  = biaya tambahan (dipakai untuk Express di proyek kamu)
   */
  public function create_unpaid($pesanan_id, $total, $diskon = 0, $biaya = 0, $metode = 'CASH')
  {
    $grand = max(0, (int)$total - (int)$diskon + (int)$biaya);

    $this->db->insert('transaksi', [
      'pesanan_id'     => $pesanan_id,
      'total'          => $total,
      'diskon'         => $diskon,
      'biaya_tambahan' => $biaya,     // contoh: biaya express
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
   * Data lengkap untuk STRUK:
   * - Header transaksi (t.*)
   * - Info pesanan (antar/ambil, estimasi, jarak, biaya_antar, kode)
   * - Data pelanggan (nama, telp, alamat)
   * - Daftar item (nama layanan, tipe satuan, qty, subtotal)
   */
  public function detail_for_receipt($trx_id)
  {
    // HEADER + PESANAN + PELANGGAN
    $sql = "SELECT 
              t.*,
              p.kode,
              p.estimasi_selesai_jam,
              p.metode_terima,
              p.jarak_km,
              p.biaya_antar,
              pel.nama  AS nama_pelanggan,
              pel.telp,
              pel.alamat
            FROM transaksi t
            JOIN pesanan p      ON p.id  = t.pesanan_id
            LEFT JOIN pelanggan pel ON pel.id = p.pelanggan_id
            WHERE t.id = ?";

    $trx = $this->db->query($sql, [$trx_id])->row();

    if (!$trx) {
      // kalau id tidak ditemukan, kembalikan kosong biar view tidak error
      return [null, []];
    }

    // DETAIL ITEM (pakai pesanan_detail karena item melekat di pesanan)
    $items = $this->db->query(
      "SELECT 
          d.qty, 
          d.harga_satuan, 
          d.subtotal, 
          l.nama, 
          l.tipe_satuan
       FROM pesanan_detail d
       JOIN layanan l ON l.id = d.layanan_id
       WHERE d.pesanan_id = ?",
      [$trx->pesanan_id]
    )->result();

    return [$trx, $items];
  }

}
