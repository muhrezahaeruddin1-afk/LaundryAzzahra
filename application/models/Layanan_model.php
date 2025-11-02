<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Layanan_model extends CI_Model {

  public function all($only_active = false){
    if ($only_active) $this->db->where('aktif', 1);
    return $this->db->order_by('id','ASC')->get('layanan')->result();
  }

  public function all_active(){
    return $this->all(true);
  }

  public function by_id($id){
    return $this->db->get_where('layanan', ['id'=>$id])->row();
  }

  public function create($data){
    $this->db->insert('layanan', $data);
    return $this->db->insert_id();
  }

  public function update($id, $data){
    return $this->db->where('id',$id)->update('layanan', $data);
  }

  public function delete($id){
    return $this->db->delete('layanan', ['id'=>$id]);
  }

  public function toggle($id){
    $row = $this->by_id($id);
    if(!$row) return false;
    $new = $row->aktif ? 0 : 1;
    return $this->db->where('id',$id)->update('layanan', ['aktif'=>$new]);
  }
}
