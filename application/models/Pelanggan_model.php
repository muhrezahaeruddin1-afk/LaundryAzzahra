<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pelanggan_model extends CI_Model {

  // LIST semua pelanggan (opsional pakai keyword)
  public function all($keyword = null){
    if ($keyword) {
      $this->db->group_start()
               ->like('nama', $keyword)
               ->or_like('telp', $keyword)
               ->group_end();
    }
    return $this->db->order_by('nama','ASC')->get('pelanggan')->result();
  }

  public function by_id($id){
    return $this->db->get_where('pelanggan', ['id'=>$id])->row();
  }

  public function create($data){
    $this->db->insert('pelanggan', $data);
    return $this->db->insert_id();
  }

  public function update($id, $data){
    return $this->db->where('id',$id)->update('pelanggan',$data);
  }

  public function delete($id){
    return $this->db->delete('pelanggan', ['id'=>$id]);
  }

  // upsert: kalau ada pelanggan nama+telp sama → update alamat; kalau belum ada → insert
  public function upsert($nama, $telp, $alamat){
    if(!$nama && !$telp) return null;
    $row = $this->db->get_where('pelanggan', ['nama'=>$nama, 'telp'=>$telp])->row();
    if($row){
      $this->db->where('id',$row->id)->update('pelanggan',['alamat'=>$alamat]);
      return $row->id;
    }
    return $this->create(['nama'=>$nama,'telp'=>$telp,'alamat'=>$alamat]);
  }

  // Ringkasan + riwayat transaksi pelanggan
  public function summary_with_history($id){
    $info = $this->by_id($id);

    // total transaksi & nominal paid
    $sum = $this->db->query("
      SELECT COUNT(t.id) jml_transaksi,
             COALESCE(SUM(t.grand_total),0) total_belanja
      FROM transaksi t
      JOIN pesanan p ON p.id=t.pesanan_id
      WHERE p.pelanggan_id=? AND t.status_bayar='PAID'
    ", [$id])->row();

    // riwayat (terbaru dulu)
    $list = $this->db->query("
      SELECT p.id as pesanan_id, p.kode, p.tanggal_masuk, p.status,
             t.metode, t.status_bayar, t.grand_total
      FROM pesanan p
      LEFT JOIN transaksi t ON t.pesanan_id=p.id
      WHERE p.pelanggan_id=?
      ORDER BY p.tanggal_masuk DESC
    ", [$id])->result();

    return [$info,$sum,$list];
  }
}
