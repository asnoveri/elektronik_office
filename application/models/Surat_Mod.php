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
}

?>