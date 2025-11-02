<?php
class Pesanan_model extends CI_Model {
  public function create($pelanggan_id,$items,$berat_kg=null,$catatan=null){
    $kode = 'AZ-'.date('Ymd').'-'.str_pad(rand(1,999),3,'0',STR_PAD_LEFT);
    $this->db->insert('pesanan', [
      'kode'=>$kode,'pelanggan_id'=>$pelanggan_id,
      'berat_kg'=>$berat_kg,'catatan'=>$catatan
    ]);
    $pesanan_id = $this->db->insert_id();

    $total = 0;
    foreach($items as $it){ // items: [ ['layanan_id'=>1,'qty'=>3], ... ]
      $lay = $this->db->get_where('layanan',['id'=>$it['layanan_id']])->row();
      $harga = (int)$lay->harga_per_satuan;
      $qty   = (float)$it['qty'];
      $sub   = (int)round($qty * $harga);
      $total += $sub;

      $this->db->insert('pesanan_detail', [
        'pesanan_id'=>$pesanan_id,
        'layanan_id'=>$it['layanan_id'],
        'qty'=>$qty,
        'harga_satuan'=>$harga,
        'subtotal'=>$sub
      ]);
    }
    return [$pesanan_id,$kode,$total];
  }
}
