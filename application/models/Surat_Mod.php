<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_Mod extends CI_Model {
    
    
    public function upload_SRT_Msk($data){
     $this->db->insert('surat_masuk',$data);
     if($this->db->affected_rows()> 0){
         return true;
     }else{
        return false;
        }
    }

    public function get_all_srtMSk(){
        return $this->db->get('surat_masuk')->result();
    }

    public function get_srtMSkBYID($id){
        return $this->db->get_where('surat_masuk',['id_surat_masuk'=> $id])->row();
    }
}

?>