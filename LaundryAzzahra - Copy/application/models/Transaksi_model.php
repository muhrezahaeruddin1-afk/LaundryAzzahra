<?php
class Transaksi_model extends CI_Model {
  public function create_unpaid($pesanan_id,$total,$diskon=0,$biaya=0,$metode='CASH'){
    $grand = max(0, $total - (int)$diskon + (int)$biaya);
    $this->db->insert('transaksi', [
      'pesanan_id'=>$pesanan_id,
      'total'=>$total,
      'diskon'=>$diskon,
      'biaya_tambahan'=>$biaya,
      'grand_total'=>$grand,
      'metode'=>$metode,
      'status_bayar'=>'UNPAID'
    ]);
    return $this->db->insert_id();
  }

  public function set_paid($trx_id,$ref=null){
    $this->db->where('id',$trx_id)->update('transaksi', [
      'status_bayar'=>'PAID',
      'qris_ref'=>$ref,
      'paid_at'=>date('Y-m-d H:i:s')
    ]);
  }

  public function by_id($id){
    return $this->db->get_where('transaksi',['id'=>$id])->row();
  }

  public function detail_for_receipt($trx_id){
    $sql = "SELECT t.*, p.kode, p.tanggal_masuk, pel.nama AS nama_pelanggan, pel.telp, pel.alamat
            FROM transaksi t
            JOIN pesanan p ON p.id=t.pesanan_id
            LEFT JOIN pelanggan pel ON pel.id=p.pelanggan_id
            WHERE t.id=?";
    $trx = $this->db->query($sql, [$trx_id])->row();

    $items = $this->db->query(
      "SELECT d.qty, d.harga_satuan, d.subtotal, l.nama, l.tipe_satuan
       FROM pesanan_detail d JOIN layanan l ON l.id=d.layanan_id
       WHERE d.pesanan_id=?", [$trx->pesanan_id])->result();

    return [$trx,$items];
  }
}
