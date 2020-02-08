<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Surat_Mod extends CI_Model {
    
    
    public function upload_SRT_Msk($data){
     $this->db->insert('surat_masuk',$data);
     if($this->db->affected_rows()> 0){
         $this->db->select_max('id_surat_masuk');
         return $this->db->get('surat_masuk')->row();
     }else{
        return false;
        }
    }
    public function add_srt_msuk_diter($data){
        $this->db->insert('surat_masuk_diter',$data);
        if($this->db->affected_rows()> 0){
            return true;
        }else{
           return false;
           }
       }

    public function get_all_srtMSk(){
         $this->db->order_by('tgl_surat_masuk','DESC');
        return $this->db->get('surat_masuk')->result();
    }

    public function get_srtMSkBYID($id){
        return $this->db->get_where('surat_masuk',['id_surat_masuk'=> $id])->row();
    }

    public function get_srtMSkBYID_ter($id){
        return $this->db->get_where('surat_masuk_diter',['id_surat_masuk'=> $id])->result();
    }
}

?>